<?php

require_once(__DIR__."/../core/PDOConnection.php");

class CoordinadorMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
     
  public function estadoCursoActual() {
    $stmt = $this->db->prepare("SELECT estadorCurso FROM coordinador WHERE idCoordinador=?");
	$stmt->execute(array("1"));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function modificarEstadoCurso($value) {
    $stmt = $this->db->prepare("UPDATE Coordinador SET estadorCurso=? WHERE idCoordinador=?");
    $stmt->execute(array($value, "1")); 
  }
  
  public function infoGmail() {
	$stmt = $this->db->prepare("select gmailCorreos, contrasenhaCorreos from coordinador WHERE idCoordinador=?");
	$stmt->execute(array("1")); 
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
    public function consultarUsuario($email) {
	$stmt = $this->db->prepare("select * from coordinador where email=?");
	$stmt->execute(array($email));
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function checkUser($email) {
	$stmt = $this->db->prepare("SELECT count(email) FROM coordinador where email=?");
	$stmt->execute(array($email));
		if ($stmt->fetchColumn() > 0) {
			return true;
		}
  }
  
  public function cargarDatos($rutaprof){
   $connect = mysqli_connect("localhost", "TFGManager", "abc123.", "eseitfgmanager"); 
   include ("/../PHPExcel/IOFactory.php");    
   $objPHPExcel = PHPExcel_IOFactory::load($rutaprof);  
   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet):  
   $highestRow = $worksheet->getHighestRow();  
   for ($row=2; $row<=$highestRow; $row++)  
   {   
   $dni = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
   $nombre = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); 
   $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
   $area = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 
   $dpt = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); 
   $ntfg = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());   
   $stmt = $this->db->prepare("INSERT INTO profesor(dniProfesor, email, contrasenhaPr, nombre, areaDeConocimiento, departamento, numerodetfgs) values (?,?,?,?,?,?,?)");
   $stmt->execute(array($dni, $email, "asdasd", $nombre, $area, $dpt, $ntfg)); 		    
   } 
   endforeach; 
   
   $objPHPExcel = PHPExcel_IOFactory::load('alumnos.xlsx');   
   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet):  
   $highestRow = $worksheet->getHighestRow();  
   for ($row=2; $row<=$highestRow; $row++)  
   {   
   $dni = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
   $nombre = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); 
   $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
   $nota = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 
   $calle = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); 
   $provincia = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  
   $localidad = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue()); 
   $telefono = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());   
   $stmt = $this->db->prepare("INSERT INTO alumno(dniAlumno, email, contrasenhaAl, nombre, telefono, notaMedia, direccion, provincia, localidad) values (?,?,?,?,?,?,?,?,?)");
   $stmt->execute(array($dni, $email, "asdasd", $nombre, $telefono, $nota, $calle, $provincia, $localidad)); 		    
   } 
   endforeach;	
  }
  
  public function modificar(Coordinador $Cr) {
       if($Cr->getPasswordC()!=""){
            $stmt = $this->db->prepare("UPDATE coordinador SET contrasenhaCr=?,gmailCorreos=?,contrasenhaCorreos=? WHERE email=?");
            $stmt->execute(array($Cr->getPasswordC(),$Cr->getGmail(),$Cr->getPasswordGmail(), $Cr->getEmailC()));
       }else {
			$stmt = $this->db->prepare("UPDATE coordinador SET gmailCorreos=?,contrasenhaCorreos=? WHERE email=?");
            $stmt->execute(array($Cr->getGmail(),$Cr->getPasswordGmail(), $Cr->getEmailC()));
	   }
  }
  
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT count(email) FROM coordinador where email=? and contrasenhaC=?");
    $stmt->execute(array($email, $password));
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}