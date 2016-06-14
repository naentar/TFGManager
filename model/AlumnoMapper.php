<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

class AlumnoMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
     
  public function save($user) {
    $stmt = $this->db->prepare("INSERT INTO users values (?,?)");
    $stmt->execute(array($user->getUsername(), $user->getPasswd()));
  }
  
  public function usernameExists($username) {
    $stmt = $this->db->prepare("SELECT count(username) FROM users where username=?");
    $stmt->execute(array($username));
    
    if ($stmt->fetchColumn() > 0) {   
      return true;
    } 
  }
  
   public function checkUser($email)
    {
        $stmt = $this->db->prepare("SELECT count(email) FROM alumno where email=?");
        $stmt->execute(array($email));
        if ($stmt->fetchColumn() > 0) {
            return true;
        }

    }
  
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT count(email) FROM alumno where email=? and contrasenhaAl=?");
    $stmt->execute(array($email, $password));
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}