/* tables */
DROP TABLE IF EXISTS wcf1_tracking_goal;
CREATE TABLE wcf1_tracking_goal (
	trackingGoalID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	goalName VARCHAR (255) NOT NULL,
	packageID INT(10) NOT NULL,
	description varchar(255) NOT NULL DEFAULT '',
	isDisabled TINYINT(1) NOT NULL DEFAULT 1,
	trackingID INT(10) NULL DEFAULT NULL
);

DROP TABLE IF EXISTS wcf1_tracking_provider;
CREATE TABLE wcf1_tracking_provider (
	trackingProviderID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	providerName VARCHAR(255) NOT NULL,
	className varchar(255) NOT NULL,
	isDisabled TINYINT(1) NOT NULL DEFAULT 0,
	trackingURL VARCHAR(255) NULL DEFAULT NULL,
	trackingID INT(10) NULL DEFAULT NULL
);

/* foreign keys */
ALTER TABLE wcf1_tracking_goal ADD FOREIGN KEY (packageID) REFERENCES wcf1_package (packageID) ON DELETE CASCADE;
