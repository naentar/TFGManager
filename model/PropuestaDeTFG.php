<?php
require_once(__DIR__."/../core/ValidationException.php");

class PropuestaDeTFG {

  private $titulo;
  private $descripcion;
  private $cotutor;
  private $tutor;
  
  public function __construct($titulo=NULL, $descripcion=NULL,$tutor=NULL,$cotutor=NULL) {
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->tutor = $tutor;		
    $this->cotutor = $cotutor;	
  }


  public function getTitulo() {
    return $this->titulo;
  }
  
  public function setTitulo($titulo) {
    $this->titulo = $titulo;
  }  
 
  public function getDescripcion() {
    return $this->descripcion;
  }  
   
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  
  public function getTutor() {
    return $this->tutor;
  }  
   
  public function setTutor($tutor) {
    $this->tutor = $tutor;
  }
  
  public function getCotutor() {
    return $this->cotutor;
  }  
   
  public function setCotutor($cotutor) {
    $this->cotutor = $cotutor;
  }
  
  public function validoParaCrear() {
	$errors = array();

	try {
		if (strlen($this->titulo) < 1) {
			$errors["titulo"] = "El campo titulo no puede estar vacio";
		}
		if (strlen($this->descripcion) < 1) {
			$errors["descripcion"] = "El campo descripcion no puede estar vacio";
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException ($errors, "Propuesta no v&aacute;lida");
		}
	} catch (ValidationException $ex) {
		foreach ($ex->getErrors() as $key => $error) {
			$errors[$key] = $error;
		}
	}
	if (sizeof($errors) > 0) {
		throw new ValidationException($errors, "Propuesta no v&aacute;lida");
	}
  }

}