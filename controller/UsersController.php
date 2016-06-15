<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class UsersController extends BaseController {
  
  private $coordinadorMapper; 
  private $alumnoMapper; 
  private $profesorMapper;
  private $propuestadetfgMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->alumnoMapper = new AlumnoMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();

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
  
  public function actualizarEstadoCurso() {
    if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
		if($_POST["nuevoEstadoCurso"]=="0"){
           $this->coordinadorMapper->modificarEstadoCurso("0");
		   $this->view->setVariable("estadocurso","0");
		} else if($_POST["nuevoEstadoCurso"]=="1"){
           $this->coordinadorMapper->modificarEstadoCurso("1");
		   $this->view->setVariable("estadocurso","1");
		} else if($_POST["nuevoEstadoCurso"]=="2"){
           $this->coordinadorMapper->modificarEstadoCurso("2");
		   $this->view->setVariable("estadocurso","2");
		} else if($_POST["nuevoEstadoCurso"]=="3"){
           $this->coordinadorMapper->modificarEstadoCurso("3");
		   $this->view->setVariable("estadocurso","3");	 
		}		
		$this->view->render("coordinador", "indexCr");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
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
	
	
  public function modifyPr() {
    if (isset($this->currentUser) && $this->profesorMapper->checkuser($this->username)) {
	   $profesor= $this->profesorMapper->consultarUsuario($this->currentUser->getEmailP());
	   $this->view->setVariable("profesorInf",$profesor);
	   $this->view->render("profesor", "modificarPr");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }
  
  public function modificarProfesor(){
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
				$profesor = new Profesor($this->currentUser->getEmailP());
				$profesor->setPasswordP($pass);
				try {
					$profesor->validoParaActualizar();
					$this->profesorMapper->modificar($profesor);
					$this->view->redirect("Profesor", "index");
				} catch (ValidationException $ex) {
					$errors = $ex->getErrors();
					$this->view->setVariable("errors", $errors);
					$this->view->setFlash(i18n("Datos incorrectos"));
					
				}
			}
		   $this->view->redirect("profesor", "index");
		}
	}else{
		echo "Upss! no deberías estar aquí";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=alumno&action=index");
	}
  }
  
  public function realizarPropuesta() {
	if(isset($this->currentUser)) {
                    $propuesta = new PropuestaDeTFG();
                    $propuesta->setTitulo($_POST["titulo"]);
                    $propuesta->setDescripcion($_POST["descripcion"]);
					$dniprof = $this->profesorMapper->getId($this->currentUser->getEmailP());
					$propuesta->setTutor($dniprof["dniProfesor"]);
					if($_POST["cotutor"]!= NULL){
                    $propuesta->setCotutor($_POST["cotutor"]);
					}
                    try {
                        $propuesta->validoParaCrear();
                        $this->propuestadetfgMapper->insertar($propuesta);
                        $this->view->redirect("profesor", "index");
                    } catch (ValidationException $ex) {
                        $errors = $ex->getErrors();
                        $this->view->setVariable("errors", $errors);
                        $this->view->setFlash(i18n("Datos incorrectos"));						
                    }               
               $this->view->redirect("profesor", "index");           
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
