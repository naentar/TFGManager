-- MySQL Script generated by MySQL Workbench
-- 06/20/16 15:26:47
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema eseitfgmanager
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema eseitfgmanager
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eseitfgmanager` DEFAULT CHARACTER SET utf8 ;
USE `eseitfgmanager` ;

-- -----------------------------------------------------
-- Table `eseitfgmanager`.`Alumno`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`Alumno` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`Alumno` (
  `dniAlumno` VARCHAR(9) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `contrasenhaAl` VARCHAR(32) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `telefono` INT(9) NULL,
  `notaMedia` DECIMAL(4,2) NOT NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `provincia` VARCHAR(30) NOT NULL,
  `localidad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dniAlumno`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eseitfgmanager`.`Profesor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`Profesor` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`Profesor` (
  `dniProfesor` VARCHAR(9) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `contrasenhaPr` VARCHAR(32) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `areaDeConocimiento` VARCHAR(60) NOT NULL,
  `departamento` VARCHAR(30) NOT NULL,
  `numeroDeTFGs` DECIMAL(3,1) NOT NULL,
  PRIMARY KEY (`dniProfesor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eseitfgmanager`.`PropuestasDeTFG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`PropuestasDeTFG` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`PropuestasDeTFG` (
  `idPropuestasDeTFG` INT(5) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(70) NOT NULL,
  `descripcion` MEDIUMTEXT NOT NULL,
  `Profesor_dniProfesorCotutor` VARCHAR(9) NULL DEFAULT NULL,
  `Profesor_dniProfesor` VARCHAR(9) NOT NULL,
  PRIMARY KEY (`idPropuestasDeTFG`),
  INDEX `fk_PropuestasDeTFG_Profesor1_idx` (`Profesor_dniProfesor` ASC),
  CONSTRAINT `fk_PropuestasDeTFG_Profesor1`
    FOREIGN KEY (`Profesor_dniProfesor`)
    REFERENCES `eseitfgmanager`.`Profesor` (`dniProfesor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eseitfgmanager`.`TFG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`TFG` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`TFG` (
  `idTFG` VARCHAR(11) NOT NULL,
  `tituloEn` VARCHAR(70) NOT NULL,
  `tituloGa` VARCHAR(70) NOT NULL,
  `tituloEs` VARCHAR(70) NOT NULL,
  `empresa` TINYINT(1) NOT NULL DEFAULT 0,
  `Alumno_dniAlumno` VARCHAR(9) NOT NULL,
  `Profesor_dniProfesor` VARCHAR(9) NOT NULL,
  `Profesor_dniProfesorCotutor` VARCHAR(9) NULL,
  PRIMARY KEY (`idTFG`),
  INDEX `fk_TFG_Alumno1_idx` (`Alumno_dniAlumno` ASC),
  INDEX `fk_TFG_Profesor1_idx` (`Profesor_dniProfesor` ASC),
  CONSTRAINT `fk_TFG_Alumno1`
    FOREIGN KEY (`Alumno_dniAlumno`)
    REFERENCES `eseitfgmanager`.`Alumno` (`dniAlumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TFG_Profesor1`
    FOREIGN KEY (`Profesor_dniProfesor`)
    REFERENCES `eseitfgmanager`.`Profesor` (`dniProfesor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eseitfgmanager`.`Alumno_escoge_PropuestasDeTFG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`Alumno_escoge_PropuestasDeTFG` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`Alumno_escoge_PropuestasDeTFG` (
  `Alumno_dniAlumno` VARCHAR(9) NOT NULL,
  `PropuestasDeTFG_idPropuestasDeTFG` INT(5) NOT NULL,
  `prioridad` INT(1) NOT NULL,
  PRIMARY KEY (`Alumno_dniAlumno`, `PropuestasDeTFG_idPropuestasDeTFG`),
  INDEX `fk_Alumno_has_PropuestasDeTFG_PropuestasDeTFG1_idx` (`PropuestasDeTFG_idPropuestasDeTFG` ASC),
  INDEX `fk_Alumno_has_PropuestasDeTFG_Alumno1_idx` (`Alumno_dniAlumno` ASC),
  CONSTRAINT `fk_Alumno_has_PropuestasDeTFG_Alumno1`
    FOREIGN KEY (`Alumno_dniAlumno`)
    REFERENCES `eseitfgmanager`.`Alumno` (`dniAlumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Alumno_has_PropuestasDeTFG_PropuestasDeTFG1`
    FOREIGN KEY (`PropuestasDeTFG_idPropuestasDeTFG`)
    REFERENCES `eseitfgmanager`.`PropuestasDeTFG` (`idPropuestasDeTFG`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eseitfgmanager`.`Coordinador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eseitfgmanager`.`Coordinador` ;

CREATE TABLE IF NOT EXISTS `eseitfgmanager`.`Coordinador` (
  `idCoordinador` INT(1) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `contrasenhaC` VARCHAR(32) NOT NULL,
  `estadorCurso` INT(1) NOT NULL DEFAULT 0,
  `gmailCorreos` VARCHAR(45) NULL DEFAULT NULL,
  `contrasenhaCorreos` VARCHAR(32) NULL DEFAULT NULL,
  PRIMARY KEY (`idCoordinador`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `coordinador`(`email`, `contrasenhaC`) VALUES ("asdasd@asd.asd","asdasd");
