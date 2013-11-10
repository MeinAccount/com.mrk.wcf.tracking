/* tables */
DROP TABLE IF EXISTS wcf1_tracking_provider;
CREATE TABLE wcf1_tracking_provider (
	trackingProviderID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	providerName VARCHAR(255) NOT NULL DEFAULT '',
	className varchar(255) NOT NULL DEFAULT '',
	isDisabled TINYINT(1) NOT NULL DEFAULT 0,
	trackingURL VARCHAR(255) NULL DEFAULT NULL,
	trackingID INT(10) NULL DEFAULT NULL
);
