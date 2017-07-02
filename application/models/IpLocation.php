<?php

    /*
    *
    * @model: IpLocation
    * Model do lokalizowania użytkownika po adresie IP.
    *
    */

class IpLocation extends CI_Model {

    /**
    *
    * @function: locate
    * Funkcja zwraca tablice z krajem, regionem i miastem w przypadku sukcesu, false w przypadku błędu. 
    *
    */

    public function locate ($input) {


        // adres IPV4 Decimal
        if ($this->isIpv4Decimal ($input)) {
            $input = long2ip ($input);
        }

        // adres IPV6 Decimal
        if ($this->isIpv6Decimal ($input)) {
            $input = long2ip ($input);
        }

        // hostname/domena
        if ($this->isHostname ($input)) {
            $input = gethostbyname ($input);
        }

        // adres IPV4
        if ($this->isIpv4 ($input)) {
            $decimal_ip = ip2long ($input);

            $this->db->from ('ipv4');
            $this->db->where ('ip_from <=', $decimal_ip);
            $this->db->order_by ('ip_from', 'desc');
            $this->db->limit (1, 0);

            $query = $this->db->get ();

            if ($query->num_rows () != 0) {

                $result = $query->result_array ()[0];

                $result['ip_from'] = long2ip ($result['ip_from']);
                $result['ip_to']   = long2ip ($result['ip_to']);

                return $result;
            }

            return false;
        }

        // adres IPV6
        if ($this->isIpv6 ($input)) {
            $decimal_ip = $this->ipv6ToDecimal ($input);

            $this->db->from ('ipv6');
            $this->db->where ('ip_from <=', $decimal_ip);
            $this->db->order_by ('ip_from', 'desc');
            $this->db->limit (1, 0);

            $query = $this->db->get ();

            if ($query->num_rows () != 0) {

                $result = $query->result_array ()[0];

                $result['ip_from'] = $this->decimalToIpv6 ($result['ip_from']);
                $result['ip_to']   = $this->decimalToIpv6 ($result['ip_to']);

                return $result;
            }

            return false;


        }

        return false;
    }

    /**
    *
    * @function: isIpv4Decimal
    * Funkcja  sprawdza czy to numer ipv4 w zapisie dziesiętnym.
    *
    */

    public function isIpv4Decimal ($input) {

        return is_numeric ($input) AND $input <= 4294967296;
    }

    /**
    *
    * @function: isIpv6Decimal
    * Funkcja  sprawdza czy to numer ipv6 w zapisie dziesiętnym.
    *
    */

    public function isIpv6Decimal ($input) {

        return is_numeric ($input) AND $input > 4294967296;
    }

    /**
    *
    * @function: isIpv4
    * Funkcja  sprawdza czy to numer ipv4.
    *
    */

    public function isIpv4 ($input) {

        return filter_var ($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
    *
    * @function: isIpv4
    * Funkcja sprawdza czy to numer ipv6.
    *
    */

    public function isIpv6 ($input) {

        return filter_var ($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    /**
    *
    * @function: isHostname
    * Funkcja sprawdza czy to nazwa domeny.
    *
    */

    public function isHostname ($input) {

        return filter_var ($input, FILTER_VALIDATE_DOMAIN);
    }

    /**
    *
    * @function: decimalToIpv6
    * Funkcja konwerująca liczbę dziesiętną do adresu ip.
    *
    */

    public function decimalToIpv6 ($input) {

        $parts = array();

        $parts[1] = bcdiv ($input, '79228162514264337593543950336', 0);
        $input    = bcsub ($input, bcmul ($parts[1], '79228162514264337593543950336'));
        $parts[2] = bcdiv ($input, '18446744073709551616', 0);
        $input    = bcsub ($input, bcmul ($parts[2], '18446744073709551616'));
        $parts[3] = bcdiv ($input, '4294967296', 0);
        $input    = bcsub ($input, bcmul ($parts[3], '4294967296'));
        $parts[4] = $input;

        foreach ($parts as &$part)  
            if ($part > 2147483647)
                $part -= 4294967296;

        $ip = inet_ntop (pack ('N4', $parts[1], $parts[2], $parts[3], $parts[4]));

        if (strpos ($ip, '.') !== false)
            return substr ($ip, 2);

        return $ip; 
    }

    /**
    *
    * @function: ipv6ToDecimal
    * Funkcja konwerująca adres ip do liczby dziesiętnej.
    *
    */

    function ipv6ToDecimal ($input) {

        $parts = unpack('N*', inet_pton ($input));

        if (strpos ($input, '.') !== false)
            $parts = array (1=>0, 2=>0, 3=>0, 4=>$parts[1]);

        foreach ($parts as &$part)
            if ($part < 0)
                $part += 4294967296;

        $decimal = $parts[4];
        $decimal = bcadd ($decimal, bcmul ($parts[3], '4294967296'));
        $decimal = bcadd ($decimal, bcmul ($parts[2], '18446744073709551616'));
        $decimal = bcadd ($decimal, bcmul ($parts[1], '79228162514264337593543950336'));

        return $decimal;
    }

}
