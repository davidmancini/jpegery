DROP TABLE IF EXISTS follower;
DROP TABLE IF EXISTS imageTag;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS imageTag;


CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName VARCHAR (128),
	email VARCHAR(128),
	PRIMARY KEY(profileId)
);
CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageType VARCHAR(128) NOT NULL,
	imageFileName VARCHAR(128) NOT NULL UNIQUE,
	imageText VARCHAR(500),
	INDEX(profileId),
	FOREIGN KEY(imageProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(imageId)
	);

CREATE TABLE tag (
	tagId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	tagName VARCHAR(64) NOT NULL,
	PRIMARY KEY(tagId)
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

CREATE TABLE vote (
	profileId INT UNSIGNED NOT NULL,
	imageId INT UNSIGNED NOT NULL,
	voteValue BIT NOT NULL,
	INDEX(profileId),
	INDEX(imageId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId),
	FOREIGN KEY(imageId) REFERENCES image(imageId),
	PRIMARY KEY(profileId, imageId)
);

CREATE TABLE imageTag (
	imageId INT UNSIGNED NOT NULL,
	tagId INT UNSIGNED NOT NULL,
	INDEX(imageId),
	INDEX(tagId),
	FOREIGN KEY(imageId) REFERENCES image(imageId),
	FOREIGN KEY(tagId) REFERENCES tag(tagId),
	PRIMARY KEY(imageId, tagId)

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

-- CREATE TABLE item (
-- 	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
-- 	profileId INT UNSIGNED NOT NULL,
-- 	itemDescription VARCHAR(2000) NOT NULL,
-- 	images VARCHAR (64),
-- 	email VARCHAR (128) NOT NULL,
-- 	price INT UNSIGNED,
-- 	location VARCHAR (64) NOT NULL,
-- 	PRIMARY KEY(itemId),
-- 	FOREIGN KEY(profileId) REFERENCES profile(profileId)
-- );
-- This needs to be in correct order.  I just needed to add my table so I could work on my Class file.
-- If you need to change the Image table, let me know so I can update my Class.  -David

