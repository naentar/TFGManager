<?php
//file: controller/BaseController.php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Coordinador.php");
require_once(__DIR__."/../model/CoordinadorMapper.php");

require_once(__DIR__."/../model/Alumno.php");
//require_once(__DIR__."/../model/AlumnoMapper.php");

require_once(__DIR__."/../model/Profesor.php");
//require_once(__DIR__."/../model/ProfesorMapper.php");

require_once(__DIR__."/../model/PropuestaTFG.php");
//require_once(__DIR__."/../model/PropuestaTFGMapper.php");

require_once(__DIR__."/../model/TFG.php");
//require_once(__DIR__."/../model/TFGMapper.php");



/**
 * Class BaseController
 *
 * Implements a basic super constructor for
 * the controllers in the Blog App.
 * Basically, it provides some protected
 * attributes and view variables.
 * 
 * @author lipido <lipido@gmail.com>
 */
class BaseController {

  /**
   * The view manager instance
   * @var ViewManager
   */
  protected $view;
  
  /**
   * The current user instance
   * @var User
   */
  protected $currentUser;
  protected $username;
  
  private $coorMapper;
  
  public function __construct() {
    
    $this->view = ViewManager::getInstance();
	
	$this->coorMapper = new CoordinadorMapper();

    // get the current user and put it to the view
    if (session_status() == PHP_SESSION_NONE) {      
	session_start();
    }
    
    if(isset($_SESSION["currentuser"])) {
		  if($this->coorMapper->checkUser($_SESSION["currentuser"])){	
		  $this->currentUser = new Coordinador($_SESSION["currentuser"]);      
		  //add current user to the view, since some views require it
		  $this->view->setVariable("currentusername", $this->currentUser->getEmailC());
	  }
    }     
  }
}
