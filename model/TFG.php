<?php
require_once(__DIR__."/../core/ValidationException.php");

class TFG {

  private $tituloEn;
  private $tituloGa;
  private $tituloEs;
  private $empresa;
  private $fechaInicio;
  
  public function __construct($tituloEn=NULL, $tituloGa=NULL,$tituloEs=NULL,$empresa=NULL,$fechaInicio=NULL) {
    $this->tituloEn = $tituloEn;
    $this->tituloGa = $tituloGa; 
    $this->tituloEs = $tituloEs;	
	$this->empresa = $empresa; 
    $this->fechaInicio = $fechaInicio;	
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
  
  public function getFechaInicio() {
    return $this->empresa;
  }  
   
  public function setFechaInicio($fechaInicio) {
    $this->fechaInicio = $fechaInicio;
  }

}