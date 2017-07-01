CREATE TABLE `ipv6` (
  `ip_from` varbinary(16) NOT NULL DEFAULT '0',
  `ip_to` varbinary(16) NOT NULL,
  `country` varchar(32) COLLATE utf8_bin NOT NULL,
  `region` varchar(128) COLLATE utf8_bin NOT NULL,
  `city` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ip_from`,`ip_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
