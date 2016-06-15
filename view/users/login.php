<?php 
 //file: view/users/login.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
?>

<div class="container">
	<hr>
		
  <form class="form-horizontal" role="form" method="post" action="index.php?controller=users&amp;action=login" >
    <div class="form-group">
      <label class="control-label col-sm-4" for="email">Email:</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" name="email" placeholder="Introduce email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4 " for="pwd">Contraseña:</label>
      <div class="col-sm-4">          
        <input type="password" class="form-control" name="password" placeholder="Introduce contraseña">
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-4 col-sm-10">
			<input type="submit" class="btn btn-default" value="Iniciar sesi&oacute;n" >
      </div>
    </div>
  </form>
  

	
</div>
 
		
		
		