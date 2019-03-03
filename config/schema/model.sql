CREATE TABLE users (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(32) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL DEFAULT '',
	`first_name` VARCHAR(64) NOT NULL DEFAULT '',
	`last_name` VARCHAR(64) NOT NULL DEFAULT '',
	`phone` VARCHAR(64) NULL,
	`access_level` INTEGER NOT NULL DEFAULT '0',
	`locked` TINYINT(1) NOT NULL DEFAULT 0,
	`reset_token` VARCHAR(255) NULL,
	`reset_time` DATETIME NULL,
	`language` VARCHAR(8) DEFAULT 'en' NOT NULL,
	`country` VARCHAR(8) DEFAULT 'us' NOT NULL,
	`last_login` DATE,
	`email` VARCHAR(64) NOT NULL UNIQUE,
	`created` DATETIME,
	`modified` DATETIME,
	`active` TINYINT(1) NOT NULL DEFAULT 1,
	`order_token` VARCHAR(255) NULL,
	`pickup_confirmed` TINYINT(1) NOT NULL DEFAULT 0
	PRIMARY KEY (id)
);

CREATE TABLE cookies (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL UNIQUE,
	`not_for_delivery` TINYINT(1) NOT NULL DEFAULT 0,
	`price` DECIMAL NOT NULL,
	`boxes_per_case` INT NOT NULL,
	PRIMARY KEY (id)
);

Create Table orders ( 
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`cookie_id` INT NULL REFERENCES cookies(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`quantity` INT NOT NULL,
	`digital` TINYINT(1) NOT NULL DEFAULT 0,
	`created` DATETIME,
	PRIMARY KEY (id)
)

INSERT INTO cookies (name, price) VALUES ('Thin Mints', 5);
INSERT INTO cookies (name, price) VALUES ('Samoas', 5);
INSERT INTO cookies (name, price) VALUES ('Smores', 5);
INSERT INTO cookies (name, price) VALUES ('Tagalongs', 5);
INSERT INTO cookies (name, price) VALUES ('Do-si-dos', 5);
INSERT INTO cookies (name, price) VALUES ('Samoas', 5);
INSERT INTO cookies (name, price) VALUES ('Savannah Smiles', 5);
INSERT INTO cookies (name, price) VALUES ('Thanks-A-Lot', 5);
INSERT INTO cookies (name, price) VALUES ('Toffee-tastic', 5);
INSERT INTO cookies (name, price) VALUES ('Caramel Chocolate Chip', 5);
INSERT INTO cookies (name, price) VALUES ('Lemonades', 5);

