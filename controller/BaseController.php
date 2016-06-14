<?php
//file: controller/BaseController.php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Coordinador.php");
require_once(__DIR__."/../model/CoordinadorMapper.php");

require_once(__DIR__."/../model/Alumno.php");
require_once(__DIR__."/../model/AlumnoMapper.php");

require_once(__DIR__."/../model/Profesor.php");
require_once(__DIR__."/../model/ProfesorMapper.php");

require_once(__DIR__."/../model/PropuestaTFG.php");
//require_once(__DIR__."/../model/PropuestaTFGMapper.php");

require_once(__DIR__."/../model/TFG.php");
//require_once(__DIR__."/../model/TFGMapper.php");



class BaseController {

  protected $view;
  
  protected $currentUser;
  protected $username;
  
  private $coorMapper;
  private $alumMapper;
  private $profMapper;
  
  public function __construct() {
    
    $this->view = ViewManager::getInstance();
	
	$this->coorMapper = new CoordinadorMapper();
	$this->alumMapper = new AlumnoMapper();
	$this->profMapper = new ProfesorMapper();

    if (session_status() == PHP_SESSION_NONE) {      
	session_start();
    }
    
    if(isset($_SESSION["currentuser"])) {
		  if($this->coorMapper->checkUser($_SESSION["currentuser"])){		  
		  $this->currentUser = new Coordinador($_SESSION["currentuser"]);      
		  //add current user to the view, since some views require it
		  $this->view->setVariable("currentusername", $this->currentUser->getEmailC());
		  $this->username = $this->currentUser->getEmailC();
	      } else if($this->alumMapper->checkUser($_SESSION["currentuser"])){		  
			  $this->currentUser = new Alumno($_SESSION["currentuser"]);      
			  //add current user to the view, since some views require it
			  $this->view->setVariable("currentusername", $this->currentUser->getEmailA());
			  $this->username = $this->currentUser->getEmailA();
		  } else if($this->profMapper->checkUser($_SESSION["currentuser"])){		  
			  $this->currentUser = new Profesor($_SESSION["currentuser"]);      
			  //add current user to the view, since some views require it
			  $this->view->setVariable("currentusername", $this->currentUser->getEmailP());
			  $this->username = $this->currentUser->getEmailP();
		  }
    }     
  }
}
