<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class User
 * 
 * Represents a User in the blog
 * 
 * @author lipido <lipido@gmail.com>
 */
class Coordinador {

  /**
   * The user name of the user
   * @var string
   */
  private $email;

  /**
   * The password of the user
   * @var string
   */
  private $password;
  
  /**
   * The constructor
   * 
   * @param string $username The name of the user
   * @param string $passwd The password of the user
   */
  public function __construct($username=NULL, $passwd=NULL) {
    $this->email = $email;
    $this->password = $password;    
  }

  /**
   * Gets the username of this user
   * 
   * @return string The username of this user
   */  
  public function getEmail() {
    return $this->email;
  }

  /**
   * Sets the username of this user
   * 
   * @param string $username The username of this user
   * @return void
   */  
  public function setEmail($email) {
    $this->email = $email;
  }
  
  /**
   * Gets the password of this user
   * 
   * @return string The password of this user
   */  
  public function getPassword() {
    return $this->password;
  }  
  /**
   * Sets the password of this user
   * 
   * @param string $passwd The password of this user
   * @return void
   */    
  public function setPassword($password) {
    $this->password = $password;
  }
}