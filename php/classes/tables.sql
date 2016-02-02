DROP TABLE IF EXISTS follower;
DROP TABLE IF EXISTS imagetag;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS profile;


CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName VARCHAR (128),
	email VARCHAR(128),
	PRIMARY KEY(profileId)
);

CREATE TABLE comment (
	commentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentImageId INT UNSIGNED NOT NULL,
	commentProfileId INT UNSIGNED NOT NULL,
	commentText VARCHAR(1023) NOT NULL,
	commentDate DATETIME NOT NULL,
	INDEX(profileId),
	INDEX(imageId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId),
	FOREIGN KEY(imageId) REFERENCES image(imageId),
	PRIMARY KEY(commentId)

);

CREATE TABLE item (
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	itemDescription VARCHAR(2000) NOT NULL,
	images VARCHAR (64),
	email VARCHAR (128) NOT NULL,
	price INT UNSIGNED,
	location VARCHAR (64) NOT NULL,
	PRIMARY KEY(itemId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

CREATE TABLE follower (
	followerId INT UNSIGNED NOT NULL,
	followedId INTE UNSIGNED NOT NULL,
	INDEX(followerId),
	INDEX(followedId),
	FOREIGN KEY(followerId) REFERENCES profile(profileId),
	FOREIGN KEY(followedId) REFERENCES profile(profileId),
	PRIMARY KEY(followerId, followedId)
);

-- This needs to be in correct order.  I just needed to add my table so I could work on my Class file.
-- If you need to change the Image table, let me know so I can update my Class.  -David

CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageType VARCHAR(128) NOT NULL,
	imageFileName VARCHAR(128) NOT NULL UNIQUE,
	imageText VARCHAR(500),
	PRIMARY KEY(imageId),
	FOREIGN KEY(imageProfileId) REFERENCES profile(profileId);