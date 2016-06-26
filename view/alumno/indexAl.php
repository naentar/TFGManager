<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $estadocurso = $view->getVariable("estadocurso");
 $existeTFG = $view->getVariable("existeTFG");
 $existeSolicitud = $view->getVariable("existeSolicitud");
 $TFGacep = $view->getVariable("TFGacep");
 ?>  

    <!-- Page Content -->
    <div class="container">   
    <?php 
		if($estadocurso=="3"){
            if($existeTFG=="no" && $existeSolicitud=="no"){		
	?>     
	     <div class="row"> 
				<hr>		
					<p>
						<a class="btn btn-default btn-lg" href="index.php?controller=alumno&action=SolicitudTFG">Solicitar lista de propuestas.</a>
					</p> 
					<p>Esta opci&oacute;n te permite realizar tu solicitud de TFG en base a la lista de propuestas realizada por los profesores.</p>                
			</div>	
        <!-- /.row --> 
    <?php 
			}else{
	?>
        <div class="row">
		<hr>
			    <h2>Solicitud almacenada</h2>
                <p>Ya has realizado tu solicitud de TFG, por favor espera hasta el final del per&iacute;odo de asignaci&oacute;n para comprobar que TFG te ha sido asignado.</p>               
        </div> 

	<?php
			}
		}	
		if($estadocurso=="5"){
		   if($TFGacep["tituloEn"]=="mutuo" || $TFGacep["tituloEn"]=="solicitado"){
	?>	
		    <div class="row"> 
				<hr>		
					<p>
						<a class="btn btn-default btn-lg" href="index.php?controller=alumno&action=confirmarAsignacion">Confirmar asignaci&oacute;n definitiva.</a>
					</p> 
					<p>En caso de querer realizar una asignaci&oacute;n definitiva de anteproyecto, rellene el formulario que se encuentra en este bot&oacute;n.</p>                
			</div>	
        <!-- /.row -->
	<?php
            }else {
	?>
			<div class="row"> 
				<hr>		
					<h2>Asignaci&oacute;n almacenada</h2>
					<p>Tu solicitud de asignaci&oacute;n ya ha sido almacenada, ya puedes comenzar con la realizaci&oacute;n de tu TFG.</p> 
                    <p><a href="/TFGManager/asignacionOficial<?php 
					list($valun,$valdos) = preg_split('[/]',$TFGacep["idTFG"]);
					echo $valun;
					echo '_';
					echo $valdos;
					?>.pdf">Pulsa aqu&iacute;</a> para comprobar su informe de asignaci&oacute;n definitiva.</p>					
			</div>
	<?php 	
			}
		}
	?>
     <hr>
        <div class="row">
			    <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=alumno&action=modifyAl">Modificar informaci&oacute;n personal</a>
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