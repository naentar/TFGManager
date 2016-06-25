<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $usuario = $view->getVariable("currentusername");
 $currentuser = $view->getVariable("currentusername");
 $estadocurso = $view->getVariable("estadocurso");
 ?>  

    <!-- Page Content -->
    <div class="container">

        <hr>

        <div class="row">
            <div class="col-sm-8">
                <h2>Objetivo de esta web</h2>
                <p>La p&aacute;gina esta pensada para facilitar la gesti&oacute;n de las distintas partes de las que consta un curso de TFG.</p>
				<?php
						if (!isset($currentuser)) echo '
						<p>En caso de haber recibido un correo conforme formas parte de este curso con un usuario y contraseña puedes iniciar sesi&oacute;n aqu&iacute;:</p>
							<p>
								<a class="btn btn-default btn-lg" href="index.php?controller=users&action=login">Iniciar sesi&oacute;n</a>
							</p>';
				?>                
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
                </address>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">

            <div class="col-sm-10">
			    <?php	
		            if($estadocurso=="0" || $estadocurso=="1" || $estadocurso=="2"){
	            ?>
                <a href="#"><img class="img-circle img-responsive img-center" src="imgs/tfg.jpg" alt=""></a>				
                <h2>Lista de TFG's ofrecidos por profesores</h2>
                <p>Aqu&iacute; podr&aacute;s comprobar la lista con todos los TFG's que ofrecen los profesores una vez haya sido publicada (para ello pulsa sobre el icono "TFG").</p>
				<?php	
		             }	
		            if($estadocurso=="3"){
	            ?>
                <a href="/TFGManager/propuestas.pdf"><img class="img-circle img-responsive img-center" src="imgs/tfg.jpg" alt=""></a>				
                <h2>Lista de TFG's ofrecidos por profesores</h2>
                <p>Aqu&iacute; podr&aacute;s comprobar la lista con todos los TFG's que ofrecen los profesores(para ello pulsa sobre el icono "TFG").</p>
				<?php	
		             }
					 if($estadocurso=="4" ){
	            ?>
				<a href="/TFGManager/asignacionesP.pdf"><img class="img-circle img-responsive img-center" src="imgs/tfg.jpg" alt=""></a>
				<h2>Lista provisional de TFG's asignados a alumnos por petici&oacute;n</h2>
                <p>Aqu&iacute; podr&aacute;s comprobar la lista de TFG's asignados a alumnos(para ello pulsa sobre el icono "TFG").</p>
				<?php	
		            }
	            ?>
				<?php
					 if($estadocurso=="5" || $estadocurso=="6" || $estadocurso=="7"){
	            ?>
				<a href="/TFGManager/asignacionesD.pdf"><img class="img-circle img-responsive img-center" src="imgs/tfg.jpg" alt=""></a>
				<h2>Lista definitiva de TFG's asignados a alumnos por petici&oacute;n</h2>
                <p>Aqu&iacute; podr&aacute;s comprobar la lista de TFG's asignados a alumnos(para ello pulsa sobre el icono "TFG").</p>
				<?php	
		            }
	            ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>