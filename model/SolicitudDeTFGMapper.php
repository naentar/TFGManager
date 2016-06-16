<?php

require_once(__DIR__."/../core/PDOConnection.php");

class SolicitudDeTFGMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function insertar(SolicitudDeTFG $St){
    $stmt = $this->db->prepare("INSERT INTO alumno_escoge_propuestasdetfg(`Alumno_dniAlumno`,`PropuestasDeTFG_idPropuestasDeTFG`, `prioridad`) values (?,?,?)");
    $stmt->execute(array($St->getAlumno(), $St->getIdPropuesta(), $St->getPrioridad())); 
  }
  
  public function listarSolicitudes() {
	$stmt = $this->db->query("select * from alumno_escoge_propuestasdetfg");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
   
  public function comprobarId($id){
  $stmt = $this->db->prepare("SELECT Alumno_dniAlumno FROM alumno_escoge_propuestasdetfg WHERE Alumno_dniAlumno=?");
  $stmt->execute(array($id));
  $existe = $stmt->fetch(PDO::FETCH_ASSOC);
	if($existe["Alumno_dniAlumno"]!=NULL){
	   $valor = "si";
	} else {
	   $valor = "no";
	}
  return $valor; 
  } 
}