<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class CoordinadorController extends BaseController {
  
  private $coordinadorMapper;    
  private $profesorMapper;
  private $propuestadetfgMapper;
  
  public function __construct() {    
    parent::__construct();
    
    $this->coordinadorMapper = new CoordinadorMapper(); 
    $this->profesorMapper = new ProfesorMapper();
    $this->propuestadetfgMapper = new PropuestaDeTFGMapper();	
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
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $estado = $this->coordinadorMapper->estadoCursoActual(); 
       $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $this->view->render("coordinador", "gestionPropuestas");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }
  
}
