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
	    $estado = $this->coordinadorMapper->estadoCursoActual(); 
        $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
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
		   $this->view->setVariable("estadocurso","0");
		   if(empty($_POST["datosprofesor"]) || empty($_POST["datosalumno"])){
		   $this->view->setFlash(i18n("Debes introducir un archivo para cada tipo de usuario"));
		   }else{
				if(file_exists($_POST["datosprofesor"]) && file_exists($_POST["datosalumno"])){
				    $this->coordinadorMapper->modificarEstadoCurso("1");
				    $this->view->setVariable("estadocurso","1");
				    $this->coordinadorMapper->cargarDatos($_POST["datosprofesor"],$_POST["datosalumno"]);					
				} else{
				$this->view->setFlash(i18n("Los archivos introducidos no se encuentran en el directorio del servidor"));
				}			
		   }
		   $this->view->redirect("coordinador", "index");
		} else if($_POST["nuevoEstadoCurso"]=="2"){
           $this->coordinadorMapper->modificarEstadoCurso("2");
		   $this->view->setVariable("estadocurso","2");	
           $listaProfesores = $this->profesorMapper->listarProfesores("");
                foreach($listaProfesores as $profesor):	
				   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($profesor["dniProfesor"]);
				   if($numeroDeProp<=0){
				   $mail->Subject = "Comienza la fase de propuestas de TFG por parte del profesorado";
				   $mail->Body = "Me gustar&iacute;a informarle que supera el n&uacute;mero de TFGs que los profesores deben presentar este año, en caso de no estar 
				   tutorizando y por tanto no tiene que realizar ninguna propuesta.";				   
				   $mail->addAddress($profesor["email"]);	
				   }else if($numeroDeProp>0){
				   $mail->Subject = "Comienza la fase de propuestas de TFG por parte del profesorado";
				   $mail->Body = "Por favor, realiza tus propuestas de TFG en tu p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n 
				   en la p&aacute;gina. El número de propuestas que debes realizar es: ".$numeroDeProp." y tienen de plazo hasta el ".$_POST["fecha"].".";				   
				   $mail->addAddress($profesor["email"]);
				   //Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
				   //if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
				   }		   
				endforeach; 								
		} else if($_POST["nuevoEstadoCurso"]=="3"){
		   $this->coordinadorMapper->modificarEstadoCurso("3");
		   $this->view->setVariable("estadocurso","3"); 
		   //Generar PDF de propuestas
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $filename="propuestas.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'PROPOSTAS DE TRABALLO FIN DE GRAO',0,1);			
			$pdf->SetFont('Arial','',15);
            $pdf->Cell(40,10,utf8_decode('CURSO ACADÉMICO 2015-2016'),0,1);
			$pdf->Ln(8);
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Dereito Privado");
			if (!empty($listapropuestas)) {
			    $pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: Dereito Privado'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Enxeñaría de Sistemas e Automática");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: ENXEÑARÍA DE SISTEMAS E AUTOMÁTICA'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Informática e Investigación Operativa");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: ESTATÍSTICA E INVESTIGACIÓN OPERATIVA'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Informática");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: Informática'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Matemática aplicada II");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: MATEMÁTICA APLICADA II'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}

			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Matemáticas");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: MATEMÁTICAS'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Organización de Empresas y Marketing");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: ORGANIZACIÓN DE EMPRESAS Y MARKETING'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Tecnología y Electrónica");
			if (!empty($listapropuestas)) {
				$pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: TECNOLOGÍA ELECTRÓNICA'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$propuesta[1]),1,1);
				}
				$pdf->Cell(0,10,utf8_decode('Titulación: Grao en Enxeñaría Informática'),1,1);
				$pdf->Cell(0,10,utf8_decode('Resumo: '.$propuesta["descripcion"]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
            $pdf->Output('F',$filename);		   
		   $mail->Subject = "Comienza la fase de solicitudes de TFG por parte del alumnado";
		   $mail->Body = "Podr&aacte;s comprobar la lista de propuestas en el pdf adjunto o en la p&aacute;gina. Por favor, env&iacute;a tu solicitud en tu p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n en la p&aacute;gina. ";	
           $mail->addAttachment('/../propuestas.pdf');		   
		   $listaAlumnos = $this->alumnoMapper->listarAlumnos();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			//Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
			//if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
							
		} else if($_POST["nuevoEstadoCurso"]=="4"){
		   $this->coordinadorMapper->modificarEstadoCurso("4");
		   $this->view->setVariable("estadocurso","4");
		   //Asignar Solicitudes:
			$arr = array();
			$alumnosorden = $this->alumnoMapper->ordenarPorNota();
			    foreach($alumnosorden as $actual):
			        $alumnoActual = $actual["dniAlumno"];
					$solicitudAlumno = $this->solicituddetfgMapper->getSolicitud($alumnoActual);
					if (!empty($solicitudAlumno)) {					
					//Seleccionar toda la información referente al identificador de la propuesta
					$propuestaSeleccionada = $this->propuestadetfgMapper->getPropuesta($solicitudAlumno["PropuestasDeTFG_idPropuestasDeTFG"]);
					//insertar en TFG la información obtenida a partir de la consulta sobre la propuesta
					$tfgprop = new TFG();
					$tfgprop->setIdTFG($this->tfgMapper->generarCodigo());
					$tfgprop->setTituloEs($propuestaSeleccionada["titulo"]);
					$tfgprop->setTituloEn("solicitado");
					$tfgprop->setTituloGa($propuestaSeleccionada["titulo"]);
					$tfgprop->setEmpresa(0);
					$tfgprop->setTutor($propuestaSeleccionada["Profesor_dniProfesor"]);
					$tfgprop->setAlumno($alumnoActual);
					$tfgprop->setCotutor($propuestaSeleccionada["Profesor_dniProfesorCotutor"]);
					$this->tfgMapper->insertar($tfgprop);  					
					//eliminar todas las entradas relacionadas con la solicitud del alumno y todas las entradas relacionadas con la propuesta que ha sido asignada, de la tabla propuestasdetfg
					$this->solicituddetfgMapper->eliminarSolicitud($alumnoActual);	
                    $this->solicituddetfgMapper->eliminarPropuesta($solicitudAlumno["PropuestasDeTFG_idPropuestasDeTFG"]);					
					//eliminar propuesta asignada de la tabla propuestadetfg
					$propid = new PropuestaDeTFG();
					$propid->setIdPk($solicitudAlumno["PropuestasDeTFG_idPropuestasDeTFG"]);
					$this->propuestadetfgMapper->eliminar($propid);
					}else{
					//anhadir a array gente que no le queden opciones en su solicitud
					array_push($arr,$alumnoActual);					
					}
			    endforeach;
				//realizar asignacion por sorteo sobre la gente que no le queden opciones  en su solicitud              
				if(!empty($arr)){
				foreach($arr as $alum):
                    $listaprop = $this->propuestadetfgMapper->sorteo(); 
					if(!empty($listaprop)){					
                    $tfgsort = new TFG();
					$tfgsort->setIdTFG($this->tfgMapper->generarCodigo());
					$tfgsort->setTituloEs($listaprop["titulo"]);
					$tfgsort->setTituloEn("solicitado");
					$tfgsort->setTituloGa($listaprop["titulo"]);
					$tfgsort->setEmpresa(0);
					$tfgsort->setTutor($listaprop["Profesor_dniProfesor"]);
					$tfgsort->setAlumno($alum);
					$tfgsort->setCotutor($listaprop["Profesor_dniProfesorCotutor"]);
					$this->tfgMapper->insertar($tfgsort);
                    $propid = new PropuestaDeTFG();
					echo $listaprop["idPropuestasDeTFG"];
					$propid->setIdPk($listaprop["idPropuestasDeTFG"]);
					$this->propuestadetfgMapper->eliminar($propid);	
					}		
                endforeach;	
				}			
				//Generar PDF de asignaciones provisionales
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $filename="asignacionesP.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,utf8_decode('Asignación provisional de Traballo de Fin de Grao 2016-2017'),0,1);			
			$pdf->Ln(8);
			$tfgsasignados = $this->tfgMapper->listarTFGs("si");
			if (!empty($tfgsasignados)) {
				$pdf->SetFont('Arial','',12);
			foreach($tfgsasignados as $solicitud):	
                $pdf->Cell(0,10,utf8_decode('Alumno/a: '.$solicitud[2]),1,1);			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$solicitud["tituloEs"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$solicitud[0]),1,1);
				if($solicitud[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				}		
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$solicitud[1]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
            $pdf->Output('F',$filename);				
				$mail->Subject = "Comienza la etapa de asignaciones oficiales";
		        $mail->Body = "Aqu&iacute; puedes comprobar la lista de asignaciones de TFG provisional.";			   
		        $mail->addAttachment('/../asignacionesP.pdf');
				$listaAlumnos = $this->alumnoMapper->listarAlumnos();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			//Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
			//if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
        } else if($_POST["nuevoEstadoCurso"]=="5"){
           $this->coordinadorMapper->modificarEstadoCurso("5");
		   $this->view->setVariable("estadocurso","5"); 
           //Generar PDF de asignaciones definitivas
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $filename="asignacionesD.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,utf8_decode('Asignación definitiva de Traballo de Fin de Grao 2016-2017'),0,1);			
			$pdf->Ln(8);
			$tfgsasignados = $this->tfgMapper->listarTFGs("si");
			if (!empty($tfgsasignados)) {
				$pdf->SetFont('Arial','',12);
			foreach($tfgsasignados as $solicitud):	
                $pdf->Cell(0,10,utf8_decode('Alumno/a: '.$solicitud[2]),1,1);			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$solicitud["tituloEs"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$solicitud[0]),1,1);
				if($solicitud[1]=="NULL"){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				}		
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$solicitud[1]),1,1);
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
            $pdf->Output('F',$filename);				
				$mail->Subject = "Comienza la etapa de asignaciones oficiales";
		        $mail->Body = "Podr&aacte;s confirmar que estas cursando el TFG que te ha sido asignado rellenando el formulario que se encuentra en la web, donde debes introducir el título del TFG en tres idiomas y confirmar si se realiza en empresa o no. ";			   
		        $mail->addAttachment('/../asignacionesD.pdf');
				$listaAlumnos = $this->alumnoMapper->listarAlumnos();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			//Descomentar para enviar mails (comentado para realizar pruebas sobre la aplicación):
			//if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;		   
		} else if($_POST["nuevoEstadoCurso"]=="6"){
           $this->coordinadorMapper->modificarEstadoCurso("6");
		   $this->view->setVariable("estadocurso","6");
           $this->tfgMapper->rechazarNoPresentados();		   
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
               $this->view->redirect("profesor", "PresentarPropuestas");           
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
	    if($_POST["alumno"]=="sin"){
            $this->view->setFlash("Solicitud incorrecta, se debe seleccionar el alumno.");
        } else{        		
				$TFG = new TFG();
				$TFG->setIdTFG($this->tfgMapper->generarCodigo());
				$TFG->setTituloEs($_POST["titulo"]);
				$TFG->setTituloEn("solicitado");
				$TFG->setTituloGa($_POST["titulo"]);
				$TFG->setEmpresa($_POST["empresa"]);
				$dniPr = $this->profesorMapper->getId($this->currentUser->getEmailP());
				$TFG->setTutor($dniPr["dniProfesor"]);				
				$TFG->setAlumno($_POST["alumno"]);
				$TFG->setCotutor($_POST["cotutor"]);
				$this->tfgMapper->insertar($TFG); 
				$this->profesorMapper->actualizarNumeroDeTFGs(0,$dniPr["dniProfesor"]);
				$this->profesorMapper->actualizarNumeroDeTFGs(1,$_POST["cotutor"]);				
		        $this->view->redirect("profesor", "solicitudesMutuoAcuerdo"); 
			}
		  $this->view->redirect("profesor", "solicitudesMutuoAcuerdo"); 	
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
                       $this->view->redirect("profesor", "gestionPropuestas");					
					}else if(isset($_POST["eliminar"])){
					   $this->propuestadetfgMapper->eliminar($propuesta);
                       $this->view->redirect("profesor", "gestionPropuestas");					   
					}               
               $this->view->redirect("profesor", "gestionPropuestas");           
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function gestionarPropuestaC() {
    if(isset($this->currentUser)) {
		$propuesta = new PropuestaDeTFG();
		$propuesta->setIdPk(($_POST["idpropuesta"]));
		$this->profesorMapper->actualizarNumeroDeTFGs(3,$_POST["tutor"]);
		$this->profesorMapper->actualizarNumeroDeTFGs(2,$_POST["cotutor"]);		
		$this->propuestadetfgMapper->eliminar($propuesta); 
		$this->view->redirect("coordinador", "gestionPropuestas");					                           
	}else{
		echo "Upss! no deberías estar aquí";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}
  
  }
  
  public function gestionarSolicitud() {
    if(isset($this->currentUser)) {
				$tfg = new TFG();
				$tfg->setIdTFG(($_POST["idTFG"]));
				$this->tfgMapper->eliminar($tfg);
				$this->profesorMapper->actualizarNumeroDeTFGs(3,$_POST["tutor"]);
				$this->profesorMapper->actualizarNumeroDeTFGs(2,$_POST["cotutor"]);
				$this->view->redirect("coordinador", "gestionSolicitudes");					                        
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
    public function gestionarSolicitudMutuo() {
    if(isset($this->currentUser)) {
                    $tfg = new TFG();
					$tfg->setIdTFG(($_POST["idTFG"]));
					if(isset($_POST["eliminar"])){
					   $this->tfgMapper->eliminar($tfg);
					   $this->profesorMapper->actualizarNumeroDeTFGs(3,$dniPr["dniProfesor"]);
					   $this->profesorMapper->actualizarNumeroDeTFGs(2,$_POST["cotutor"]);	
                       $this->view->redirect("profesor", "gestionSolicitudes");					
					}else if(isset($_POST["modificar"])){
                       $tfg->setEmpresa($_POST["empresa"]);
					   $tfg->setTutor($_POST["tutor"]);
                       $tfg->setCotutor(($_POST["cotutor"]));
					   $tfg->setTituloEn($_POST["tituloEn"]);
					   $tfg->setTituloEs($_POST["titulo"]);
					   $tfg->setTituloGa($_POST["titulo"]);
					   $tfg->setAlumno($_POST["alumno"]);
					   $this->tfgMapper->modificarMutuo($tfg);
                       $this->view->redirect("profesor", "gestionSolicitudes");
					}               
               $this->view->redirect("profesor", "gestionPropuestas");           
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function confirmarAnte() {
    if(isset($this->currentUser)) {
			$tfg = new TFG();
			$tfg->setIdTFG(($_POST["idTFG"]));
			$tfg->setTituloEn($_POST["tituloEn"]);
			$tfg->setTituloEs($_POST["tituloEs"]);
			$tfg->setTituloGa($_POST["tituloGa"]);
			$this->tfgMapper->modificarTitulos($tfg);
			$this->view->redirect("alumno", "index");           
        }else{
            echo "Upss! no deberías estar aquí";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        } 
  }
  
  public function gestionarTFGs() {
    if(isset($this->currentUser)) {
				$tfg = new TFG();
				$tfg->setIdTFG(($_POST["idTFG"]));
				if(isset($_POST["eliminar"])){
				   $this->tfgMapper->eliminar($tfg);
				   $this->view->redirect("coordinador", "gestionTFGs");					
				}else if(isset($_POST["modificar"])){
				   $tfg->setEmpresa($_POST["empresa"]);
				   $tfg->setTutor($_POST["tutor"]);
				   $tfg->setCotutor(($_POST["cotutor"]));			   
				   $tfg->setTituloEn($_POST["tituloEn"]);
				   $tfg->setTituloEs($_POST["tituloEs"]);
				   $tfg->setTituloGa($_POST["tituloGa"]);
				   $this->tfgMapper->modificar($tfg);
				   $this->view->redirect("coordinador", "gestionTFGs");
				   }                          
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
