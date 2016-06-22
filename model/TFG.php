<?php
require_once(__DIR__."/../core/ValidationException.php");

class TFG {

  private $idTFG;
  private $tituloEn;
  private $tituloGa;
  private $tituloEs;
  private $empresa;
  private $tutor;
  private $cotutor;
  private $alumno;
  
  public function __construct($idTFG=NULL,$tituloEn=NULL, $tituloGa=NULL,$tituloEs=NULL,$empresa=NULL,$tutor=NULL,$cotutor=NULL,$alumno=NULL,$descripcion=NULL) {
    $this->idTFG = $idTFG;
	$this->tituloEn = $tituloEn;
    $this->tituloGa = $tituloGa; 
    $this->tituloEs = $tituloEs;	
	$this->empresa = $empresa; 
    $this->tutor = $tutor;
	$this->cotutor = $cotutor;
	$this->alumno = $alumno;
	$this->descripcion = $descripcion;
  }

  public function getIdTFG() {
    return $this->idTFG;
  }
  
  public function setIdTFG($idTFG) {
    $this->idTFG = $idTFG;
  }
  
  public function getTituloEn() {
    return $this->tituloEn;
  }
  
  public function setTituloEn($tituloEn) {
    $this->tituloEn = $tituloEn;
  }  
 
  public function getTituloGa() {
    return $this->tituloGa;
  }
  
  public function setTituloGa($tituloGa) {
    $this->tituloGa = $tituloGa;
  } 
  
  public function getTituloEs() {
    return $this->tituloEs;
  }
  
  public function setTituloEs($tituloEs) {
    $this->tituloEs = $tituloEs;
  } 
  
  public function getEmpresa() {
    return $this->empresa;
  }  
   
  public function setEmpresa($empresa) {
    $this->empresa = $empresa;
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
  
  public function getAlumno() {
    return $this->alumno;
  }  
   
  public function setAlumno($alumno) {
    $this->alumno = $alumno;
  }
  
  public function getDescripcion() {
    return $this->descripcion;
  }
  
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }

}