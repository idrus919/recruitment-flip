CREATE DATABASE flip;

use flip;

CREATE TABLE `Disburse` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	`amount` INT,
	`status` ENUM('0','1','3','') COMMENT '0 = pending, 1 = success, 3 = reject',
	`timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`bank_code` VARCHAR(20),
	`account_number` BIGINT,
	`beneficiary_name` VARCHAR(50),
	`remark` VARCHAR(255),
	`receipt` TEXT,
	`time_served` DATETIME,
	`fee` INT
);