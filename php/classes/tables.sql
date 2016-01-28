DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS comment;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName VARCHAR (128),

	email VARCHAR(128),
	PRIMARY KEY(userId)
)

CREATE TABLE item (
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userId INT UNSIGNED NOT NULL,
	itemDescription VARCHAR(2000) NOT NULL,
	images VARCHAR (64),
	email VARCHAR (128) NOT NULL,
	price INT UNSIGNED,
	location VARCHAR (64) NOT NULL,
	PRIMARY KEY(itemId),
	FOREIGN KEY(userId) REFERENCES user(userId)
);
