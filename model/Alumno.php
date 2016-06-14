<?php
require_once(__DIR__."/../core/ValidationException.php");

class Alumno {

  private $dni;
  private $email;
  private $password;
  private $nombre;
  private $telefono;
  private $notaMedia;
  private $direccion;
  private $provincia;
  private $localidad;
  
  
  
  public function __construct($dni=NULL,$email=NULL, $password=NULL,$nombre=NULL,$telefono=NULL,$notaMedia=NULL,$direccion=NULL,$provincia=NULL,$localidad=NULL) {
    $this->dni = $dni;
    $this->email = $email;
    $this->password = $password; 
    $this->nombre = $nombre;	
	$this->telefono = $telefono;
	$this->notaMedia = $notaMedia;
	$this->direccion = $direccion;
	$this->provincia = $provincia;
	$this->localidad = $localidad;
  }
  

  public function getDniA() {
    return $this->dni;
  }
  
  public function setDniA($dni) {
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
  
  public function getTelefono() {
    return $this->telefono;
  }
  
  public function setTelefono($telefono) {
    $this->telefono = $telefono;
  } 
  
  public function getNotaMedia() {
    return $this->email;
  }
  
  public function setNotaMedia($notaMedia) {
    $this->notaMedia = $notaMedia;
  } 
  
  public function getDireccion() {
    return $this->direccion;
  }
  
  public function setDireccion($direccion) {
    $this->direccion = $direccion;
  } 
  
  public function getProvincia() {
    return $this->provincia;
  }
  
  public function setProvincia($provincia) {
    $this->provincia = $provincia;
  } 
  
  public function getLocalidad() {
    return $this->localidad;
  }
  
  public function setLocalidad($localidad) {
    $this->localidad = $localidad;
  } 
}