<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class CoordinadorController extends BaseController {
  
  private $coordinadorMapper;    
  private $profesorMapper;
  private $propuestadetfgMapper;
  private $tfgMapper;
  
  public function __construct() {    
    parent::__construct();
    
    $this->coordinadorMapper = new CoordinadorMapper(); 
    $this->profesorMapper = new ProfesorMapper();
    $this->propuestadetfgMapper = new PropuestaDeTFGMapper();
    $this->tfgMapper = new TFGMapper();	
  }
  
  public function index() {
        if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
		    $estado = $this->coordinadorMapper->estadoCursoActual(); 
            $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
            $this->view->render("coordinador", "indexCr");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function gestionPropuestas(){
	if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
	   $listarPropuestas = $this->propuestadetfgMapper->listarPropuestas();
       $this->view->setVariable("listarPropuestas", $listarPropuestas);
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
	   $aux=0;
	   foreach($listaProfesores as $profesor):
	   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($profesor["dniProfesor"]);
	   $numProp = $this->propuestadetfgMapper->numeroDePropuestas($profesor["dniProfesor"]);
	   $total = $numeroDeProp - $numProp;
	   $listaProfesores[$aux]["numeroDeTFGs"] = $total;	
	   $aux++;
	   endforeach;
	   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($profesor["dniProfesor"]);
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $estado = $this->coordinadorMapper->estadoCursoActual();
       $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
	   $this->view->render("coordinador", "gestionPropuestas");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }
  
  public function gestionSolicitudes(){
	if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
       $listarTFGs = $this->tfgMapper->listarTFGs("no");
       $this->view->setVariable("listarTFGs", $listarTFGs);	   
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $this->view->render("coordinador", "gestionSolicitudes");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }
  
  public function gestionTFGs(){
	if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
	   $estado = $this->coordinadorMapper->estadoCursoActual(); 
       $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
	   $listarPropuestasTitulo = $this->propuestadetfgMapper->listarPropuestasTitulo();
	   $this->view->setVariable("listarPropuestasTitulo", $listarPropuestasTitulo);
	   $listarAlumnos = $this->tfgMapper->getAlumnosCursandoTFG();
	   $this->view->setVariable("listarAlumnos", $listarAlumnos);
       $listarTFGs = $this->tfgMapper->listarTFGs("no");
       $this->view->setVariable("listarTFGs", $listarTFGs);	   
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $this->view->render("coordinador", "gestionTFGs");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }
  
}
