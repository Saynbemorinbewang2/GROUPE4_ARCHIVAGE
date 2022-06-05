CREATE TABLE `user`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `pseudo` VARCHAR(255), 
    `password` VARCHAR(255), 
    PRIMARY KEY(`id`)
    );

CREATE TABLE `student`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `regist_number` VARCHAR(255) NOT NULL, 
    `name` VARCHAR(255), 
    `surname` VARCHAR(255), 
    `born_at` DATETIME, 
    `born_place` VARCHAR(255), 
    PRIMARY KEY(`id`), 
    UNIQUE (`regist_number`)
    );

CREATE TABLE `faculty`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `faculty` VARCHAR(255), 
    PRIMARY KEY(`id`), 
    UNIQUE(`faculty`)
    );

CREATE TABLE `department`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `department` VARCHAR(255), 
    PRIMARY KEY(`id`), 
    UNIQUE(`department`)
    );

CREATE TABLE `level`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `level` VARCHAR(255),
    PRIMARY KEY(`id`), 
    UNIQUE(`level`)
    );

CREATE TABLE `trail`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `trail` VARCHAR(255), 
    PRIMARY KEY(`id`), 
    UNIQUE(`trail`)
    );

CREATE TABLE `releve`(
    `id` INT(10) NOT NULL AUTO_INCREMENT, 
    `id_student` INT(10) NOT NULL,
    `id_faculty` INT(10) NOT NULL,
    `id_department` INT(10) NOT NULL,
    `id_level` INT(10) NOT NULL,
    `id_trail` INT(10) NOT NULL,
    `pdf_name` VARCHAR(255) NOT NULL, 
    `pdf_link` VARCHAR(255) NOT NULL, 
    `obtained_at` DATETIME NOT NULL, 
    PRIMARY KEY(`id`), 
    UNIQUE(`pdf_link`)
    );

ALTER TABLE `releve` ADD CONSTRAINT `fk_student` FOREIGN KEY(`id_student`) REFERENCES `student`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `releve` ADD CONSTRAINT `fk_faculty` FOREIGN KEY(`id_faculty`) REFERENCES `faculty`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `releve` ADD CONSTRAINT `fk_department` FOREIGN KEY(`id_department`) REFERENCES `department`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `releve` ADD CONSTRAINT `fk_level` FOREIGN KEY(`id_level`) REFERENCES `level`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE `releve` ADD CONSTRAINT `fk_trail` FOREIGN KEY(`id_trail`) REFERENCES `trail`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
