<?php
require_once(__DIR__."/../core/ValidationException.php");

class Profesor {

  private $dni;
  private $email;
  private $password;
  private $nombre;
  private $areaDeConocimiento;
  private $departamento;
  private $tfgsenproceso;
  
  
  
  public function __construct($email=NULL,$dni=NULL, $password=NULL,$nombre=NULL,$areaDeConocimiento=NULL,$departamento=NULL,$tfgsenproceso=NULL) {
    $this->email = $email;
    $this->password = $password; 
    $this->nombre = $nombre;	
	$this->areaDeConocimiento = $areaDeConocimiento;
	$this->departamento = $departamento;
	$this->tfgsenproceso = $tfgsenproceso;
  }


  public function getDniP() {
    return $this->dni;
  }
  
  public function setDniP($dni) {
    $this->dni = $dni;
  }
  
  public function getEmailP() {
    return $this->email;
  }
  
  public function setEmailP($email) {
    $this->email = $email;
  }  
 
  public function getPasswordP() {
    return $this->password;
  }  
   
  public function setPasswordP($password) {
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
  
  public function getTfgsenproceso() {
    return $this->tfgsenproceso;
  }
  
  public function setTfgsenproceso($tfgsenproceso){
    $this->tfgsenproceso = $tfgsenproceso;
  } 
  
  public function validoParaActualizar() {
	$errors = array();

	try {
		if (strlen($this->password) < 5 && strlen($this->password) > 0 ) {
			$errors["password"] = "Contrase&ntilde;a no v&aacute;lida. 5 caracteres m&aicute;nimo";
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException ($errors, "Modificaci&oacute;n no v&aacute;lida");
		}
	} catch (ValidationException $ex) {
		foreach ($ex->getErrors() as $key => $error) {
			$errors[$key] = $error;
		}
	}
	if (sizeof($errors) > 0) {
		throw new ValidationException($errors, "Modificaci&oacute;n no v&aacute;lida");
	}
  }

  public function validoParaGestionar() {
	$errors = array();
	try {
	    if (strlen($this->dni) != 9) {
			$errors["dni"] = "El campo dni debe ser igual a 9";
		}
		if (strlen($this->nombre) < 1) {
			$errors["nombre"] = "El campo nombre no puede estar vacio";
		}
		if (strlen($this->email) < 1) {
			$errors["email"] = "El campo email no puede estar vacio";
		}
		if (strlen($this->areaDeConocimiento) < 1) {
			$errors["areaDeConocimiento"] = "El campo area de conocimiento no puede estar vacio";
		}
		if (strlen($this->password) < 5 && strlen($this->password) > 0 ) {
			$errors["password"] = "Contrase&ntilde;a no v&aacute;lida. 5 caracteres m&aicute;nimo";
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