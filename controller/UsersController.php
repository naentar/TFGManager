<?php

require_once(__DIR__."/../core/ViewManager.php");

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
		}else {
			$this->view->setFlash("Login incorrecto");
			}      		
	  } else if ($this->alumnoMapper->checkUser($login)) {
		if ($this->alumnoMapper->isValidUser($login, $pass)) {
			$_SESSION["currentuser"]=$_POST["email"];
			$this->view->redirect("alumno", "index");
		   }else {
			$this->view->setFlash("Login incorrecto");
			}
     } else if ($this->profesorMapper->checkUser($login)) {
		if ($this->profesorMapper->isValidUser($login, $pass)) {
			$_SESSION["currentuser"]=$_POST["email"];
			$this->view->redirect("profesor", "index");
		   }else {
			$this->view->setFlash("Login incorrecto");
			}		  
     } else {	 
	  $this->view->setFlash("Login incorrecto");
	 }
	}
    $this->view->render("users", "login");       
  }
  
  public function actualizarEstadoCurso() {
    if (isset($this->currentUser) && $this->coordinadorMapper->checkuser($this->username)) {
		require_once(__DIR__."/../phpmailer/PHPMailerAutoload.php");
		$gmaillog = $this->coordinadorMapper->infoGmail();
		foreach($gmaillog as $log):
			$gmail = $log["gmailCorreos"];	
            $passwdgmail = $log["contrasenhaCorreos"];			
	    endforeach;
		$mail = new PHPMailer;                               
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
		   $fecha = $_POST["fecha"];
		   if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $fecha)){
		   $fechaAr = explode('/', $fecha);
		   if(checkdate($fechaAr[1],$fechaAr[0],$fechaAr[2])){
		   $result = $this->coordinadorMapper->setFechaCurso($_POST["fechaCurso"]);
		   if($result==false){
		   $this->view->setFlash("El valor de la fecha del curso introducido es incorrecto");
		   }else{
		   if(empty($_POST["datosprofesor"]) && empty($_POST["datosalumno"]) && empty($_POST["datostfg"])){
		        $this->coordinadorMapper->modificarEstadoCurso("1");
				$this->view->setVariable("estadocurso","1");
				$listaProfesores = $this->profesorMapper->listarProfesores("");
				$mail->Subject = "Comienza la fase de solicitudes de TFG de mutuo acuerdo por parte del profesorado";
				$mail->Body = "Me gustar&iacute;a informarle de que ha dado comienzo la fase de solicitudes de mutuo acuerdo, donde podr&aacute; gestionar sus propias solicitudes en caso de que realice alg&uacute;n acuerdo con un alumno.
				Tiene como fecha l&iacute;mite hasta el ".$_POST["fecha"].".";	
				foreach($listaProfesores as $profesor):	
				$mail->addAddress($profesor["email"]);				
				endforeach;
				if($gmail!=NULL || $gmail!=""){
				if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
				}
	       }else if(!empty($_POST["datosprofesor"]) && !empty($_POST["datosalumno"]) && !empty($_POST["datostfg"])){
		      if(file_exists($_POST["datosprofesor"]) && file_exists($_POST["datosalumno"]) && file_exists($_POST["datostfg"])){
                $this->coordinadorMapper->cargarDatos($_POST["datosprofesor"],$_POST["datosalumno"],$_POST["datostfg"]);
				$this->coordinadorMapper->modificarEstadoCurso("1");
				$this->view->setVariable("estadocurso","1");
				$listaProfesores = $this->profesorMapper->listarProfesores("");
				$mail->Subject = "Comienza la fase de solicitudes de TFG de mutuo acuerdo por parte del profesorado";
				$mail->Body = "Me gustar&iacute;a informarle de que ha dado comienzo la fase de solicitudes de mutuo acuerdo, donde podr&aacute; gestionar sus propias solicitudes en caso de que realice alg&uacute;n acuerdo con un alumno.
				Tiene como fecha l&iacute;mite hasta el ".$_POST["fecha"].".";	
				foreach($listaProfesores as $profesor):	
				$mail->addAddress($profesor["email"]);				
				endforeach;
				if($gmail!=NULL || $gmail!=""){
				if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
				}
		      }else{
		        $this->view->setFlash("El archivo no se encuentra en el directorio del servidor.");
		      }
		    }else{
			  $this->view->setFlash("No has introducido los tres excel de manera simult&aacute;nea");
			}
			}
           }else{
			$this->view->setFlash("Fecha incorrecta");
		   }		   
		   }else{
		   $this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   }			
		   $this->view->redirect("coordinador", "index");
		} else if($_POST["nuevoEstadoCurso"]=="2"){
		   $this->view->setVariable("estadocurso","1");
		   $fecha = $_POST["fecha"];
		   if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $fecha)){
		   $fechaAr = explode('/', $fecha);
		   if(checkdate($fechaAr[1],$fechaAr[0],$fechaAr[2])){
           $this->coordinadorMapper->modificarEstadoCurso("2");
		   $this->view->setVariable("estadocurso","2");	
           $listaProfesores = $this->profesorMapper->listarProfesores("");
                foreach($listaProfesores as $profesor):	
				   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($profesor["dniProfesor"]);
				   if($numeroDeProp<=0){
				   $mailmas = new PHPMailer;                              
				   $mailmas->isSMTP();                                      
				   $mailmas->Host = "smtp.gmail.com";  
				   $mailmas->SMTPAuth = true;                               
			       $mailmas->Username = $gmail;                             
				   $mailmas->Password = $passwdgmail;                          
				   $mailmas->SMTPSecure = 'ssl';                            
				   $mailmas->Port = 465;                                    
				   $mailmas->isHTML(true);
				   $mailmas->setFrom($gmail);	
				   $mailmas->Subject = "Comienza la fase de propuestas de TFG por parte del profesorado";
				   $mailmas->Body = "Me gustar&iacute;a informarle que supera el n&uacute;mero de TFGs que los profesores deben presentar este año, en caso de no estar 
				   tutorizando y por tanto no tiene que realizar ninguna propuesta.";				   
				   $mailmas->addAddress($profesor["email"]);
                   if($gmail!=NULL){
				   if(!$mailmas->Send()) echo "Mailer error" .$mailmas->ErrorInfo;
				   }				   
				   }else if($numeroDeProp>0){
				   $mailmenos = new PHPMailer;                              
				   $mailmenos->isSMTP();                                      
				   $mailmenos->Host = "smtp.gmail.com";  
				   $mailmenos->SMTPAuth = true;                               
			       $mailmenos->Username = $gmail;                             
				   $mailmenos->Password = $passwdgmail;                          
				   $mailmenos->SMTPSecure = 'ssl';                            
				   $mailmenos->Port = 465;                                    
				   $mailmenos->isHTML(true);
				   $mailmenos->setFrom($gmail);	
				   $mailmenos->Subject = "Comienza la fase de propuestas de TFG por parte del profesorado";
				   $mailmenos->Body = "Por favor, realice sus propuestas de TFG en su p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n 
				   en la p&aacute;gina. El número de propuestas que debes realizar es: ".$numeroDeProp." y tiene de plazo hasta el ".$_POST["fecha"].".";				   
				   $mailmenos->addAddress($profesor["email"]);
				   if($gmail!=NULL || $gmail!=""){
				   if(!$mailmenos->Send()) echo "Mailer error" .$mailmenos->ErrorInfo;
				   }
				   }		   
				endforeach;				
           }else{
			$this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   }		   
		   }else{
		   $this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   }		   
		} else if($_POST["nuevoEstadoCurso"]=="3"){
		   $this->view->setVariable("estadocurso","2");
		   $fecha = $_POST["fecha"];
		   if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $fecha)){
		   $fechaAr = explode('/', $fecha);
		   if(checkdate($fechaAr[1],$fechaAr[0],$fechaAr[2])){
		   $this->coordinadorMapper->modificarEstadoCurso("3");
		   $this->view->setVariable("estadocurso","3"); 		   
           }else{
			$this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
			$this->view->render("coordinador", "indexCr");
		   }		   
		   }else{
		   $this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   $this->view->render("coordinador", "indexCr");
		   } 
		   $listaProfesores = $this->profesorMapper->listarProfesores("");
		   foreach($listaProfesores as $profesor):
		   $numeroDeProp = $this->profesorMapper->calcularNPropuestasAPresentar($profesor["dniProfesor"]);
		   $numProp = $this->propuestadetfgMapper->numeroDePropuestas($profesor["dniProfesor"]);
		   $actual = $numeroDeProp - $numProp;
		   $actual = round($actual);
		   if($actual>0){		   
		     for($i = $actual; $i>0; $i--){
			   $propuesta = new PropuestaDeTFG();
			   $propuesta->setTitulo($profesor["areaDeConocimiento"]);
			   $propuesta->setDescripcion("");
			   $propuesta->setTutor($profesor["dniProfesor"]);
               $this->propuestadetfgMapper->insertar($propuesta);			   
		     }
		   }
		   endforeach;
		   //Generar PDF de propuestas
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $fechaCurso = $this->coordinadorMapper->getFechaCurso();
		   list($fechap,$fechas) = preg_split('[/]',$fechaCurso["fechaCurso"]);
		   $filename="propuestas.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'PROPOSTAS DE TRABALLO FIN DE GRAO',0,1);			
			$pdf->SetFont('Arial','',15);
            $pdf->Cell(40,10,utf8_decode('CURSO ACADÉMICO 20'.$fechap.'-20'.$fechas),0,1);
			$pdf->Ln(8);
			$listapropuestas = $this->propuestadetfgMapper->listarPropuestasPorDepartamento("Dereito Privado");
			if (!empty($listapropuestas)) {
			    $pdf->SetFont('Arial','B',13); 
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: DEREITO PRIVADO'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
			    $pdf->Cell(0,10,utf8_decode('DEPARTAMENTO: INFORMÁTICA'),0,1);
				$pdf->SetFont('Arial','',12);
			foreach($listapropuestas as $propuesta):
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$propuesta["titulo"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$propuesta[0]),1,1);
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
				if($propuesta[1]=="NULL" || $propuesta[1]==NULL){
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
		   $mail->Body = "Podr&aacute;s comprobar la lista de propuestas en la p&aacute;gina de inicio. Por favor, env&iacute;a tu solicitud en tu p&aacute;gina principal, una vez hayas iniciado sesi&oacute;n en la p&aacute;gina. 
           tienes como fecha límite hasta el".$_POST["fecha"].".";			   
		   $listaAlumnos = $this->alumnoMapper->ordenarPorNota();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			if($gmail!=NULL || $gmail!=""){
				   if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
		    }							
		} else if($_POST["nuevoEstadoCurso"]=="4"){
		   $this->view->setVariable("estadocurso","3");
		   $fecha = $_POST["fecha"];
		   if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $fecha)){
		   $fechaAr = explode('/', $fecha);
		   if(checkdate($fechaAr[1],$fechaAr[0],$fechaAr[2])){
		   $this->coordinadorMapper->modificarEstadoCurso("4");
		   $this->view->setVariable("estadocurso","4"); 		   
           }else{
			$this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
			$this->view->render("coordinador", "indexCr");
		   }		   
		   }else{
		   $this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   $this->view->render("coordinador", "indexCr");
		   } 
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
					$fechaCurso = $this->coordinadorMapper->getFechaCurso();
					$tfgprop = new TFG();
					$tfgprop->setIdTFG($this->tfgMapper->generarCodigo($fechaCurso["fechaCurso"]));
					$tfgprop->setTituloEs($propuestaSeleccionada["titulo"]);
					$tfgprop->setTituloEn("solicitado");
					$tfgprop->setTituloGa($propuestaSeleccionada["titulo"]);
					$tfgprop->setEmpresa(0);
					$tfgprop->setTutor($propuestaSeleccionada["Profesor_dniProfesor"]);
					$tfgprop->setAlumno($alumnoActual);
					$tfgprop->setCotutor($propuestaSeleccionada["Profesor_dniProfesorCotutor"]);
					$this->tfgMapper->insertar($tfgprop);  
                    $this->profesorMapper->actualizarNumeroDeTFGs(0,$propuestaSeleccionada["Profesor_dniProfesor"]);
				    $this->profesorMapper->actualizarNumeroDeTFGs(1,$propuestaSeleccionada["Profesor_dniProfesorCotutor"]);						
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
                    $fechaCurso = $this->coordinadorMapper->getFechaCurso();					
                    $tfgsort = new TFG();
					$tfgsort->setIdTFG($this->tfgMapper->generarCodigo($fechaCurso["fechaCurso"]));
					$tfgsort->setTituloEs($listaprop["titulo"]);
					$tfgsort->setTituloEn("solicitado");
					$tfgsort->setTituloGa($listaprop["titulo"]);
					$tfgsort->setEmpresa(0);
					$tfgsort->setTutor($listaprop["Profesor_dniProfesor"]);
					$tfgsort->setAlumno($alum);
					$tfgsort->setCotutor($listaprop["Profesor_dniProfesorCotutor"]);
					$this->tfgMapper->insertar($tfgsort);
					$this->profesorMapper->actualizarNumeroDeTFGs(0,$listaprop["Profesor_dniProfesor"]);
				    $this->profesorMapper->actualizarNumeroDeTFGs(1,$listaprop["Profesor_dniProfesorCotutor"]);
                    $propid = new PropuestaDeTFG();
					$propid->setIdPk($listaprop["idPropuestasDeTFG"]);
					$this->propuestadetfgMapper->eliminar($propid);	
					}		
                endforeach;	
				}			
				//Generar PDF de asignaciones provisionales
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $fechaCurso = $this->coordinadorMapper->getFechaCurso();
		   list($fechap,$fechas) = preg_split('[/]',$fechaCurso["fechaCurso"]);
		   $filename="asignacionesP.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,utf8_decode('Asignación provisional de Traballo de Fin de Grao 20'.$fechap.'-20'.$fechas),0,1);			
			$pdf->Ln(8);
			$tfgsasignados = $this->tfgMapper->listarTFGs("si");
			if (!empty($tfgsasignados)) {
				$pdf->SetFont('Arial','',12);
			foreach($tfgsasignados as $solicitud):	
                $pdf->Cell(0,10,utf8_decode('Alumno/a: '.$solicitud[2]),1,1);			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$solicitud["tituloEs"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$solicitud[0]),1,1);
				if($solicitud[1]=="NULL" || $solicitud[1]==NULL){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$solicitud[1]),1,1);
				}						
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
            $pdf->Output('F',$filename);				
				$mail->Subject = "Comienza la etapa de asignaciones provisionales";
		        $mail->Body = "Podras realizar la comprobaci&oacute;n de asignaciones de TFG provisional en la lista presente en la p&aacute;gina de inicio de la web.";			   
				$listaAlumnos = $this->alumnoMapper->ordenarPorNota();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			if($gmail!=NULL || $gmail!=""){
				 if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
		    }
        } else if($_POST["nuevoEstadoCurso"]=="5"){
		   $this->view->setVariable("estadocurso","4");
		   $fecha = $_POST["fecha"];
		   if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $fecha)){
		   $fechaAr = explode('/', $fecha);
		   if(checkdate($fechaAr[1],$fechaAr[0],$fechaAr[2])){
           $this->coordinadorMapper->modificarEstadoCurso("5");
		   $this->view->setVariable("estadocurso","5");		   
           }else{
			$this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
			$this->view->render("coordinador", "indexCr");
		   }		   
		   }else{
		   $this->view->setFlash("El valor de la fecha l&iacute;mite introducido es incorrecto");
		   $this->view->render("coordinador", "indexCr");
		   }
           //Generar PDF de asignaciones definitivas
		   $fechaCurso = $this->coordinadorMapper->getFechaCurso();
		   list($fechap,$fechas) = preg_split('[/]',$fechaCurso["fechaCurso"]);
		   require_once(__DIR__."/../fpdf/fpdf.php");
		   require_once(__DIR__."/../fpdf/header.php");
		   $filename="asignacionesD.pdf";
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,utf8_decode('Asignación definitiva de Traballo de Fin de Grao 20'.$fechap.'-20'.$fechas),0,1);			
			$pdf->Ln(8);
			$tfgsasignados = $this->tfgMapper->listarTFGs("si");
			if (!empty($tfgsasignados)) {
				$pdf->SetFont('Arial','',12);
			foreach($tfgsasignados as $solicitud):	
                $pdf->Cell(0,10,utf8_decode('Alumno/a: '.$solicitud[2]),1,1);			
				$pdf->Cell(0,10,utf8_decode('Título do TFG: '.$solicitud["tituloEs"]),1,1);
				$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$solicitud[0]),1,1);
				if($solicitud[1]=="NULL" || $solicitud[1]==NULL){
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
				}else{
				$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$solicitud[1]),1,1);
				}		
				$pdf->Cell(0,10,'',0,1);
			endforeach;
			}
            $pdf->Output('F',$filename);				
				$mail->Subject = "Comienza la etapa de asignaciones definitivas";
		        $mail->Body = "Podr&aacte;s confirmar que estas cursando el TFG que te ha sido asignado rellenando el formulario que se encuentra en la web en tu p&aacutegina de inicio a partir de ".$_POST["fecha"].". Recuerda realizar esta solicitud dos meses antes del plazo de presentaci&oacute;n";			   
				$listaAlumnos = $this->alumnoMapper->listarAlumnos();
                foreach($listaAlumnos as $alumno):
			        $mail->addAddress($alumno["email"]);						
			    endforeach; 			
			if($gmail!=NULL || $gmail!=""){
				 if(!$mail->Send()) echo "Mailer error" .$mail->ErrorInfo;
		    }		   
		} else if($_POST["nuevoEstadoCurso"]=="6"){
		   //limpiar base de datos, nuevo curso
           $this->coordinadorMapper->modificarEstadoCurso("0");
		   $this->view->setVariable("estadocurso","0");
           $this->tfgMapper->deleteIt();
           $this->propuestadetfgMapper->deleteIt();
		   $this->alumnoMapper->deleteIt();
           $this->profesorMapper->deleteIt();
		}		
		$this->view->render("coordinador", "indexCr");
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
                    $this->view->setFlash("Las contrase&ntilde;as no coinciden");
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
                        $this->view->setFlash("Datos incorrectos");
						
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
  
  public function gestionarAlumnoC() {
     if(isset($this->currentUser)) {
                    $alumno = new Alumno();
					$alumno->setDniA(($_POST["dniAlumno"]));
					if(isset($_POST["eliminar"])){
					   $this->alumnoMapper->eliminar($alumno);
                       $this->view->redirect("coordinador", "gestionUsuarios");					   
					} 
					   $alumno->setEmailA($_POST["email"]);
					   $alumno->setNombre($_POST["nombre"]);
					   $num = floatval($_POST["notaMedia"]);
					   $alumno->setNotaMedia($num);
					   $alumno->setTelefono($_POST["telefono"]);
					   $alumno->setDireccion($_POST["direccion"]);
					   $alumno->setLocalidad($_POST["localidad"]);
					   $alumno->setProvincia($_POST["provincia"]);
					   $alumno->setPasswordA($_POST["contrasenhaAl"]);					   
					   if(isset($_POST["modificar"])){					   
						try {
							$alumno->validoParaGestionar();
							$this->alumnoMapper->modificarc($alumno);
							$this->view->redirect("coordinador", "gestionUsuarios");
						} catch (ValidationException $ex) {
							$errors = $ex->getErrors();
							$this->view->setVariable("errors", $errors);
							$this->view->setFlash("Datos incorrectos");				
						}
					   $this->view->redirect("coordinador", "gestionUsuarios");
					   }
					   if(isset($_POST["insertar"])){
					    try {
							$alumno->validoParaGestionar();
							$this->alumnoMapper->insertar($alumno);
							$this->view->redirect("coordinador", "gestionUsuarios");
						} catch (ValidationException $ex) {
							$errors = $ex->getErrors();
							$this->view->setVariable("errors", $errors);
							$this->view->setFlash("Datos incorrectos");				
						}                      
                       }					    
               $this->view->redirect("coordinador", "gestionUsuarios");           
	}else{
		echo "Upss! no deberías estar aquí";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	
  }
  
    public function gestionarProfesorC() {
     if(isset($this->currentUser)) {
                    $profesor = new Profesor();
					$profesor->setDniP(($_POST["dniProfesor"]));
					if(isset($_POST["eliminar"])){
					   $this->profesorMapper->eliminar($profesor);
                       $this->view->redirect("coordinador", "gestionUsuarios");					   
					}
					   $profesor->setEmailP($_POST["email"]);
					   $profesor->setNombre($_POST["nombre"]);
					   $profesor->setAreaDeConocimiento($_POST["areaDeConocimiento"]);
					   $profesor->setDepartamento($_POST["departamento"]);
					   $profesor->setPasswordP($_POST["contrasenhaPr"]);					   
					   if(isset($_POST["modificar"])){
					   	try {
							$profesor->validoParaGestionar();
							$this->profesorMapper->modificarC($profesor);
							$this->view->redirect("coordinador", "gestionUsuarios");
						} catch (ValidationException $ex) {
							$errors = $ex->getErrors();
							$this->view->setVariable("errors", $errors);
							$this->view->setFlash("Datos incorrectos");				
						}					   
					   }
					   if(isset($_POST["insertar"])){
					    try {
							$profesor->validoParaGestionar();
							$this->profesorMapper->insertar($profesor);
							$this->view->redirect("coordinador", "gestionUsuarios");
						} catch (ValidationException $ex) {
							$errors = $ex->getErrors();
							$this->view->setVariable("errors", $errors);
							$this->view->setFlash("Datos incorrectos");				
						}                      
                       }					    
               $this->view->redirect("coordinador", "gestionUsuarios");           
	}else{
		echo "Upss! no deberías estar aquí";
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
				$this->view->setFlash("Las contrase&ntilde;as no coinciden");
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
					$this->view->setFlash("Datos incorrectos");				
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
  
  public function modificarCoordinador(){
	if(isset($this->currentUser)) {
		if (isset($_POST["password"]) && isset($_POST["sndpassword"])) {
			$pass = $_POST["password"];
			$pass2 = $_POST["sndpassword"];
			if ($pass != $pass2) {
				$errors = array();
				$errors["contrasenhaDistintasPro"] = "Las contrase&ntilde;as no coinciden";
				$this->view->setVariable("errors", $errors);
				$this->view->setFlash("Las contrase&ntilde;as no coinciden");
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
					$this->view->setFlash("Datos incorrectos");
					
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
                        $this->view->redirect("profesor", "gestionPropuestas");
                    } catch (ValidationException $ex) {
                        $errors = $ex->getErrors();
                        $this->view->setVariable("errors", $errors);
                        $this->view->setFlash("Debes introducir un t&iacute;tulo, junto con una descripci&oacute;n");						
                    }               
               $this->view->redirect("profesor", "gestionPropuestas");           
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
            $this->view->redirect("alumno", "SolicitudTFG"); 			
	    } else if($_POST["firstopt"]==$_POST["secondopt"] || $_POST["firstopt"]==$_POST["thirdopt"] || $_POST["firstopt"]==$_POST["fourthopt"] || $_POST["firstopt"]==$_POST["fifthopt"] || $_POST["secondopt"]==$_POST["thirdopt"]
		 || $_POST["secondopt"]==$_POST["fourthopt"] || $_POST["secondopt"]==$_POST["fifthopt"] || $_POST["thirdopt"]==$_POST["fourthopt"] || $_POST["thirdopt"]==$_POST["fifthopt"] || $_POST["fourthopt"]==$_POST["fifthopt"] ){
		    $this->view->setFlash("Solicitud incorrecta, no puedes seleccionar dos veces el mismo TFG");  
            $this->view->redirect("alumno", "SolicitudTFG");      		
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
                $fechaCurso = $this->coordinadorMapper->getFechaCurso();		
				$TFG = new TFG();
				$TFG->setIdTFG($this->tfgMapper->generarCodigo($fechaCurso["fechaCurso"]));
				$TFG->setTituloEs($_POST["titulo"]);
				$TFG->setTituloEn("mutuo");
				$TFG->setTituloGa($_POST["titulo"]);
				$TFG->setEmpresa($_POST["empresa"]);
				$dniPr = $this->profesorMapper->getId($this->currentUser->getEmailP());
				$TFG->setTutor($dniPr["dniProfesor"]);				
				$TFG->setAlumno($_POST["alumno"]);
				$TFG->setCotutor($_POST["cotutor"]);
				$this->tfgMapper->insertar($TFG); 
				echo $_POST["cotutor"];
				$this->profesorMapper->actualizarNumeroDeTFGs(0,$dniPr["dniProfesor"]);
				$this->profesorMapper->actualizarNumeroDeTFGs(1,$_POST["cotutor"]);				
		        $this->view->redirect("profesor", "gestionSolicitudes"); 
			}
		  $this->view->redirect("profesor", "gestionSolicitudes"); 	
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
				       $this->profesorMapper->actualizarNumeroDeTFGs(3,$_POST["tutor"]);
					   $this->profesorMapper->actualizarNumeroDeTFGs(2,$_POST["cotutor"]);	
					   $this->tfgMapper->eliminar($tfg);
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
  
  public function confirmarAsig() {
    if(isset($this->currentUser)) {
		$tfg = new TFG();
		$tfg->setIdTFG($_POST["idTFG"]);
		$tfg->setTituloEn($_POST["tituloEn"]);
		$tfg->setTituloEs($_POST["tituloEs"]);
		$tfg->setTituloGa($_POST["tituloGa"]);
		$tfg->setEmpresa($_POST["empresa"]);
		$tfg->setDescripcion($_POST["descripcion"]);
		$this->tfgMapper->asignacionOficial($tfg);
		$tfgactual = $this->tfgMapper->getTFG($_POST["dni"]);
		$aluactual = $this->alumnoMapper->getAlumno($_POST["dni"]);
		$profactual = $this->profesorMapper->getProfesor($tfgactual["Profesor_dniProfesor"]);
		$coprofactual = $this->profesorMapper->getProfesor($tfgactual["Profesor_dniProfesorCotutor"]);
		//Generar pdf a entregar 
		require_once(__DIR__."/../fpdf/fpdf.php");
		require_once(__DIR__."/../fpdf/header.php");
		list($valun,$valdos) = preg_split('[/]',$_POST["idTFG"]);
	    $filename="asignacionOficial".$valun."_".$valdos.".pdf";
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
	    $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,utf8_decode('Solicitud de asignación oficial'),0,1);			
	    $pdf->Ln(8);
		$pdf->SetFont('Arial','',15);
        $pdf->Cell(40,10,utf8_decode('Datos del alumno:'),0,1);		
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(0,10,utf8_decode('Alumno/a: '.$aluactual["nombre"]),1,1);
            $pdf->Cell(0,10,utf8_decode('DNI: '.$aluactual["dniAlumno"]),1,1);	
            $pdf->Cell(0,10,utf8_decode('Dirección: '.$aluactual["direccion"]),1,1);
            $pdf->Cell(0,10,utf8_decode('Localidad: '.$aluactual["localidad"]),1,1);
            $pdf->Cell(0,10,utf8_decode('Provincia: '.$aluactual["provincia"]),1,1);
            $pdf->Cell(0,10,utf8_decode('Telefono: '.$aluactual["telefono"]),1,1);
            $pdf->Cell(0,10,utf8_decode('Email: '.$aluactual["email"]),1,1);
	    $pdf->Ln(8);
		$pdf->SetFont('Arial','',15);
        $pdf->Cell(40,10,utf8_decode('Datos del trabajo de fin de grado:'),0,1);		
            $pdf->SetFont('Arial','',12); 		
			$pdf->Cell(0,10,utf8_decode('Título do TFG en español: '.$tfgactual["tituloEs"]),1,1);
			$pdf->Cell(0,10,utf8_decode('Título do TFG en galego: '.$tfgactual["tituloGa"]),1,1);
			$pdf->Cell(0,10,utf8_decode('Título do TFG en ingés: '.$tfgactual["tituloEn"]),1,1);
			$pdf->Cell(0,10,utf8_decode('Titor/a do TFG: '.$profactual["nombre"]),1,1);
			if($tfgactual["Profesor_dniProfesorCotutor"]=="NULL" || $tfgactual["Profesor_dniProfesorCotutor"]==NULL){
			$pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '),1,1);
		    }else{
		    $pdf->Cell(0,10,utf8_decode('Cotitor/a do TFG (se procede): '.$coprofactual["nombre"]),1,1);
		    }
			$pdf->Cell(0,10,utf8_decode('Area de coñecemento: '.$profactual["areaDeConocimiento"]),1,1);
			$pdf->Cell(0,10,utf8_decode('Departamento: '.$profactual["departamento"]),1,1);
			if($tfgactual["empresa"]==1){
			$pdf->Cell(0,10,utf8_decode('Realizado en empresa: Sí'),1,1);
			}else{
			$pdf->Cell(0,10,utf8_decode('Realizado en empresa: No'),1,1);
			}
			$pdf->Cell(0,10,utf8_decode('Descripción do proyecto: '.$tfgactual["descripcion"]),1,1);			
			$pdf->Output('F',$filename);
			$this->view->redirect("alumno", "index");           
	}else{
		echo "Upss! no deberías estar aquí";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	} 
  }
  
  public function cambiarAsignacionTFG() {
	if(isset($this->currentUser)) {
	  if($_POST["alumno"]=="vacio2" || $_POST["propuesta"]=="vacio2"){
	    $this->view->setFlash("Solicitud incorrecta, se debe seleccionar un alumno y una propuesta."); 
        $this->view->redirect("coordinador", "gestionTFGs");		
	  }else{
		$tfginfo = $this->tfgMapper->getTFG($_POST["alumno"]);	
		$tfg = new TFG();
		$tfg->setIdTFG($tfginfo["idTFG"]);
		$this->tfgMapper->eliminar($tfg);
		$this->profesorMapper->actualizarNumeroDeTFGs(3,$tfginfo["Profesor_dniProfesor"]);
		$this->profesorMapper->actualizarNumeroDeTFGs(2,$tfginfo["Profesor_dniProfesorCotutor"]);
		$propuesta = new PropuestaDeTFG();
		$propuesta->setTitulo($tfginfo["tituloEs"]);
		$propuesta->setDescripcion("");
		$propuesta->setTutor($tfginfo["Profesor_dniProfesor"]);
		if($tfginfo["Profesor_dniProfesorCotutor"]!= NULL){
		$propuesta->setCotutor($tfginfo["Profesor_dniProfesorCotutor"]);
		}
		$this->propuestadetfgMapper->insertar($propuesta);
        $propuestaSeleccionada = $this->propuestadetfgMapper->getPropuesta($_POST["propuesta"]);
		$tfgprop = new TFG();
		$tfgprop->setIdTFG($tfginfo["idTFG"]);
		$tfgprop->setTituloEs($propuestaSeleccionada["titulo"]);
		$tfgprop->setTituloEn("solicitado");
		$tfgprop->setTituloGa($propuestaSeleccionada["titulo"]);
		$tfgprop->setEmpresa(0);
		$tfgprop->setTutor($propuestaSeleccionada["Profesor_dniProfesor"]);
		$tfgprop->setAlumno($_POST["alumno"]);
		$tfgprop->setCotutor($propuestaSeleccionada["Profesor_dniProfesorCotutor"]);
		$this->tfgMapper->insertar($tfgprop);  
		$this->profesorMapper->actualizarNumeroDeTFGs(0,$propuestaSeleccionada["Profesor_dniProfesor"]);
		$this->profesorMapper->actualizarNumeroDeTFGs(1,$propuestaSeleccionada["Profesor_dniProfesorCotutor"]);
        $propElim = new PropuestaDeTFG();
		$propElim->setIdPk($_POST["propuesta"]);
        $this->propuestadetfgMapper->eliminar($propElim);		
	    $this->view->redirect("coordinador", "gestionTFGs");
        }		
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
		   $this->profesorMapper->actualizarNumeroDeTFGs(0,$_POST["tutor"]);
		   $this->profesorMapper->actualizarNumeroDeTFGs(1,$_POST["cotutor"]);
		   $this->profesorMapper->actualizarNumeroDeTFGs(2,$_POST["cotutorant"]);
		   $this->profesorMapper->actualizarNumeroDeTFGs(3,$_POST["tutorant"]);
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
