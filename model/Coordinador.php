<?php
require_once(__DIR__."/../core/ValidationException.php");

class Coordinador {

  private $email;
  private $password;
  private $estadoCurso;
  
  public function __construct($email=NULL, $password=NULL,$estadoCurso=NULL) {
    $this->email = $email;
    $this->password = $password; 
    $this->estadoCurso = $estadoCurso;	
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
  
  
}