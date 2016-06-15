<?php

require_once(__DIR__."/../core/PDOConnection.php");

class CoordinadorMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
     
  public function estadoCursoActual() {
    $stmt = $this->db->prepare("SELECT estadorCurso FROM coordinador WHERE idCoordinador=?");
	$stmt->execute(array("1"));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function modificarEstadoCurso($value) {
    $stmt = $this->db->prepare("UPDATE Coordinador SET estadorCurso=? WHERE idCoordinador=?");
    $stmt->execute(array($value, "1")); 
  }
  
  public function checkUser($email) {
	$stmt = $this->db->prepare("SELECT count(email) FROM coordinador where email=?");
	$stmt->execute(array($email));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
  }
  
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT count(email) FROM coordinador where email=? and contrasenhaC=?");
    $stmt->execute(array($email, $password));
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}