<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class ProfesorController extends BaseController {
  
  private $profesorMapper; 
  private $coordinadorMapper; 
  private $tfgMapper;
  private $alumnoMapper;
  private $propuestadetfgMapper;
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->tfgMapper = new TFGMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
 
  }
  public function index() {
	if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
		$estado = $this->coordinadorMapper->estadoCursoActual(); 
		$this->view->setVariable("estadocurso",$estado["estadorCurso"]);
		$this->view->render("profesor", "indexPr");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }

  public function modifyPr() {
    if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
	   $profesor= $this->profesorMapper->consultarUsuario($this->currentUser->getEmailP());
	   $this->view->setVariable("profesorInf",$profesor);
	   $this->view->render("profesor", "modificarPr");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }  
  
  public function gestionSolicitudes() {
    if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
	   $listaProfesoresSol = $this->profesorMapper->listarProfesores($this->username);
	   $this->view->setVariable("listaProfesoresSol", $listaProfesoresSol);
       $dniProf = $this->profesorMapper->getId($this->username);
	   $listarTFGs = $this->tfgMapper->listarTFGsMutuoAcuerdo($dniProf["dniProfesor"]);
       $this->view->setVariable("listarTFGs", $listarTFGs);	
	   $listaAlumnos = $this->alumnoMapper->listarAlumnos();
	   $this->view->setVariable("listaAlumnos", $listaAlumnos);
	   $listaProfesores = $this->profesorMapper->listarProfesores($this->username);
	   $this->view->setVariable("listaProfesores", $listaProfesores);
	   $this->view->render("profesor", "gestionSolicitudes");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }
  
  public function gestionPropuestas() {
    if (isset($this->currentUser) && $this->profesorMapper->checkuser($this-> username)) {
	   $listarPropuestas = $this->propuestadetfgMapper->listarPropuestas();
       $this->view->setVariable("listarPropuestas", $listarPropuestas);
	   $dniProf = $this->profesorMapper->getId($this->username);
	   $this->view->setVariable("dniProf", $dniProf);
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($dniProf["dniProfesor"]);
	   $this->view->setVariable("numeroPropPor",$numeroDeProp);	
	   $listaProfesoresProp = $this->profesorMapper->listarProfesores($this->username);
	   $this->view->setVariable("listaProfesoresProp", $listaProfesoresProp);	   
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
	   $numProp = $this->propuestadetfgMapper->numeroDePropuestas($dniProf["dniProfesor"]);
	   $this->view->setVariable("numProp", $numProp);
	   $this->view->render("profesor", "gestionPropuestas");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  
  }
}
