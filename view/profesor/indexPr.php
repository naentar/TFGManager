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
    <div class="container">			
	<?php 
		if(strval($estadocurso)=="1"){ 
	?>
        <div class="row">
	    <br>
	    <h3>Realizar propuesta de TFG:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=realizarPropuesta" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="titulo">T&iacute;tulo:</label>
				  <div class="col-sm-4">
					<b><textarea class="form-control" rows="2" name="titulo" placeholder="Introduzca el t&iacute;tulo del TFG"></textarea></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="descripcion">Descripci&oacute;n</label>
				  <div class="col-sm-4">
					<b><textarea class="form-control" rows="5" name="descripcion" placeholder="Realice una descripci&oacute;n del TFG"></textarea></b>
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
						<input type="submit" class="btn btn-default" value="Presentar" >
				  </div>
				</div>
			</form>
		</div>
        <!-- /.row -->	
    <?php 
		}
	?>
        <hr>
        <div class="row">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=modifyPr">Modificar contraseña</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s modificar tu contraseña, adem&aacute;s de poder comprobar tu informaci&oacute;n almacenada en el sistema en referencia a tu cuenta.</p>
                
            </div>
        </div>
        <!-- /.row -->	
    </div>	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>