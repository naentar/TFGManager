<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

class ProfesorMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
     
  public function getId($email) {
    $stmt = $this->db->prepare("SELECT dniProfesor FROM profesor WHERE email=?");
    $stmt->execute(array($email));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function checkUser($email) {
	$stmt = $this->db->prepare("SELECT count(email) FROM profesor where email=?");
	$stmt->execute(array($email));
	  if ($stmt->fetchColumn() > 0) {
		return true;
	  }
  }
  
  public function listarProfesores($email) {
	$stmt = $this->db->prepare("select * from profesor WHERE email!=?");
	$stmt->execute(array($email));
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
	
  public function consultarUsuario($email) {
	$stmt = $this->db->prepare("select * from profesor where email=?");
	$stmt->execute(array($email));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function modificar(Profesor $Pr) {
       if($Pr->getPasswordP()!=""){
            $stmt = $this->db->prepare("UPDATE Profesor SET contrasenhaPr=? WHERE email=?");
            $stmt->execute(array($Pr->getPasswordP(), $Pr->getEmailP()));
       }
  }
  
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT count(email) FROM profesor where email=? and contrasenhaPr=?");
    $stmt->execute(array($email, $password));
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}