-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `user_id` INT UNSIGNED NOT NULL,
  `user_add` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `user_email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `user_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `user_password` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  PRIMARY KEY (`user_id`));


-- -----------------------------------------------------
-- Table `mydb`.`progect`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`progect` (
  `progect_id` INT NOT NULL,
  `progect_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`progect_id`),
  INDEX `fk_progect_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_progect_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`task` (
  `task_id` INT NOT NULL,
  `task_create` DATETIME NULL,
  `task_status` INT NULL,
  `task_name` VARCHAR(255) NOT NULL,
  `task_file` VARCHAR(255) NULL,
  `task_completed` VARCHAR(255) NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `progect_id` INT NOT NULL,
  PRIMARY KEY (`task_id`),
  INDEX `fk_task_user1_idx` (`user_id` ASC),
  INDEX `fk_task_progect1_idx` (`progect_id` ASC),
  CONSTRAINT `fk_task_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_progect1`
    FOREIGN KEY (`progect_id`)
    REFERENCES `mydb`.`progect` (`progect_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
