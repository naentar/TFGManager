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
			    <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=users&action=modifyAl">Modificar informaci&oacute;n personal</a>
                </p> 
                <p>En esta opci&oacute;n podrás comprobar tu informaci&oacute;n personal y realizar modificaciones sobre de diversa informaci&oacute;n personal adem&aacute;s de poder modificar la contraseña.</p>
                
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
        
    </div>
	
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>