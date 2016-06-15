<?php

require_once(__DIR__."/../core/PDOConnection.php");

class PropuestaDeTFGMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function insertar(PropuestaDeTFG $Pr){
    $stmt = $this->db->prepare("INSERT INTO PropuestasDeTFG(`titulo`,`descripcion`, `Profesor_dniProfesor`, `Profesor_dniProfesorCotutor`) values (?,?,?,?)");
    $stmt->execute(array($Pr->getTitulo(), $Pr->getDescripcion(), $Pr->getTutor(), $Pr->getCotutor())); 
  }
   
}