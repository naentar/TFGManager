<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../controller/BaseController.php");


class PropuestaDeTFGController extends BaseController {
  
  private $propuestadetfgMapper;  
  
  public function __construct() {    
    parent::__construct();
    
	$this->propuestadetfgMapper = new PropuestaDeTFGMapper();
 
  }
  
  
	
  	
  
}
