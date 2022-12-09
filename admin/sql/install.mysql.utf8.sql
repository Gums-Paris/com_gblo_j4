CREATE TABLE IF NOT EXISTS `#__gblo_` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`parking` VARCHAR(255)  NOT NULL ,
`latpk` VARCHAR(255)  NOT NULL ,
`lonpk` VARCHAR(255)  NOT NULL ,
`rendezvous` VARCHAR(255)  NOT NULL ,
`latrv` VARCHAR(255)  NOT NULL ,
`lonrv` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

