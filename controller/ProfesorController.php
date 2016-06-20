<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class ProfesorController extends BaseController {
  
  private $profesorMapper; 
  private $coordinadorMapper;   
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->coordinadorMapper = new CoordinadorMapper();
 
  }
  public function index() {
	if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
		$estado = $this->coordinadorMapper->estadoCursoActual(); 
		$this->view->setVariable("estadocurso",$estado["estadorCurso"]);	         
		$listaProfesores = $this->profesorMapper->listarProfesores($this->username);
		$this->view->setVariable("listaProfesores", $listaProfesores);
		$this->view->render("profesor", "indexPr");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }
  
  public function solicitudesMutuoAcuerdo(){
    if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
		$listaProfesores = $this->profesorMapper->listarProfesores($this->username);
		$this->view->setVariable("listaProfesores", $listaProfesores);
		$listaAlumnos = $this->alumnoMapper->listarAlumnos();
		$this->view->setVariable("listaAlumnos", $listaAlumnos);
		$this->view->render("profesor", "PrTFG");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	} 
  
  } 
}
