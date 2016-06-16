<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $estadocurso = $view->getVariable("estadocurso");
 $listaPropuestas = $view->getVariable("listarPropuestas");
 ?>  

    <!-- Page Content -->
    <div class="container">

        <hr>

        <div class="row">
            <div class="col-sm-8">
			    <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=modifyAl">Modificar informaci&oacute;n personal</a>
                </p> 
                <p>En esta opci&oacute;n podrás comprobar tu informaci&oacute;n personal adem&aacute;s de realizar modificaciones sobre la misma y poder modificar la contraseña.</p>
                
            </div>
            <div class="col-sm-4">
                <h2>Informaci&oacute;n del centro</h2>
                <address>
                    <strong>Escuela Superior de Ingenier&iacute;a Inform&aacute;tica</strong>
                    <br>Campus de Ourense - Edificio Polit&eacute;cnico
                    <br>32004 OURENSE
                    <br>
                </address>
                <address>
                    <abbr title="Phone">Tel:</abbr> +34 988 387 000
                    <br>
                    <abbr title="Email">Email:</abbr> <a href="mailto:#"> coordinadortfg@esei.uvigo.com</a>
                </address>
            </div>
        </div>
        <!-- /.row -->
    
    <?php 
		if(strval($estadocurso)=="2"){ 
	?>
        <div class="row">
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
					<?php foreach($listaPropuestas as $propuesta):
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
					<?php foreach($listaPropuestas as $propuesta):
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
					<?php foreach($listaPropuestas as $propuesta):
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
					<?php foreach($listaPropuestas as $propuesta):
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
					<?php foreach($listaPropuestas as $propuesta):
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
    <?php 
		}
	?>	

	 
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>