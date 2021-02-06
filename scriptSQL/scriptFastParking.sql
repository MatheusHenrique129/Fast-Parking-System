-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fastparkingdb` DEFAULT CHARACTER SET utf8 ;
use `fastparkingdb`;
-- -----------------------------------------------------
-- Table `mydb`.`tblVeiculo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`tblVeiculo` (
  `idVeiculo` INT NOT NULL AUTO_INCREMENT,
  `placa` VARCHAR(45) NOT NULL,
  `cor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idVeiculo`))
ENGINE = InnoDB;

desc tblVeiculo;

insert into tblVeiculo(placa, cor)
values('STJ-7890', 'azul');

select * from tblVeiculo;

select * from tblVeiculo order by idVeiculo desc limit 1;

drop table tblVeiculo;

insert into tblVeiculo(placa, cor)
values('BOB-5924', 'Cinza');
-- -----------------------------------------------------
-- Table `mydb`.`tblRegistro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`tblRegistro` (
  `idRegistro` INT NOT NULL AUTO_INCREMENT,
  `qtde_de_vagas` INT NOT NULL,
  `valorPrimeiraHora` VARCHAR(45) NOT NULL,
  `valorDemaisHoras` VARCHAR(45) NOT NULL,
  `desconto` VARCHAR(45) NULL,
  PRIMARY KEY (`idRegistro`))
ENGINE = InnoDB;

drop table tblRegistro;

select * from tblRegistro;

insert into tblRegistro(qtde_de_vagas, valorPrimeiraHora, valorDemaisHoras)
values(500, '45,00', '30,00');

select tblRegistro.valorPrimeiraHora from tblRegistro;
-- -----------------------------------------------------
-- Table `mydb`.`tblCliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`tblCliente` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `nomeCliente` VARCHAR(45) NOT NULL,
  `idVeiculo` INT NOT NULL,
  `horarioEntrada` DATETIME NOT NULL,
  `horarioSaida` DATETIME NULL,
  `valorAPagar` VARCHAR(45) NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_tblCliente_tblVeiculo_idx` (`idVeiculo` ASC),
  CONSTRAINT `fk_tblCliente_tblVeiculo`
    FOREIGN KEY (`idVeiculo`)
    REFERENCES `fastparkingdb`.`tblVeiculo` (`idVeiculo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

drop table tblCliente;
select * from tblCliente;

select * from tblCliente
where tblCliente.valorAPagar <> 'null'
and day(tblCliente.horarioSaida) = day(current_date());

select sum(valorAPagar) as valorTotal from tblCliente
                    where tblCliente.valorAPagar <> 'null'
                    and day(tblCliente.horarioSaida) = day(current_date());

-- -----------------------------------------------------
-- Table `mydb`.`rendimentoDiario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`rendimentoDiario` (
  `idRendimentoDiario` INT NOT NULL AUTO_INCREMENT,
  `data` DATETIME NOT NULL,
  `qtde_de_clientes` int not null,
  `valorTotal` VARCHAR(45) NOT NULL,
  `idRegistro` INT NOT NULL,
  PRIMARY KEY (`idRendimentoDiario`),
  INDEX `fk_rendimentoDiario_tblRegistro1_idx` (`idRegistro` ASC),
  CONSTRAINT `fk_rendimentoDiario_tblRegistro1`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `fastparkingdb`.`tblRegistro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

select * from rendimentoDiario;

drop table rendimentoDiario;
desc rendimentoDiario;
-- -----------------------------------------------------
-- Table `mydb`.`rendimentoMensal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`rendimentoMensal` (
  `idRendimentoMensal` INT NOT NULL AUTO_INCREMENT,
  `mes` VARCHAR(45) NOT NULL,
  `qtde_de_clientes` int not null,
  `valorTotal` VARCHAR(45) NOT NULL,
  `idRegistro` INT NOT NULL,
  PRIMARY KEY (`idRendimentoMensal`),
  INDEX `fk_rendimentoDiario_tblRegistro1_idx` (`idRegistro` ASC),
  CONSTRAINT `fk_rendimentoDiario_tblRegistro10`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `fastparkingdb`.`tblRegistro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

select * from rendimentomensal;
drop table rendimentoMensal;

-- -----------------------------------------------------
-- Table `mydb`.`rendimentoAnual`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fastparkingdb`.`rendimentoAnual` (
  `idRendimentoAnual` INT NOT NULL AUTO_INCREMENT,
  `ano` VARCHAR(45) NOT NULL,
  `qtde_de_clientes` int not null,
  `valorTotal` VARCHAR(45) NOT NULL,
  `idRegistro` INT NOT NULL,
  PRIMARY KEY (`idRendimentoAnual`),
  INDEX `fk_rendimentoDiario_tblRegistro1_idx` (`idRegistro` ASC),
  CONSTRAINT `fk_rendimentoDiario_tblRegistro11`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `fastparkingdb`.`tblRegistro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

select * from rendimentoanual;
drop table rendimentoAnual;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;