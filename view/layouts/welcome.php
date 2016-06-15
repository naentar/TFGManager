<!DOCTYPE html>
<html lang="en">
<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$usuario = $view->getVariable("currentusername");
?>  

    <!-- Page Content -->
    <div class="container">

        <hr>

        <div class="row">
            <div class="col-sm-8">
                <h2>Objetivo de esta web</h2>
                <p>La p&aacute;gina esta pensada para facilitar la gesti&oacute;n de las distintas partes de las que consta un curso de TFG.</p>
                <p>En caso de haber recibido un correo conforme formas parte de este curso con un usuario y contraseña puedes iniciar sesi&oacute;n aqu&iacute;:</p>
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=login">Iniciar sesi&oacute;n</a>
                </p>
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
                    <abbr title="Email">Email:</abbr> <a href="mailto:#"> coordinadortfg@esei.uvigo.com</a>
                </address>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">

            <div class="col-sm-10">
                <a href="#"><img class="img-circle img-responsive img-center" src="imgs/tfg.jpg" alt=""></a>
                <h2>Lista de TFG's ofrecidos por profesores</h2>
                <p>Aqu&iacute; podr&aacute;s comprobar la lista con todos los TFG's que ofrecen los profesores una vez haya sido publicada (para ello pulsa sobre el icono "TFG").</p>
            </div>
        </div>
        <!-- /.row -->
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>