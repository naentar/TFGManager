<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class UsersController extends BaseController {
  
  private $coordinadorMapper; 
  private $alumnoMapper; 
  private $profesorMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->alumnoMapper = new AlumnoMapper();
	$this->profesorMapper = new ProfesorMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    //$this->view->setLayout("welcome");     
  }
  public function index()
    {
        $this->view->render("layouts", "welcome");
    }

  public function login() {
    if (isset($_POST["email"])){ 
   
      $login = $_POST["email"];
      $pass = $_POST["password"];
	  if ($this->coordinadorMapper->checkUser($login)){
		if ($this->coordinadorMapper->isValidUser($login,$pass)) {
		$_SESSION["currentuser"]=$_POST["email"]; 		
		$this->view->redirect("coordinador", "index");	
		}      		
	  } else if ($this->alumnoMapper->checkUser($login)) {
		if ($this->alumnoMapper->isValidUser($login, $pass)) {
			$_SESSION["currentuser"]=$_POST["email"];
			$this->view->redirect("alumno", "index");
		   }		  
     } else if ($this->profesorMapper->checkUser($login)) {
		if ($this->profesorMapper->isValidUser($login, $pass)) {
			$_SESSION["currentuser"]=$_POST["email"];
			$this->view->redirect("profesor", "index");
		   }		  
        }
	}
    $this->view->render("users", "login");        
  }
 
 
  public function modifyAl() {
    if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
           $alumno= $this->alumnoMapper->consultarUsuario($this->currentUser->getEmailA());
		   $this->view->setVariable("alumnoInf",$alumno);
		   $this->view->render("alumno", "modificarAl");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function modificarAlumno(){
        if(isset($this->currentUser)) {
            if (isset($_POST["password"]) && isset($_POST["sndpassword"])) {
                $pass = $_POST["password"];
                $pass2 = $_POST["sndpassword"];
                if ($pass != $pass2) {
                    $errors = array();
                    $errors["contrasenhaDistintasPro"] = "Las contrase&ntilde;as no coinciden";
                    $this->view->setVariable("errors", $errors);
                    $this->view->setFlash(i18n("Las contrase&ntilde;as no coinciden"));
                } else {
                    $alumno = new Alumno($this->currentUser->getEmailA());
                    $alumno->setTelefono($_POST["telefono"]);
                    $alumno->setDireccion($_POST["direccion"]);
                    $alumno->setLocalidad($_POST["localidad"]);
                    $alumno->setProvincia($_POST["provincia"]);
                    $alumno->setPasswordA($pass);
                    try {
                        $alumno->validoParaActualizar();
                        $this->alumnoMapper->modificar($alumno);
                        $this->view->redirect("Alumno", "index");
                    } catch (ValidationException $ex) {
                        $errors = $ex->getErrors();
                        $this->view->setVariable("errors", $errors);
                        $this->view->setFlash(i18n("Datos incorrectos"));
						
                    }
                }
               $this->view->redirect("alumno", "index");
            }
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=alumno&action=index");
        }
    }
  
	  	
      


  public function logout() {
    session_destroy();
    
    $this->view->redirect("users", "login");
   
  }
  
}
