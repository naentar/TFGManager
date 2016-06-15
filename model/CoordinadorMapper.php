<?php

require_once(__DIR__."/../core/PDOConnection.php");

class CoordinadorMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
     
  public function save($user) {
    $stmt = $this->db->prepare("INSERT INTO users values (?,?)");
    $stmt->execute(array($user->getUsername(), $user->getPasswd()));
  }
  public function estadoCursoActual() {
    $stmt = $this->db->prepare("SELECT estadorCurso FROM coordinador WHERE email=?");
	$stmt->execute(array("asdasd@asd.asd"));
	return $stmt->fetch(PDO::FETCH_ASSOC);
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