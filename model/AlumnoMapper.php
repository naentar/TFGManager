<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

class AlumnoMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function usernameExists($username) {
    $stmt = $this->db->prepare("SELECT count(username) FROM users where username=?");
    $stmt->execute(array($username));
    
    if ($stmt->fetchColumn() > 0) {   
      return true;
    } 
  }
  
  public function getId($email) {
    $stmt = $this->db->prepare("SELECT dniAlumno FROM alumno WHERE email=?");
    $stmt->execute(array($email));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function checkUser($email) {
  	$stmt = $this->db->prepare("SELECT count(email) FROM alumno where email=?");
	$stmt->execute(array($email));
	if ($stmt->fetchColumn() > 0) {
		return true;
	}
  }
  
  public function consultarUsuario($email) {
        $stmt = $this->db->prepare("select * from alumno where email=?");
        $stmt->execute(array($email));
        return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function ordenarPorNota() {
	$stmt = $this->db->query("SELECT * FROM alumno WHERE dniAlumno NOT IN (SELECT Alumno_dniAlumno FROM tfg) ORDER BY notaMedia DESC");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);   
  }
  
  public function modificar(Alumno $Al) {
       if($Al->getPasswordA()!=""){
            $stmt = $this->db->prepare("UPDATE Alumno SET telefono=?,direccion=?, localidad=?, provincia=?, contrasenhaAl=? WHERE email=?");
            $stmt->execute(array($Al->getTelefono(), $Al->getDireccion(), $Al->getLocalidad(), $Al->getProvincia(), $Al->getPasswordA(), $Al->getEmailA()));
        } else{
            $stmt = $this->db->prepare("UPDATE Alumno SET telefono=?,direccion=?, localidad=?, provincia=?  WHERE email=?");
            $stmt->execute(array($Al->getTelefono(),$Al->getDireccion(), $Al->getLocalidad(), $Al->getProvincia(), $Al->getEmailA()));
       }
  }
  
  public function listarAlumnos() {
	$stmt = $this->db->query("select * from alumno");
	return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }
		 
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT count(email) FROM alumno where email=? and contrasenhaAl=?");
    $stmt->execute(array($email, $password));
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}