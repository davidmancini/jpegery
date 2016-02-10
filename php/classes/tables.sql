DROP TABLE IF EXISTS follower;
DROP TABLE IF EXISTS imageTag;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS profile;


CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileAdmin BIT NOT NULL,
	profileCreateDate DATETIME NOT NULL,
	profileEmail VARCHAR(32) NOT NULL,
	profileHandle VARCHAR(32) NOT NULL,
	profileHash VARCHAR(32) NOT NULL,
	profileImageId INT UNSIGNED,
	profileName VARCHAR(32),
	profilePhone VARCHAR(16),
	profileSalt VARCHAR(32),
	profileVerify BIT,
	PRIMARY KEY(profileId)
);
CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId INT UNSIGNED NOT NULL,
	imageDate DATETIME NOT NULL,
	imageFileName VARCHAR(128) NOT NULL UNIQUE,
	imageText VARCHAR(500),
	imageType VARCHAR(128) NOT NULL,
	INDEX(imageProfileId),
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
	commentDate DATETIME NOT NULL,
	commentText VARCHAR(1023) NOT NULL,
	INDEX(commentProfileId),
	INDEX(commentImageId),
	FOREIGN KEY(commentProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(commentImageId) REFERENCES image(imageId),
	PRIMARY KEY(commentId)
);

CREATE TABLE vote (
	voteProfileId INT UNSIGNED NOT NULL,
	voteImageId INT UNSIGNED NOT NULL,
	voteValue BIT NOT NULL,
	INDEX(voteProfileId),
	INDEX(voteImageId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteImageId) REFERENCES image(imageId),
	PRIMARY KEY(voteProfileId, voteImageId)
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
	followerFollowerId INT UNSIGNED NOT NULL,
	followerFollowedId INT UNSIGNED NOT NULL,
	INDEX(followerFollowerId),
	INDEX(followerFollowedId),
	FOREIGN KEY(followerFollowerId) REFERENCES profile(profileId),
	FOREIGN KEY(followerFollowedId) REFERENCES profile(profileId),
	PRIMARY KEY(followerFollowerId, followerFollowedId)
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

