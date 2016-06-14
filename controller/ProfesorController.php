<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class ProfesorController extends BaseController {
  
  private $profesorMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->profesorMapper = new ProfesorMapper();
 
  }
  public function index()
    {
        if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
            $this->view->render("profesor", "indexPr");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
    }
  
}
