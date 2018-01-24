CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profilePhone VARCHAR(32),
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)
);

CREATE TABLE blog (
	blogId        BINARY(16)   NOT NULL,
	blogProfileId BINARY(16)   NOT NULL,
	blogContent   VARCHAR(265890) NOT NULL,
	blogDate      DATETIME(6)  NOT NULL,
	INDEX (blogProfileId),
	PRIMARY KEY (blogId),
	FOREIGN KEY (blogProfileId) REFERENCES profile (profileId)
);

CREATE TABLE clap (
	clapProfileId BINARY(16) NOT NULL,
	clapBlogID BINARY(16) NOT NULL,
	clapId DATETIME(6) NOT NULL,
	INDEX (clapProfileId),
	FOREIGN KEY (clapProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (clapBlogId) REFERENCES blog (blogId),
	PRIMARY KEY (clapId)
);




