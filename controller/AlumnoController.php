<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class AlumnoController extends BaseController {
  
  private $alumnoMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
 
  }
  public function index() {
        if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
            $this->view->render("alumno", "indexAl");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
    }
	
  	
  
}
