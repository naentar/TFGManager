<?php

require_once(__DIR__."/../core/PDOConnection.php");

class CoordinadorMapper {

  private $db;
  private $coordinador;
  private $profesorMapper;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
	$this->coordinador = new Coordinador();
	$this->profesorMapper = new ProfesorMapper();
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
  
  public function cargarDatos($ruta,$rutaal,$rutatfg){
   $connect = mysqli_connect("localhost", "TFGManager", "abc123.", "eseitfgmanager"); 
   include ("/../PHPExcel/IOFactory.php");  
   //Cargar profesor
   $objPHPExcel = PHPExcel_IOFactory::load($ruta);  
   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet):  
   $highestRow = $worksheet->getHighestRow();  
   for ($row=2; $row<=$highestRow; $row++)  
   {   
   $dni = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
   $nombre = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); 
   $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
   $area = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 
   $dpt = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());    
   if($dni!=NULL && $dni!=""){ 
   $stmt = $this->db->prepare("INSERT INTO profesor(dniProfesor, email, contrasenhaPr, nombre, areaDeConocimiento, departamento) values (?,?,?,?,?,?)");
   $stmt->execute(array($dni, $email, $dni, $nombre, $area, $dpt)); 
   }   
   } 
   endforeach; 
   //Cargar alumno
   $objPHPExcel = PHPExcel_IOFactory::load($rutaal);   
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
   if($dni!=NULL && $dni!=""){   
   $stmt = $this->db->prepare("INSERT INTO alumno(dniAlumno, email, contrasenhaAl, nombre, telefono, notaMedia, direccion, provincia, localidad) values (?,?,?,?,?,?,?,?,?)");
   $stmt->execute(array($dni, $email, $dni, $nombre, $telefono, $nota, $calle, $provincia, $localidad)); 
   }   
   } 
   //Cargar TFGs ya en curso
   endforeach;	
   $objPHPExcel = PHPExcel_IOFactory::load($rutatfg);   
   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet):  
   $highestRow = $worksheet->getHighestRow();  
   for ($row=2; $row<=$highestRow; $row++)  
   {   
   $idTFG = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
   $tituloEs = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); 
   $tituloGa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
   $tituloEn = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 
   $empresa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); 
   $dniAlumno = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  
   $dniProfesor = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue()); 
   $dniProfesorCotutor = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue()); 
   $descripcion = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue()); 
   if($idTFG!=NULL && $idTFG!=""){   
   $stmt = $this->db->prepare("INSERT INTO TFG(`idTFG`, `tituloEn`, `tituloGa`, `tituloEs`, `empresa`, `Alumno_dniAlumno`, `Profesor_dniProfesor`, `Profesor_dniProfesorCotutor`, `descripcion`) values (?,?,?,?,?,?,?,?,?)");
   $stmt->execute(array($idTFG, $tituloEn, $tituloGa, $tituloEs, $empresa, $dniAlumno, $dniProfesor, $dniProfesorCotutor, $descripcion)); 
   $this->profesorMapper->actualizarNumeroDeTFGs(0,$dniProfesor);
   if($dniProfesorCotutor!=NULL && $dniProfesorCotutor!="NULL" && $dniProfesorCotutor!="NULL"){
   $this->profesorMapper->actualizarNumeroDeTFGs(1,$dniProfesorCotutor);
      }  
    }   
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
  
  public function getFechaCurso() {
    $stmt = $this->db->query("SELECT fechaCurso FROM coordinador");
	return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function setFechaCurso($fecha) {
    $estado = $this->coordinador->fechaCursoValida($fecha);
	if($estado==true){
    $stmt = $this->db->prepare("UPDATE coordinador SET fechaCurso=?");
	$stmt->execute(array($fecha));
	return true;
	}else{
	return false;
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