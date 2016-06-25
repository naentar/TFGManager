<?php
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__ . "/../core/ViewManager.php");
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
  
  
  
  public function __construct($email=NULL, $dni=NULL,$password=NULL,$nombre=NULL,$telefono=NULL,$notaMedia=NULL,$direccion=NULL,$provincia=NULL,$localidad=NULL) {
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
    return $this->notaMedia;
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
	
  public function validoParaActualizar() {
	$errors = array();

	try {
		if (strlen($this->telefono) < 1) {
			$errors["telefono"] = "El campo nombre no puede estar vacio";
		}
		if (strlen($this->password) < 5 && strlen($this->password) > 0 ) {
			$errors["password"] = "Contrase&ntilde;a no v&aacute;lida. 5 caracteres m&aicute;nimo";
		}
		if (strlen($this->direccion) < 1) {
			$errors["direccion"] = "El campo direccion no puede estar vacio";
		}
		if (strlen($this->provincia) < 1) {
			$errors["provincia"] = "Dni no v&aacute;lido";
		}
		if (strlen($this->localidad) < 1) {
			$errors["localidad"] = "El campo apellidos no puede estar vacio";
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException ($errors, "Alumno no v&aacute;lido");
		}
	} catch (ValidationException $ex) {
		foreach ($ex->getErrors() as $key => $error) {
			$errors[$key] = $error;
		}
	}
	if (sizeof($errors) > 0) {
		throw new ValidationException($errors, "Alumno no v&aacute;lido");
	}
  }
   
}