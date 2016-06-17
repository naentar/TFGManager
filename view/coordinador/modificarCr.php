<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $infoCoordinador = $view->getVariable("coordinadorInf");
 ?>  


    <!-- Page Content -->
	<div class="container">
	    <div class="row">
	    <br>
	    <h3>Modificar informaci&oacute;n de la cuenta:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=modificarCoordinador" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="gmail">Gmail para correos:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="gmail" value="<?php echo $infoCoordinador["gmailCorreos"];?>" ></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="passwordg">Contraseña de Gmail:</label>
				  <div class="col-sm-4">          
					<input type="password" class="form-control" name="passwordg" value="<?php echo $infoCoordinador["contrasenhaCorreos"];?>">
				  </div>
				</div>				
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="password">Contraseña de la p&aacute;gina:</label>
				  <div class="col-sm-4">          
					<input type="password" class="form-control" name="password" placeholder="Introduce contraseña">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="sndpassword">Repetir contraseña de la p&aacute;gina:</label>
				  <div class="col-sm-4">          
					<input type="password" class="form-control" name="sndpassword" placeholder="Introduce contraseña otra vez">
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Modificar" >
				  </div>
				</div>
			</form>
		</div>	
	</div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>