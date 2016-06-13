<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Coordinador.php");
require_once(__DIR__."/../model/CoordinadorMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class UsersController
 * 
 * Controller to login, logout and user registration
 * 
 * @author lipido <lipido@gmail.com>
 */
class CoordinadorController extends BaseController {
  
  /**
   * Reference to the UserMapper to interact
   * with the database
   * 
   * @var UserMapper
   */  
  private $coordinadorMapper;    
  
  public function __construct() {    
    parent::__construct();
    
    $this->coordinadorMapper = new CoordinadorMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    //$this->view->setLayout("welcome");     
  }
  public function index()
    {
        //Creamos la vista
        $this->view->render("layouts", "welcome");
    }
	

 /**
   * Action to register
   * 
   * When called via GET, it shows the register form.
   * When called via POST, it tries to add the user
   * to the database.
   * 
   * The expected HTTP parameters are:
   * <ul>
   * <li>login: The username (via HTTP POST)</li>
   * <li>passwd: The password (via HTTP POST)</li>      
   * </ul>
   *
   * The views are:
   * <ul>
   * <li>users/register: If this action is reached via HTTP GET (via include)</li>
   * <li>users/login: If login succeds (via redirect)</li>
   * <li>users/register: If validation fails (via include). Includes these view variables:</li>
   * <ul>   
   *  <li>user: The current User instance, empty or being added
   *  (but not validated)</li>      
   *  <li>errors: Array including validation errors</li>   
   * </ul>   
   * </ul>
   * 
   * @return void
   */


 /**
   * Action to logout
   * 
   * This action should be called via GET
   * 
   * No HTTP parameters are needed.
   *
   * The views are:
   * <ul>
   * <li>users/login (via redirect)</li>
   * </ul>
   *
   * @return void
   */
  public function logout() {
    session_destroy();
    
    // perform a redirection. More or less: 
    // header("Location: index.php?controller=users&action=login")
    // die();
    $this->view->redirect("coordinador", "login");
   
  }
  
}
