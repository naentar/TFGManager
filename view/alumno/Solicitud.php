<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $listarPropuestasTitulo = $view->getVariable("listarPropuestasTitulo");
 ?>  

    <!-- Page Content -->
    </div>
	<div class="container">
	    <br>
	    <h3>Realizar solicitud de TFG por orden de prioridad:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=realizarSolicitud" >
		        <div class="mycenter red">
		           <?php echo $view->popFlash();?>
	            </div>
				<br>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="firstopt">Primera opci&oacute;n:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="firstopt">
					<option value="vacio1">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="secondopt">Segunda opci&oacute;n:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="secondopt">
					<option value="vacio2">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="thirdopt">Tercera opci&oacute;n:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="thirdopt">
					<option value="vacio3">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="fourthopt">Cuarta opci&oacute;n:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="fourthopt">
					<option value="vacio4">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="fifthopt">Quinta opci&oacute;n:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="fifthopt">
					<option value="vacio5">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Solicitar" >
				  </div>
				</div>
			</form>
		</div>
        <!-- /.row -->	
	</div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>