<?php
require_once(__DIR__."/../core/ValidationException.php");

class PropuestaTFG {

  private $titulo;
  private $descripcion;
  private $cotutor;
  
  public function __construct($titulo=NULL, $descripcion=NULL,$cotutor=NULL) {
    $this->titulo = $titulo;
    $this->descripcion = $descripcion; 
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
  
  public function getCotutor() {
    return $this->cotutor;
  }  
   
  public function setCotutor($cotutor) {
    $this->cotutor = $cotutor;
  }

}