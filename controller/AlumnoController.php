<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class AlumnoController extends BaseController {
  
  private $alumnoMapper;
  private $coordinadorMapper; 
  private $profesorMapper;  
  private $propuestadetfgMapper;
  private $tfgMapper;
  private $solicituddetfgMapper;
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
	$this->tfgMapper = new TFGMapper();
	$this->solicituddetfgMapper = new SolicitudDeTFGMapper();
 
  }
  public function index() {
	if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
		$estado = $this->coordinadorMapper->estadoCursoActual(); 
		$this->view->setVariable("estadocurso",$estado["estadorCurso"]);
		$dniAl = $this->alumnoMapper->getId($this->currentUser->getEmailA());
		if($estado["estadorCurso"]==3){
		$listarPropuestasTitulo = $this->propuestadetfgMapper->listarPropuestasTitulo();
		$this->view->setVariable("listarPropuestasTitulo", $listarPropuestasTitulo);
		$infoTFG = $this->tfgMapper->comprobarId($dniAl["dniAlumno"]);
		$this->view->setVariable("existeTFG", $infoTFG);
		$infoSolicitud = $this->solicituddetfgMapper->comprobarId($dniAl["dniAlumno"]);
		$this->view->setVariable("existeSolicitud", $infoSolicitud);
		}
		if($estado["estadorCurso"]==5){
		$TFGacep = $this->tfgMapper->getTFG($dniAl["dniAlumno"]);
		$this->view->setVariable("TFGacep", $TFGacep);
		}
		$this->view->render("alumno", "indexAl");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }
  
  public function SolicitudTFG() {
	if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
		$dniAl = $this->alumnoMapper->getId($this->currentUser->getEmailA());
		$listarPropuestasTitulo = $this->propuestadetfgMapper->listarPropuestasTitulo();
		$this->view->setVariable("listarPropuestasTitulo", $listarPropuestasTitulo);
		$this->view->render("alumno", "Solicitud");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}
  }

  public function confirmarAsignacion() { 
    if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
       $id = $this->alumnoMapper->getId($this->currentUser->getEmailA());
	   $TFG = $this->tfgMapper->getTFG($id["dniAlumno"]);
       $this->view->setVariable("TFG", $TFG);
	   $this->view->render("alumno", "confirmarA");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}


  } 
  
}
