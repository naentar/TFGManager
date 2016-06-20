<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $estadocurso = $view->getVariable("estadocurso");
 $listarPropuestasTitulo = $view->getVariable("listarPropuestasTitulo");
 $existeTFG = $view->getVariable("existeTFG");
 $existeSolicitud = $view->getVariable("existeSolicitud");
 $TFGacep = $view->getVariable("TFGacep");
 ?>  

    <!-- Page Content -->
    <div class="container">   
    <?php 
		if($estadocurso=="2"){
            if($existeTFG=="no" && $existeSolicitud=="no"){		
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
        <div class="row"> 
		<hr>		
	    <div class="col-sm-8">
			    <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=alumno&action=alumnoTFG">Solicitar TFG de mutuo acuerdo</a>
                </p> 
                <p>En caso de querer realizar una solicitud de TFG preacordado con un profesor en lugar de realizar una solicitud sobre la lista de propuestas del profesorado, por favor pulse aqu&iacute;.</p>                
            </div>
	    </div>	
        <!-- /.row -->		 
    <?php 
			}else{
	?>
        <div class="row">
            <div class="col-sm-8">
			    <h2>Solicitud almacenada</h2>
                <p>Ya has realizado tu solicitud de TFG, por favor espera hasta el final del per&iacute;odo de asignaci&oacute;n para comprobar que TFG te ha sido asignado.</p>               
            </div>  
        </div> 

	<?php
			}
		}	
		if($estadocurso=="3"){
		   if($TFGacep["tituloEn"]=="aceptado" || $TFGacep["tituloEn"]=="solicitado"){
	?>	
		    <div class="row"> 
				<hr>		
				<div class="col-sm-8">
						<p>
							<a class="btn btn-default btn-lg" href="index.php?controller=alumno&action=confirmarAnteproyeco">Confirmar anteproyecto</a>
						</p> 
						<p>En caso de querer realizar una entrega de anteproyecto, rellene el formulario que se encuentra en este bot&oacute;n.</p>                
				</div>
			</div>	
        <!-- /.row -->
	<?php
            }else {
	?>
			<div class="row"> 
				<hr>		
				<div class="col-sm-8">
					<h2>Solicitud almacenada</h2>
					<p>Tu solicitud de anteproyecto ya ha sido almacenada, ya puedes comenzar con la realizaci&oacute;n de tu TFG.</p>                
				</div>
			</div>
	<?php 	
			}
		}
	?>
     <hr>
        <div class="row">
			    <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=modifyAl">Modificar informaci&oacute;n personal</a>
                </p> 
                <p>En esta opci&oacute;n podrás comprobar tu informaci&oacute;n personal adem&aacute;s de realizar modificaciones sobre la misma y poder modificar la contraseña.</p>			
        </div>
        <!-- /.row -->	

	 
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>