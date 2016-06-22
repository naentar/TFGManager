<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

class AlumnoMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function insertar(Alumno $Al) {
    $stmt = $this->db->prepare("INSERT INTO `alumno`(`dniAlumno`, `email`, `contrasenhaAl`, `nombre`, `telefono`, `notaMedia`, `direccion`, `provincia`, `localidad`) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($Al->getDniA(),$Al->getEmailA(),$Al->getPasswordA(),$Al->getNombre(),$Al->getTelefono(),$Al->getNotaMedia(), $Al->getDireccion(),  $Al->getProvincia(), $Al->getLocalidad()));  
  }
  
  public function modificarC(Alumno $Al) {
    $stmt = $this->db->prepare("UPDATE Alumno SET email=?,contrasenhaAl=?,nombre=?,telefono=?,notaMedia=?,direccion=?,  provincia=?, localidad=? WHERE dniAlumno=?");
    $stmt->execute(array($Al->getEmailA(),$Al->getPasswordA(),$Al->getNombre(),$Al->getTelefono(),$Al->getNotaMedia(), $Al->getDireccion(),  $Al->getProvincia(), $Al->getLocalidad(),$Al->getDniA()));  
  }
  
  public function eliminar(Alumno $Al) {
    $stmt = $this->db->prepare("DELETE FROM Alumno WHERE dniAlumno=?");
    $stmt->execute(array($Al->getDniA()));  
  }
  
  public function getId($email) {
    $stmt = $this->db->prepare("SELECT dniAlumno FROM alumno WHERE email=?");
    $stmt->execute(array($email));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function getAlumno($dni) {
    $stmt = $this->db->prepare("SELECT * FROM alumno WHERE dniAlumno=?");
    $stmt->execute(array($dni));
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
	$stmt = $this->db->query("select * from alumno ORDER BY nombre");
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