<?php
require_once(__DIR__."/../core/ValidationException.php");

class Profesor {

  private $dni;
  private $email;
  private $password;
  private $nombre;
  private $areaDeConocimiento;
  private $departamento;
  
  
  
  public function __construct($dni=NULL,$email=NULL, $password=NULL,$nombre=NULL,$areaDeConocimiento=NULL,$departamento=NULL) {
    $this->email = $email;
    $this->password = $password; 
    $this->nombre = $nombre;	
	$this->areaDeConocimiento = $areaDeConocimiento;
	$this->departamento = $departamento;
  }


  public function getDniP() {
    return $this->dni;
  }
  
  public function setDniP($dni) {
    $this->dni = $dni;
  }
  
  public function getEmailA() {
    return $this->email;
  }
  
  public function setEmailA($email) {
    $this->email = $email;
  }  
 
  public function getPasswordA() {
    return $this->password;
  }  
   
  public function setPasswordA($password) {
    $this->password = $password;
  }
  
  public function getNombre() {
    return $this->nombre;
  }  
   
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  
  public function getareaDeConocimiento() {
    return $this->areaDeConocimiento;
  }
  
  public function setAreaDeConocimiento($areaDeConocimiento) {
    $this->areaDeConocimiento = $areaDeConocimiento;
  } 
  
  public function getDepartamento() {
    return $this->departamento;
  }
  
  public function setDepartamento($departamento) {
    $this->departamento = $departamento;
  } 

}