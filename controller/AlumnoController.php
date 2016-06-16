<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class AlumnoController extends BaseController {
  
  private $alumnoMapper;
  private $coordinadorMapper; 
  private $profesorMapper;  
  private $propuestadetfgMapper;
  private $tfgMapper;
  private $solicituddetfgMapper;
  
  public function __construct() {    
    parent::__construct();
    
	$this->alumnoMapper = new AlumnoMapper();
	$this->coordinadorMapper = new CoordinadorMapper();
	$this->profesorMapper = new ProfesorMapper();
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
	$this->tfgMapper = new TFGMapper();
	$this->solicituddetfgMapper = new SolicitudDeTFGMapper();
 
  }
  public function index() {
        if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
            $estado = $this->coordinadorMapper->estadoCursoActual(); 
            $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
			if($estado["estadorCurso"]==2){
			$listaPropuestas = $this->propuestadetfgMapper->listarPropuestas();
            $this->view->setVariable("listarPropuestas", $listaPropuestas);
			$dniAl = $this->alumnoMapper->getId($this->currentUser->getEmailA());
			$infoTFG = $this->tfgMapper->comprobarId($dniAl["dniAlumno"]);
            $this->view->setVariable("existeTFG", $infoTFG);
			$infoSolicitud = $this->solicituddetfgMapper->comprobarId($dniAl["dniAlumno"]);
            $this->view->setVariable("existeSolicitud", $infoSolicitud);
			}
			$this->view->render("alumno", "indexAl");
        }else{
            echo "No est&aacute;s autorizado";
            echo "<br>Redireccionando...";
            header("Refresh: 5; index.php?controller=users&action=index");
        }	
  }
  
  public function alumnoTFG(){
	if (isset($this->currentUser) && $this->alumnoMapper->checkuser($this->username)) {
	   $listaProfesores = $this->profesorMapper->listarProfesores("");
	   $estado = $this->coordinadorMapper->estadoCursoActual(); 
       $this->view->setVariable("estadocurso",$estado["estadorCurso"]);
       $this->view->setVariable("listaProfesores", $listaProfesores);
	   $this->view->render("alumno", "AlTFG");
	}else{
		echo "No est&aacute;s autorizado";
		echo "<br>Redireccionando...";
		header("Refresh: 5; index.php?controller=users&action=index");
	}	 
  }			 	
  
}
