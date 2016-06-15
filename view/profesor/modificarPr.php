<!DOCTYPE html>
<html lang="en">
<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$profesor = $view->getVariable("profesorInf");
$usuario = $view->getVariable("currentusername");
?>  


    <!-- Page Content -->
    <div class="container">

	    <h3>Informaci&oacute;n de usuario:</h3>
        <hr>

        <div class="row">

			<form class="form-horizontal" role="form" method="post" action="" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="dni">Dni:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="dni" value="<?php echo $profesor["dniProfesor"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="email">Email:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="email" value="<?php echo $profesor["email"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="nombre">Nombre:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="nombre" value="<?php echo $profesor["nombre"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="notaMedia">Area de conocimiento:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="areaDeConocimiento" value="<?php echo $profesor["areaDeConocimiento"];?>" disabled></b>
				  </div>
				</div>	
                <div class="form-group">
				  <label class="control-label col-sm-4" for="departamento">Departamento: </label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="departamento" value="<?php echo $profesor["departamento"];?>" disabled></b>
				  </div>
				</div>				
			</form>          
        </div>
        <!-- /.row -->

    </div>
	<div class="container">
	    <div class="row">
	    <br>
	    <h3>Modificar contraseña:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=modificarProfesor" >
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="password">Contraseña:</label>
				  <div class="col-sm-4">          
					<input type="password" class="form-control" name="password" placeholder="Introduce contraseña">
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="sndpassword">Repetir contraseña:</label>
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