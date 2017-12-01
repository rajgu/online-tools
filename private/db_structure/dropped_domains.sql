CREATE TABLE dropped_domains (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	name VARCHAR(255),
	name_idn VARCHAR(255),
	extension VARCHAR(16),
	date_dropped DATETIME,
	FULLTEXT (name)
) Engine=InnoDB