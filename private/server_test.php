<?php

print ("Server test\n");
print ("\n");

// sudo apt-get install php7.0-intl
print ("IDN Extension:\n");
idn_to_utf8 ("dupa");
print ("OK\n");

// sudo apt-get install php7.0-curl
print ("Curl Extension:\n");
curl_multi_init ();
print ("OK\n");

// sudo apt install php7.0-bcmath
print ("BCMath Extension:\n");
bcadd ('10000000', '100000000000');
print ("OK\n");