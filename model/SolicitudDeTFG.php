<?php
require_once(__DIR__."/../core/ValidationException.php");

class SolicitudDeTFG {

  private $alumno;
  private $idPropuesta;
  private $prioridad;
  
  public function __construct($alumno=NULL, $idPropuesta=NULL,$prioridad=NULL) {
    $this->alumno = $alumno;
    $this->idPropuesta = $idPropuesta;
    $this->prioridad = $prioridad;		
  }


  public function getAlumno() {
    return $this->alumno;
  }
  
  public function setAlumno($alumno) {
    $this->alumno = $alumno;
  }  
 
  public function getIdPropuesta() {
    return $this->idPropuesta;
  }  
   
  public function setIdPropuesta($idPropuesta) {
    $this->idPropuesta = $idPropuesta;
  }
  
  public function getPrioridad() {
    return $this->prioridad;
  }  
   
  public function setPrioridad($prioridad) {
    $this->prioridad = $prioridad;
  }

}