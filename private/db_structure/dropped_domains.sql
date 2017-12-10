CREATE TABLE dropped_domains (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255),
  name_idn VARCHAR(255),
  extension VARCHAR(16),
  date_dropped DATETIME,
  UNIQUE KEY `uniq` (`name`),
  FULLTEXT `name` (`name`)
) Engine=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;