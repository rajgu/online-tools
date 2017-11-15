<?php

Class LogsMaker extends CI_Model {

    private $SPACER = ' ';

    private $METHODS = array (
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD'
    );

    private $RESPONSE_CODES = array (
        '200', '200', '200', '200', '404', '404', '301', '302', '500'
    );

    private $NAMES = array (
        'adelajda','adrianna','agnieszka','alicja','anastazja','angelika','ania','aniela','anka','apolonia','asia','augustyna','beata','beatrycze','benedykta','berta','blanka','bogumiła','bogusława','bolesława','bożena','bronisława','brygida','cecylia','celestyna','celina','czesława','danuta','dita','dobrosława','dominika','dyta','edyta','ela','eligia','elżbieta','ewa','felicja','felicyta','franciszka','fryderyka','gabrjela','gabryjela','gabrysia','genowefa','gertruda','gracja','grażyna','halina','henrieta','henryka','honorata','irena','irenka','iwona','izabella','izolda','jadwiga','jadzia','jagoda','jarosława','joasia','jolanta','jolenta','jowita','judyta','julianna','julita','julitta','justyna','józefa','kaja','karina','karolina','kasia','kassia','katarzyna','kazia','kazimiera','kinga','klara','klaudia','klementyna','konstancja','kornelia','krysia','krystiana','krystyna','ksenia','kunegunda','lechosława','leokadia','lesława','lidia','longina','ludmita','ludmiła','ludwika','luiza','malina','malwina','marcelina','martyna','maryla','marzena','matylda','małgorzata','michalina','mieczysława','mirosława','nadzieja','nastusia','natasza','oliwia','patrycja','radomiła','radosława','roksana','rościsława','ruta','róża','salomea','sara','serafina','seweryna','sobiesława','stanisława','stefania','stefcia','sylwia','sławomira','tekla','teodozja','urszula','wacława','walentyna','waleria','wera','weronika','wiesława','wiga','wiktoria','wiola','wioletta','wisia','wisława','wojciecha','władysława','yetta','zdzisława','zofia','zoja','zosia','zuzanna','złota'
    );

    private $SURNAMES = array (
        'adamczyk','bak','baran','blaszczyk','cieslak','dabrowska','dabrowski','duda','dudek','gorski','grabowska','grabowski','jablonska','jablonski','janik','jankowska','jankowski','jarosz','jaworska','jaworski','kaczmarczyk','kaczmarek','kaminska','kaminski','kania','kazmierczak','kolodziej','kolodziejczyk','kowalczyk','kowalik','kowalska','kowalski','kozak','koziol','kozlowska','kozlowski','krawczyk','krol','krupa','kubiak','kwiatkowska','kwiatkowski','lewandowska','lewandowski','lis','majewska','majewski','malinowska','malinowski','marciniak','markiewicz','mazur','mazurek','michalak','michalska','michalski','mikolajczyk','mroz','mucha','musial','nowak','nowakowska','nowakowski','nowicka','nowicki','olszewska','olszewski','pawlak','pawlowska','pawlowski','pietrzak','piotrowski','piotrowska','piotrowski','sikora','sobczak','stepien','szczepaniak','szewczyk','szulc','szymanska','szymanski','szymczak','tomczak','walczak','wawrzyniak','wieczorek','wilk','wisniewska','wisniewski','wlodarczyk','wojciechowska','wojciechowski','wojcik','wojtowicz','wozniak','wrobel','zajac','zielinska','zielinski'
    );

    private $EXTENSIONS = array (
        '.jpg','.png', '.html', '.tiff', '.phtml', '.php', '.php4', '.php5', '.pl', '.asp', '.aspx', 'py'
    );

    private $RESOURCES = array (
        'browse','page','view','site','category','article','list','wp-content','wp-admin','explore','search','tag','app','main','post','posts','categories','apps','cart','id'
    );

    private $AGENTS = array (
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/604.1.38(KHTML,likeGecko)Version/11.0Safari/604.1.38',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13)AppleWebKit/604.1.38(KHTML,likeGecko)Version/11.0Safari/604.1.38',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(X11;Ubuntu;Linuxx86_64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_0)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_11_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT6.3;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;WOW64;Trident/7.0;rv:11.0)likeGecko',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.89Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10.12;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/52.0.2743.116Safari/537.36Edge/15.15063',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/604.3.5(KHTML,likeGecko)Version/11.0.1Safari/604.3.5',
        'Mozilla/5.0(WindowsNT6.1)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.62Safari/537.36',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_1)AppleWebKit/604.3.5(KHTML,likeGecko)Version/11.0.1Safari/604.3.5',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;WOW64;Trident/7.0;rv:11.0)likeGecko',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.62Safari/537.36',
        'Mozilla/5.0(X11;Linuxx86_64;rv:52.0)Gecko/20100101Firefox/52.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_1)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_10_5)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/60.0.3112.113Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.89Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;WOW64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(WindowsNT10.0;WOW64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.62Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10.11;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_5)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64;rv:57.0)Gecko/20100101Firefox/57.0',
        'Mozilla/5.0(WindowsNT6.3;Win64;x64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.62Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_11_6)AppleWebKit/604.1.38(KHTML,likeGecko)Version/11.0Safari/604.1.38',
        'Mozilla/5.0(X11;Linuxx86_64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/603.3.8(KHTML,likeGecko)Version/10.1.2Safari/603.3.8',
        'Mozilla/5.0(Macintosh;IntelMacOSX10.13;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_10_5)AppleWebKit/603.3.8(KHTML,likeGecko)Version/10.1.2Safari/603.3.8',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36OPR/48.0.2685.52',
        'Mozilla/5.0(iPad;CPUOS11_0_3likeMacOSX)AppleWebKit/604.1.38(KHTML,likeGecko)Version/11.0Mobile/15A432Safari/604.1',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.89Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;Trident/7.0;rv:11.0)likeGecko',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/51.0.2704.79Safari/537.36Edge/14.14393',
        'Mozilla/5.0(WindowsNT6.1;WOW64;rv:52.0)Gecko/20100101Firefox/52.0',
        'Mozilla/5.0(WindowsNT6.1;WOW64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_11_6)AppleWebKit/604.3.5(KHTML,likeGecko)Version/11.0.1Safari/604.3.5',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/58.0.3029.110Safari/537.36Edge/16.16299',
        'Mozilla/5.0(X11;Linuxx86_64;rv:57.0)Gecko/20100101Firefox/57.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_10_3)AppleWebKit/600.5.17(KHTML,likeGecko)Version/8.0.5Safari/600.5.17',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.89Safari/537.36',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)UbuntuChromium/61.0.3163.100Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;rv:52.0)Gecko/20100101Firefox/52.0',
        'Mozilla/5.0(WindowsNT10.0)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36OPR/48.0.2685.39',
        'Mozilla/5.0(WindowsNT10.0;WOW64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;WOW64;Trident/7.0;Touch;rv:11.0)likeGecko',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_1)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.89Safari/537.36',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/60.0.3112.113Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_0)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64;rv:50.0)Gecko/20100101Firefox/50.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_4)AppleWebKit/537.36(KHTML,likeGecko)Chrome/61.0.3163.100Safari/537.36',
        'Mozilla/5.0(compatible;MSIE9.0;WindowsNT6.0;Trident/5.0;Trident/5.0)',
        'Mozilla/5.0(compatible;MSIE9.0;WindowsNT6.1;Trident/5.0;Trident/5.0)',
        'Mozilla/5.0(WindowsNT10.0;WOW64;rv:55.0)Gecko/20100101Firefox/55.0',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/51.0.2704.106Safari/537.36',
        'Mozilla/5.0(WindowsNT6.1;Win64;x64;rv:52.0)Gecko/20100101Firefox/52.0',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/59.0.3071.115Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10.10;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_12_6)AppleWebKit/537.36(KHTML,likeGecko)Chrome/60.0.3112.113Safari/537.36',
        'Mozilla/5.0(Macintosh;IntelMacOSX10_13_0)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.62Safari/537.36',
        'Mozilla/5.0(WindowsNT10.0;WOW64;rv:52.0)Gecko/20100101Firefox/52.0',
        'Mozilla/5.0(WindowsNT6.3;Win64;x64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/62.0.3202.75Safari/537.36',
        'Mozilla/5.0(WindowsNT6.3;WOW64;rv:56.0)Gecko/20100101Firefox/56.0',
        'Mozilla/5.0(X11;Linuxx86_64)AppleWebKit/537.36(KHTML,likeGecko)Chrome/60.0.3112.78Safari/537.36'
    );

    public function __construct () {

        $this->SIZE_METHODS        = sizeof ($this->METHODS) - 1;
        $this->SIZE_RESPONSE_CODES = sizeof ($this->RESPONSE_CODES) - 1;
        $this->SIZE_NAMES          = sizeof ($this->NAMES) - 1;
        $this->SIZE_SURNAMES       = sizeof ($this->SURNAMES) - 1;
        $this->SIZE_EXTENSIONS     = sizeof ($this->EXTENSIONS) - 1;
        $this->SIZE_RESOURCES      = sizeof ($this->RESOURCES) - 1;
        $this->SIZE_AGENTS         = sizeof ($this->AGENTS) - 1;
    }

    private function id () {

        return rand (0, 65536);
    }

    public function ipv4 () {

        return rand (1, 255) . '.' . rand (1, 255) . '.' . rand (1, 255) . '.' . rand (1,255);
    }

    public function date () {

        return date ("Y-m-d H:i:s", time () - rand (0, 36840));
    }

    public function user () {

        return (rand (1,2) % 2 == 0) ? $this->NAMES[rand (0, $this->SIZE_NAMES)] . '.' . $this->SURNAMES[rand (0, $this->SIZE_SURNAMES)] : '-';
    }

    public function method () {

        return $this->METHODS[rand (0, $this->SIZE_METHODS)];
    }

    public function response_code () {

        return $this->RESPONSE_CODES[rand (0, $this->SIZE_RESPONSE_CODES)];   
    }

    public function response_size () {

        return $this->id ();
    }

    public function user_agent () {

        return $this->AGENTS[rand (0, $this->SIZE_AGENTS)];
    }

    public function adress () {

        return
            '/' .
            ((rand (1, 2) % 2 == 0) ? $this->RESOURCES[rand (0, $this->SIZE_RESOURCES)] . '/' : '') .
            ((rand (1, 2) % 2 == 0) ? (string) $this->id () . '/' : '') .
            ((rand (1, 2) % 2 == 0) ? $this->RESOURCES[rand (0, $this->SIZE_RESOURCES)] . '/' : '') .
            ((rand (1, 2) % 2 == 0) ? (string) $this->id () . '/' : '') .
            $this->RESOURCES[rand (0, $this->SIZE_RESOURCES)] .
            $this->EXTENSIONS[rand (0, $this->SIZE_EXTENSIONS)];
    }

    public function referer () {

        return
            '/' .
            ((rand (1, 2) % 2 == 0) ? $this->RESOURCES[rand (0, $this->SIZE_RESOURCES)] . '/' : '') .
            ((rand (1, 2) % 2 == 0) ? $this->id () . '/' : '') .
            $this->RESOURCES[rand (0, $this->SIZE_RESOURCES)];
    }

     public function log () {

        return
            $this->ipv4 () . $this->SPACER .
            $this->date () . $this->SPACER .
            $this->user () . $this->SPACER .
            $this->method () . $this->SPACER .
            $this->response_code () . $this->SPACER .
            $this->response_size () . $this->SPACER .
            $this->adress () . $this->SPACER .
            $this->referer () . $this->SPACER .
            $this->user_agent ();
     }

}