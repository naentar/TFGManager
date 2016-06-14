<!DOCTYPE html>
<html lang="en">
<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$alumno = $view->getVariable("alumnoInf");
$usuario = $view->getVariable("currentusername");
?>  

    <header class="business-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="tagline">P&aacute;gina web para la gesti&oacute;n de TFG's</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">

	    <h3>Informaci&oacute;n no modificable:</h3>
        <hr>

        <div class="row">

			<form class="form-horizontal" role="form" method="post" action="" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="dni">Dni:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="dni" value="<?php echo $alumno["dniAlumno"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="email">Email:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="email" value="<?php echo $alumno["email"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="nombre">Nombre:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="nombre" value="<?php echo $alumno["nombre"];?>" disabled></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="notaMedia">Nota media:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="notaMedia" value="<?php echo $alumno["notaMedia"];?>" disabled></b>
				  </div>
				</div>				
			</form>          
        </div>
        <!-- /.row -->

    </div>
	<div class="container">
	    <div class="row">
	    <br>
	    <h3>Informaci&oacute;n modificable:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=modificarAlumno" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="telefono">Tel&eacute;fono:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="telefono" value="<?php echo $alumno["telefono"];?>"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="direccion">Direcci&oacute;n:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="direccion" value="<?php echo $alumno["direccion"];?>"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="localidad">Localidad:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="localidad" value="<?php echo $alumno["localidad"];?>"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="provincia">Provincia:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="provincia" value="<?php echo $alumno["provincia"];?>"></b>
				  </div>
				</div>
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
				 <!--<button id="btn-login" type="button" onclick="validateModUser('modificaruser')" class="contact submit" value="Modificar"><?= i18n("Modificar")?></button> -->
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