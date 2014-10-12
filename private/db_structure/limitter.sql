
CREATE TABLE `limitter` (
  `ip` bigint(20) NOT NULL,
  `timestamp` int(11) NOT NULL,
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
