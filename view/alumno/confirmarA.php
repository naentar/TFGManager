<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $TFG = $view->getVariable("TFG");
 ?>  

    <!-- Page Content -->
    </div>
	<div class="container">
	    <div class="row">
	    <br>
	    <h3>Entrega de anteproyecto:</h3>
		<p>Con el objetivo de formalizar este tr&aacute;mite se requiere asignar el t&iacute;tulo del TFG en los tres idiomas correspondientes:</p>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=confirmarAnte" >
				<div class="mycenter red">
		           <?php echo $view->popFlash();?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="tituloEs">T&iacute;tulo del TFG en castellano:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="tituloEs" value="<?php echo $TFG["tituloEs"];?>"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="tituloEn">T&iacute;tulo del TFG en ingl&eacute;s:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="tituloEn" placeholder="Introduce t&iacute;tulo"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="tituloGa">T&iacute;tulo del TFG en gallego:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="tituloGa" placeholder="Introduce t&iacute;tulo"></b>
				  </div>
				</div>
				<input type="hidden" class="form-control" name="idTFG" value="<?php echo $TFG["idTFG"];?>">
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Presentar" >
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