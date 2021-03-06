<?php

require_once(__DIR__."/../core/PDOConnection.php");

class PropuestaDeTFGMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function deleteIt(){
    $this->db->query("DELETE FROM propuestasdetfg");
  }
  
  public function insertar(PropuestaDeTFG $Pr) {
    $stmt = $this->db->prepare("INSERT INTO PropuestasDeTFG(`titulo`,`descripcion`, `Profesor_dniProfesor`, `Profesor_dniProfesorCotutor`) values (?,?,?,?)");
    $stmt->execute(array($Pr->getTitulo(), $Pr->getDescripcion(), $Pr->getTutor(), $Pr->getCotutor())); 
  }
  
  public function modificar(PropuestaDeTFG $Pr) {
    $stmt = $this->db->prepare("UPDATE PropuestasDeTFG SET titulo=?, descripcion=?, Profesor_dniProfesor=?, Profesor_dniProfesorCotutor=? WHERE idPropuestasDeTFG=?");
    $stmt->execute(array($Pr->getTitulo(), $Pr->getDescripcion(), $Pr->getTutor(), $Pr->getCotutor(), $Pr->getIdPk())); 
  }
  
  public function eliminar(PropuestaDeTFG $Pr) {
    $stmt = $this->db->prepare("DELETE FROM PropuestasDeTFG where idPropuestasDeTFG=?");
    $stmt->execute(array($Pr->getIdPk())); 
  }
  
  public function getPropuesta($id) {
    $stmt = $this->db->prepare("SELECT * FROM PropuestasDeTFG WHERE idPropuestasDeTFG=?");
    $stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function listarPropuestasTitulo() {
	$stmt = $this->db->query("select idPropuestasDeTFG, titulo from propuestasdetfg");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
   
  public function listarPropuestas() {
	$stmt = $this->db->query("select * from propuestasdetfg");
	$stmtex = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$aux = 0;
       foreach($stmtex as $propuesta):
	   $result = $this->db->prepare("select nombre from profesor where dniProfesor=?");
       $result->execute(array($propuesta["Profesor_dniProfesor"]));
       $resultex = $result->fetch(PDO::FETCH_ASSOC);
       $tutor = $resultex["nombre"];
       if($propuesta["Profesor_dniProfesorCotutor"]!="NULL"){
          $resultco = $this->db->prepare("select nombre from profesor where dniProfesor=?");
          $resultco->execute(array($propuesta["Profesor_dniProfesorCotutor"]));
          $resultcoex = $resultco->fetch(PDO::FETCH_ASSOC);
		  $cotutor = $resultcoex["nombre"];
       }else{
          $cotutor = "NULL";
       }
       array_push($stmtex[$aux],$tutor,$cotutor);
       $aux = $aux + 1;	   
    endforeach;
	return $stmtex;
  }	
  
  public function listarPropuestasPorDepartamento($departamento) {
	$stmt = $this->db->prepare("SELECT * FROM propuestasdetfg INNER JOIN profesor ON propuestasdetfg.Profesor_dniProfesor=profesor.dniProfesor WHERE profesor.departamento=?");
	$stmt->execute(array($departamento));
	$stmtex = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$aux = 0;
       foreach($stmtex as $propuesta):
	   $result = $this->db->prepare("select nombre from profesor where dniProfesor=?");
       $result->execute(array($propuesta["Profesor_dniProfesor"]));
       $resultex = $result->fetch(PDO::FETCH_ASSOC);
       $tutor = $resultex["nombre"];
       if($propuesta["Profesor_dniProfesorCotutor"]!="NULL"){
          $resultco = $this->db->prepare("select nombre from profesor where dniProfesor=?");
          $resultco->execute(array($propuesta["Profesor_dniProfesorCotutor"]));
          $resultcoex = $resultco->fetch(PDO::FETCH_ASSOC);
		  $cotutor = $resultcoex["nombre"];
       }else{
          $cotutor = "NULL";
       }
       array_push($stmtex[$aux],$tutor,$cotutor);
       $aux = $aux + 1;	   
    endforeach;
	return $stmtex;
  }
  
  public function numeroDePropuestas($dni){
   $stmt = $this->db->prepare("select count(idPropuestasDeTFG) as Cuenta from PropuestasDeTFG where Profesor_dniProfesor=?");
   $valorProfesor = $stmt->execute(array($dni));
   $sumaT = $stmt->fetch(PDO::FETCH_ASSOC);
   $stmt = $this->db->prepare("select count(idPropuestasDeTFG) as Cuenta from PropuestasDeTFG where Profesor_dniProfesorCotutor=?");
   $valorProfesor = $stmt->execute(array($dni));
   $sumaC = $stmt->fetch(PDO::FETCH_ASSOC);
   $total = ($sumaT["Cuenta"]);
   $total = $total + ($sumaC["Cuenta"]*0.5);
   return $total;
  }
  
  public function sorteo() {
    $stmt = $this->db->query("select * from propuestasdetfg");
	return $stmt->fetch(PDO::FETCH_ASSOC);  
  }  
}