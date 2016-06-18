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
  
  public function modificar(TFG $Tf){
    $stmt = $this->db->prepare("UPDATE TFG SET tituloEn=?, tituloGa=?, tituloEs=?, empresa=?, Profesor_dniProfesor=?, Profesor_dniProfesorCotutor=? WHERE idTFG=?");
    $stmt->execute(array($Tf->getTituloEn(), $Tf->getTituloGa(), $Tf->getTituloEs(), $Tf->getEmpresa(), $Tf->getTutor(), $Tf->getCotutor(), $Tf->getIdTFG())); 
  }
  
  public function eliminar(TFG $Tf){
    $stmt = $this->db->prepare("DELETE FROM TFG where idTFG=?");
    $stmt->execute(array($Tf->getIdTFG())); 
  }
  
  public function modificarTitulos(TFG $Tf){
    $stmt = $this->db->prepare("UPDATE TFG SET tituloEn=?, tituloGa=?, tituloEs=? WHERE idTFG=?");
    $stmt->execute(array($Tf->getTituloEn(), $Tf->getTituloGa(), $Tf->getTituloEs(), $Tf->getIdTFG()));
  }
  
  public function getTFG($dni){
    $stmt = $this->db->prepare("SELECT * FROM tfg WHERE Alumno_dniAlumno=?");
    $stmt->execute(array($dni));
	return $stmt->fetch(PDO::FETCH_ASSOC); 
  }
  
  public function rechazarNoPresentados(){
    $stmt = $this->db->prepare("DELETE FROM TFG where tituloEn=?");
    $stmt->execute(array("aceptado")); 
	$stmt = $this->db->prepare("DELETE FROM TFG where tituloEn=?");
    $stmt->execute(array("solicitado"));
  }  
  
  public function listarTFGs(){
    $stmt = $this->db->query("select * from tfg");
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
	   $resultal = $this->db->prepare("select nombre from alumno where dniAlumno=?");
       $resultal->execute(array($propuesta["Alumno_dniAlumno"]));
       $resultalex = $resultal->fetch(PDO::FETCH_ASSOC);
	   $alumno = $resultalex["nombre"];
       array_push($stmtex[$aux],$tutor,$cotutor,$alumno);
       $aux = $aux + 1;	   
    endforeach;
	$aux = 0;
	return $stmtex;  
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
	      list($fecha,$valor) = preg_split('[-]',$id[0]);
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