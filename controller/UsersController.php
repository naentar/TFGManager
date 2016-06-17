<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");

class UsersController extends BaseController {
  
  private $coordinadorMapper; 
  private $alumnoMapper; 
  private $profesorMapper;
  private $propuestadetfgMapper; 
  private $solicituddetfgMapper;
  private $tfgMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->alumnoMapper = new AlumnoMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
	$this->solicituddetfgMapper = new SolicitudDeTFGMapper();
	$this->tfgMapper = new TFGMapper();

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
     } else {	 
	  $this->view->setFlash("Login incorrecto");
	 }
	}
    $this->view->render("users", "login");        
  }
  
  public function actualizarEstadoCurso() {
    if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
	    //https://www.google.com/settings/security/lesssecureapps
		require_once(__DIR__."/../phpmailer/PHPMailerAutoload.php");
		$gmaillog = $this->coordinadorMapper->infoGmail();
		foreach($gmaillog as $log):
			$gmail = $log["gmailCorreos"];	
            $passwdgmail = $log["contrasenhaCorreos"];			
	    endforeach;
		$mail = new PHPMailer;
		//$mail->SMTPDebug = 3;                               
		$mail->isSMTP();                                      
		$mail->Host = "smtp.gmail.com";  
		$mail->SMTPAuth = true;                               
		$mail->Username = $gmail;                             
		$mail->Password = $passwdgmail;                          
		$mail->SMTPSecure = 'ssl';                            
		$mail->Port = 465;                                    
		$mail->isHTML(true);
		$mail->setFrom($gmail);		
		if($_POST["nuevoEstadoCurso"]=="0"){
           $this->coordinadorMapper->modificarEstadoCurso("0");
		   $this->view->setVariable("estadocurso","0");
		} else if($_POST["nuevoEstadoCurso"]=="1"){
           $this->coordinadorMapper->modificarEstadoCurso("1");
		   $this->view->setVariable("estadocurso","1");		   
		   $mail->Subject = "Comienza la fase de propuestas de TFG por parte del profesorado";
		   $mail->Body = "Por favor, env&iacute;a tus propuestas en tu p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n en la p&aacute;gina.";			
		   $listaProfesores = $this->profesorMapper->listarProfesores("");
                foreach($listaProfesores as $profesor):
			        $mail->addAddress($profesor["email"]);						
			    endforeach; 			
			//Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
			//if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;			
		} else if($_POST["nuevoEstadoCurso"]=="2"){
           $this->coordinadorMapper->modificarEstadoCurso("2");
		   $this->view->setVariable("estadocurso","2");
		   $mail->Subject = "Comienza la fase de solicitudes de TFG por parte del alumnado";
		   $mail->Body = "Por favor, env&iacute;a tu solicitud en tu p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n en la p&aacute;gina.";			
		   $listaAlumnos = $this->alumnoMapper->listarAlumnos();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			//Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
			//if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
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
					$this->modifyAl();
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
			    $this->view->redirect("alumno", "index");
                }
               
            }
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
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
		header("Refresh: 5; index.php?controller=users&action=index");
	}
  }
  
  public function modifyCr() {
    if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
	   $coordinador= $this->coordinadorMapper->consultarUsuario($this->currentUser->getEmailC());
	   $this->view->setVariable("coordinadorInf",$coordinador);
	   $this->view->render("coordinador", "modificarCr");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }
  
  public function modificarCoordinador(){
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
				$coordinador = new Coordinador($this->currentUser->getEmailC());
				$coordinador->setPasswordC($pass);
				$coordinador->setGmail($_POST["gmail"]);
                $coordinador->setPasswordGmail($_POST["passwordg"]);
				try {
					$this->coordinadorMapper->modificar($coordinador);
					$this->view->redirect("coordinador", "index");
				} catch (ValidationException $ex) {
					$errors = $ex->getErrors();
					$this->view->setVariable("errors", $errors);
					$this->view->setFlash(i18n("Datos incorrectos"));
					
				}
			}
		   $this->view->redirect("coordinador", "index");
		}
	}else{
		echo "Upss! no deberías estar aquí";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
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
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
	  	
  public function realizarSolicitud() {
    if(isset($this->currentUser)) {
	  if($_POST["firstopt"]=="vacio1" && $_POST["secondopt"]=="vacio2" && $_POST["thirdopt"]=="vacio3" && $_POST["fourthopt"]=="vacio4" && $_POST["fifthopt"]=="vacio5"){
	        $this->view->setFlash("Solicitud incorrecta, no has solicitado ning&uacute;n TFG."); 	  
	    } else if($_POST["firstopt"]==$_POST["secondopt"] || $_POST["firstopt"]==$_POST["thirdopt"] || $_POST["firstopt"]==$_POST["fourthopt"] || $_POST["firstopt"]==$_POST["fifthopt"] || $_POST["secondopt"]==$_POST["thirdopt"]
		 || $_POST["secondopt"]==$_POST["fourthopt"] || $_POST["secondopt"]==$_POST["fifthopt"] || $_POST["thirdopt"]==$_POST["fourthopt"] || $_POST["thirdopt"]==$_POST["fifthopt"] || $_POST["fourthopt"]==$_POST["fifthopt"] ){
		    $this->view->setFlash("Solicitud incorrecta, no puedes seleccionar dos veces el mismo TFG");       		
		} else {
		        $alumno = $this->alumnoMapper->consultarUsuario($this->currentUser->getEmailA());
							 
				$solicitud = new SolicitudDeTFG();				
				$solicitud->setAlumno($alumno["dniAlumno"]);
					if($_POST["firstopt"]!="vacio1"){				
						$solicitud->setIdPropuesta($_POST["firstopt"]);
						$solicitud->setPrioridad("1");
						$this->solicituddetfgMapper->insertar($solicitud);
					}
					if($_POST["secondopt"]!="vacio2"){				
						$solicitud->setIdPropuesta($_POST["secondopt"]);
						$solicitud->setPrioridad("2");
						$this->solicituddetfgMapper->insertar($solicitud);
					}
					if($_POST["thirdopt"]!="vacio3"){				
						$solicitud->setIdPropuesta($_POST["thirdopt"]);
						$solicitud->setPrioridad("3");
						$this->solicituddetfgMapper->insertar($solicitud);
					}
					if($_POST["fourthopt"]!="vacio4"){				
						$solicitud->setIdPropuesta($_POST["fourthopt"]);
						$solicitud->setPrioridad("4");
						$this->solicituddetfgMapper->insertar($solicitud);
					}
					if($_POST["fifthopt"]!="vacio5"){				
						$solicitud->setIdPropuesta($_POST["fifthopt"]);
						$solicitud->setPrioridad("5");
						$this->solicituddetfgMapper->insertar($solicitud);
					}
				$this->view->redirect("alumno", "index");
				}                                      	
          $this->view->redirect("alumno", "index");         		  
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        } 

  }  
  
  public function mutuoAcuerdo() {
	if(isset($this->currentUser)) {
	    if($_POST["tutor"]=="sin"){
            $this->view->setFlash("Solicitud incorrecta, se debe seleccionar el tutor.");
        } else if($_POST["tutor"]==$_POST["cotutor"]){
		       $this->view->setFlash("Solicitud incorrecta, el tutor y el cotutor no pueden ser la misma persona.");
		    }else{        		
				$TFG = new TFG();
				$TFG->setIdTFG($this->tfgMapper->generarCodigo());
				$TFG->setTituloEs($_POST["titulo"]);
				$TFG->setTituloEn($_POST["titulo"]);
				$TFG->setTituloGa($_POST["titulo"]);
				$TFG->setEmpresa($_POST["empresa"]);
				$TFG->setTutor($_POST["tutor"]);
				$dniAl = $this->alumnoMapper->getId($this->currentUser->getEmailA());
				$TFG->setAlumno($dniAl["dniAlumno"]);
				$TFG->setCotutor($_POST["cotutor"]);
				$this->tfgMapper->insertar($TFG);               
		        $this->view->redirect("alumno", "alumnoTFG"); 
			}
		  $this->view->redirect("alumno", "alumnoTFG"); 	
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function gestionarPropuesta() {
    if(isset($this->currentUser)) {
                    $propuesta = new PropuestaDeTFG();
					$propuesta->setIdPk(($_POST["idpropuesta"]));
					if(isset($_POST["modificar"])){
					   $propuesta->setTitulo($_POST["titulo"]);
                       $propuesta->setDescripcion($_POST["descripcion"]);
					   $propuesta->setTutor($_POST["tutor"]);
                       $propuesta->setCotutor(($_POST["cotutor"]));
					   $this->propuestadetfgMapper->modificar($propuesta);
                       $this->view->redirect("coordinador", "gestionPropuestas");					
					}else if(isset($_POST["eliminar"])){
					   $this->propuestadetfgMapper->eliminar($propuesta);
                       $this->view->redirect("coordinador", "gestionPropuestas");										
					}               
               $this->view->redirect("coordinador", "gestionPropuestas");           
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function logout() {
    session_destroy();
    
    $this->view->redirect("users", "login");
   
  }
  
}
