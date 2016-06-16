<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $estadocurso = $view->getVariable("estadocurso");
 $listaProfesores = $view->getVariable("listaProfesores");
 ?>  

    <!-- Page Content -->
    </div>
	<div class="container">
	    <div class="row">
	    <br>
	    <h3>Realizar solicitud de acuerdo mutuo:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=mutuoAcuerdo" >
				<div class="mycenter red">
		           <?php echo $view->popFlash();?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="titulo">T&iacute;tulo del TFG</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="titulo" placeholder="Introduce t&iacute;tulo"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="empresa">¿Realizado en empresa?:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="empresa">
					<option value="0">No</option>
					<option value="1">S&iacute;</option>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="tutor">Seleccione tutor:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="tutor">
					<option value="sin">Confirme tutor</option>
					<?php foreach($listaProfesores as $profesor):
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="cotutor">Seleccione cotutor:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="cotutor">
					<option value="NULL">Sin cotutor</option>
					<?php foreach($listaProfesores as $profesor):
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
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
	</div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>