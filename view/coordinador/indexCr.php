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
				  <label class="control-label col-sm-4" for="estado">Estado del curso actual:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="estado" value="<?php 
					if(strval($estadocurso)=="0") echo '1.Inicio de curso';
					if(strval($estadocurso)=="1") echo '2.Propuestas de TFGs de mutuo acuerdo';
					if(strval($estadocurso)=="2") echo '3.Propuestas de Profesores';
					if(strval($estadocurso)=="3") echo '4.Solicitudes de Alumnos';
					if(strval($estadocurso)=="4") echo '5.Asignaci&oacute;n provisional';
                    if(strval($estadocurso)=="5") echo '6.Asignaci&oacute;n oficial';
					if(strval($estadocurso)=="6") echo '7.Cursando TFG';					
					?>" disabled></b>
				  </div>
				</div>				
			</form>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=actualizarEstadoCurso" >
				<div class="form-group">
				  <label class="control-label col-sm-4" for="estado">Modificar estado del curso a:</label>
				  <div class="col-sm-4">			
				  <b><input type="text" class="form-control" name="estado" value="<?php 
					if(strval($estadocurso)=="0"){
					echo '2.Propuestas de TFGs de mutuo acuerdo';
					$curso=1;
					}
					if(strval($estadocurso)=="1"){
					echo '3.Propuestas de Profesores';
					$curso=2;
					}
					if(strval($estadocurso)=="2"){
					echo '4.Solicitudes de Alumnos';
					$curso=3;
					}
					if(strval($estadocurso)=="3"){
					echo '5.Asignaci&oacute;n provisional';
					$curso=4;
					}
					if(strval($estadocurso)=="4"){
					echo '6.Asignaci&oacute;n oficial';
					$curso=5;
					}
                    if(strval($estadocurso)=="5"){
					echo '7.Cursando TFG';
					$curso=6;
					}
					if(strval($estadocurso)=="6"){
					echo '1.Inicio de curso';
                    $curso=0;
					}					
					?>" disabled></b>			
				  </div>
				</div>
				<input type="hidden" class="form-control" name="nuevoEstadoCurso" value="<?php echo $curso;?>">
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Modificar Estado" >
				  </div>
				</div>
			</form>
		</div>
        <!-- /.row -->
        <?php 
		if($estadocurso=="2"){	
	    ?>		
        <div class="row">
		<hr>
            <div class="col-sm-8">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionPropuestas">Gestionar propuestas</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s realizar la gesti&oacute;n de las distintas propuestas de TFG presentadas por los profesores.</p>               
            </div>
		</div>
        <!-- /.row -->
        <?php 
		}	

		if($estadocurso=="1"){	
	    ?>		
        <div class="row">
		<hr>
            <div class="col-sm-8">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionSolicitudes">Comprobar solicitudes de TFG mutuo</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s comprobar las distintas solicitudes de TFG de mutuo acuerdo entre profesor y alumno.</p>               
            </div>
		</div>
        <!-- /.row -->
        <?php 
		}
         if($estadocurso=="6"){		
	    ?>
        <div class="row">
		<hr>
            <div class="col-sm-8">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionTFGs">Gestionar TFG's</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s realizar la gesti&oacute;n de los TFG's que se encuentren asignados en este momento.</p>               
            </div>
		</div>
        <!-- /.row -->
        <?php 
		}	
	    ?>	
		<hr>
        <div class="row">		
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=modifyCr">Modificar cuenta</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute; modificar la contraseña de la cuenta, adem&aacute;s, es recomendable la asignaci&oacute;n de la informaci&oacute;n referente al gmail con el que enviar los correos para
				el correcto funcionamiento de los mismos.</p>               
		</div> 
<!-- /.row -->	  		
    </div>	
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>