<?php

require_once(__DIR__."/../core/PDOConnection.php");

class TFGMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function insertar(TFG $Tf){
    $stmt = $this->db->prepare("INSERT INTO TFG(`idTFG`, `tituloEn`, `tituloGa`, `tituloEs`, `empresa`, `Alumno_dniAlumno`, `Profesor_dniProfesor`, `Profesor_dniProfesorCotutor`) values (?,?,?,?,?,?,?,?)");
    $stmt->execute(array($Tf->getIdTFG(), $Tf->getTituloEn(), $Tf->getTituloGa(), $Tf->getTituloEs(), $Tf->getEmpresa(), $Tf->getAlumno(), $Tf->getTutor(), $Tf->getCotutor())); 
  }
  
  public function listarSolicitudes() {
	$stmt = $this->db->query("select * from alumno_escoge_propuestasdetfg");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
   
}