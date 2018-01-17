CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profilePhone VARCHAR(32),
	profileHash     CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)
);

CREATE TABLE blog (
	blogId BINARY(16) NOT NULL,
	blogProfileId  BINARY(16) NOT NULL,
	blogContent VARCHAR(140) NOT NULL,
	blogDate DATETIME (6) NOT NULL,
	profileId int,
	PRIMARY KEY(blogId),
	FOREIGN KEY (profileId) REFERENCES profile(profileId)

);

CREATE TABLE clap (
	clapProfileId BINARY(16) NOT NULL,
	clapBlogID BINARY(16) NOT NULL,
	clapId DATETIME(6) NOT NULL,
	INDEX (clapProfileId) ,
	INDEX (clapBlogId),
	FOREIGN KEY(clapProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(clapBlogId) REFERENCES blog(blogId),
	PRIMARY KEY(clapProfileId, clapBlogId)
);


