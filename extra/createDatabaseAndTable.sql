
-- Create [ shortener_url ] DB
	CREATE DATABASE IF NOT EXISTS `shortener_url` CHARACTER SET= `utf8` COLLATE `utf8_general_ci`;

-- Create [ links ] table
	CREATE TABLE IF NOT EXISTS `shortener_url`.`links` (
			`id` int(11) not null primary key auto_increment,
			`url` varchar(255),
			`code` varchar(15),
			`created` datetime   
		); 

-- Alter intial value for auto increment
	ALTER TABLE `links` auto_increment = 1000000;