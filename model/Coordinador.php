<?php
require_once(__DIR__."/../core/ValidationException.php");

class Coordinador {

  private $email;
  private $password;
  private $estadoCurso;
  private $gmail;
  private $passwordGmail;
  
  public function __construct($email=NULL, $password=NULL,$estadoCurso=NULL,$gmail=NULL,$passwordGmail=NULL) {
    $this->email = $email;
    $this->password = $password; 
    $this->estadoCurso = $estadoCurso;
    $this->gmail = $gmail;
    $this->passwordGmail = $passwordGmail;	
  }


  public function getEmailC() {
    return $this->email;
  }
  
  public function setEmailC($email) {
    $this->email = $email;
  }  
 
  public function getPasswordC() {
    return $this->password;
  }  
   
  public function setPasswordC($password) {
    $this->password = $password;
  }
  
  public function getEstadoCurso() {
    return $this->estadoCurso;
  }  
   
  public function setEstadoCurso($estadoCurso) {
    $this->estadoCurso = $estadoCurso;
  }
  
  public function getGmail() {
    return $this->gmail;
  }
  
  public function setGmail($gmail) {
    $this->gmail = $gmail;
  }
  
  public function getPasswordGmail() {
    return $this->passwordGmail;
  }  
   
  public function setPasswordGmail($passwordGmail) {
    $this->passwordGmail = $passwordGmail;
  }
  
  public function fechaCursoValida($fecha) {  
  list($fechauno,$fechados) = preg_split('[/]',$fecha);
  $fechauno++;
  if($fechauno==$fechados){return true;
  }else{return false;
  }
  }
  
}