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
		if($estadocurso=="1"){	
	    ?>		
		<hr>
		<div class="row">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=profesor&action=gestionSolicitudes">Gestionar solicitudes de TFG mutuo</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s gestionar tus propias solicitudes de TFG mutuo antes de que acabe el plazo.</p>               
		</div>
        <!-- /.row -->
        <?php 
		} 
		if(strval($estadocurso)=="2"){ 
	    ?>
		<hr>
		<div class="row">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=profesor&action=gestionPropuestas">Gestionar propuestas de TFG</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s gestionar tus propias propuestas de TFG antes de que acabe el plazo.</p>               
		</div>
        <!-- /.row -->
    <?php 
		}
	?>
        <hr>
        <div class="row">
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=profesor&action=modifyPr">Modificar contraseña</a>
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