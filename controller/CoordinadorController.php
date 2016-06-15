<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class CoordinadorController extends BaseController {
  
  private $coordinadorMapper;    
  
  public function __construct() {    
    parent::__construct();
    
    $this->coordinadorMapper = new CoordinadorMapper();    
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
  
	

  public function logout() {
    session_destroy();

    $this->view->redirect("coordinador", "login");
   
  }
  
}
