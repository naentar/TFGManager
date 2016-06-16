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
  
  public function comprobarId($id){
    $stmt = $this->db->prepare("SELECT idTFG FROM TFG WHERE Alumno_dniAlumno=?");
    $stmt->execute(array($id));
	$existe = $stmt->fetch(PDO::FETCH_ASSOC);
		if($existe["idTFG"]!=NULL){
		   $valor = "si";
		} else {
		   $valor = "no";
		}
    return $valor; 
  }
   
  public function generarCodigo() {
	$maxcode = $this->db->query("select max(idTFG) as id from tfg");
	$id=$maxcode->fetch(PDO::FETCH_BOTH);
		if(is_null($id[0])){
		  return "15/16-001";	 
		}else{
	      list($fecha,$valor) = split('[-]',$id[0]);
		  $valor = $valor + 1;
		  if($valor <= 9){
		    $codigo = $fecha.'-00'.$valor; 
		  }else if($valor > 9){
			$codigo = $fecha.'-0'.$valor;	
		  }else if($valor > 99){
		    $codigo = $fecha.'-'.$valor;
		  }	   
	   return $codigo;  
	}
  }
}