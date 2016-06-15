<!DOCTYPE html>
<html lang="en">
	<?php
	require_once(__DIR__ . "/../../core/ViewManager.php");
	$view = ViewManager::getInstance();
	$usuario = $view->getVariable("currentusername");
	$estadocurso = $view->getVariable("estadocurso");
	?>  



    <!-- Page Content -->
   <div class="container">

        <div class="row">
	    <br>
	    <h3>Gestionar estado del curso:</h3>
        <hr>		
		<form class="form-horizontal" role="form" method="post" action="" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="estado">Estado actual:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="estado" value="<?php 
					if(strval($estadocurso)=="0") echo '1.Inicio de curso';
					if(strval($estadocurso)=="1") echo '2.Propuestas de Profesores';
					if(strval($estadocurso)=="2") echo '3.Solicitudes de Alumnos';
					if(strval($estadocurso)=="3") echo '4.Cursando TFG';								
					?>" disabled></b>
				  </div>
				</div>				
			</form>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=actualizarEstadoCurso" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="nuevoEstadoCurso">Modificar estado a:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="nuevoEstadoCurso">
				  <?php if(strval($estadocurso)=="0") { echo'
					<option value="0" disabled>1.Inicio de curso</option>
					<option value="1">2.Propuestas de Profesores</option>
					<option value="2" disabled>3.Solicitudes de Alumnos</option>
					<option value="3" disabled>4.Cursando TFG</option>';
					} else if(strval($estadocurso)=="1") { echo'
					<option value="0" disabled>1.Inicio de curso</option>
					<option value="1" disabled>2.Propuestas de Profesores</option>
					<option value="2" >3.Solicitudes de Alumnos</option>
					<option value="3" disabled>4.Cursando TFG</option>';
					} else if(strval($estadocurso)=="2") { echo'
					<option value="0" disabled>1.Inicio de curso</option>
					<option value="1" disabled>2.Propuestas de Profesores</option>
					<option value="2" disabled>3.Solicitudes de Alumnos</option>
					<option value="3" >4.Cursando TFG</option>';
					} else if(strval($estadocurso)=="3") { echo'
					<option value="0" >1.Inicio de curso</option>
					<option value="1" disabled>2.Propuestas de Profesores</option>
					<option value="2" disabled>3.Solicitudes de Alumnos</option>
					<option value="3" disabled>4.Cursando TFG</option>';
					}
					?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Modificar Estado" >
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