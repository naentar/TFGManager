<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class AlumnoController extends BaseController {
  
  private $alumnoMapper;
  private $coordinadorMapper;
  private $propuestadetfMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
 
  }
  public function index() {
        if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
            $estado = $this->coordinadorMapper->estadoCursoActual(); 
            $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
			$listaPropuestas = $this->propuestadetfgMapper->listarPropuestas();
            $this->view->setVariable("listarPropuestas", $listaPropuestas);
			$this->view->render("alumno", "indexAl");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
    }
	
  	
  
}
