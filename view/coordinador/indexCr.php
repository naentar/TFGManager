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
		<div class="col-sm-4">
		<br>
		<div class="list-group">
		  <a class="list-group-item active" disabled>
			<h4 class="list-group-item-heading">Fases del curso:</h4>
			<p class="list-group-item-text">En esta tabla se muestran las distintas etapas del curso, mostrando en verde las ya realizadas, en azul la actual y en amarillo las restantes.</p>
		  </a>
		  <ul class="list-group">
			  <li class="list-group-item list-group-item-<?php if($estadocurso==0){
			  echo 'info';}else{ echo 'success';}?>">1.Inicio de curso</li>
			  <li class="list-group-item list-group-item-<?php if($estadocurso<1){
			  echo 'warning';}else if($estadocurso==1){ echo 'info';}else{ echo 'success';}?>">2.Propuestas de TFGs de mutuo acuerdo</li>
			  <li class="list-group-item list-group-item-<?php if($estadocurso<2){
			  echo 'warning';}else if($estadocurso==2){ echo 'info';}else{ echo 'success';}?>">3.Propuestas de Profesores</li>
			  <li class="list-group-item list-group-item-<?php if($estadocurso<3){
			  echo 'warning';}else if($estadocurso==3){ echo 'info';}else{ echo 'success';}?>">4.Solicitudes de Alumnos</li>
              <li class="list-group-item list-group-item-<?php if($estadocurso<4){
			  echo 'warning';}else if($estadocurso==4){ echo 'info';}else{ echo 'success';}?>">5.Asignaci&oacute;n provisional</li>
              <li class="list-group-item list-group-item-<?php if($estadocurso<5){
			  echo 'warning';}else if($estadocurso==5){ echo 'info';}?>">6.Cursando TFG</li>			  
		</ul>
		</div>
		</div>
		<div class="col-sm-8">

	    <h3>Acciones a realizar para avanzar a la siguiente fase:</h3>
        <hr>
			<div class="mycenter red">
		           <?php echo $view->popFlash();
				   $view->setFlash("");?>
	            </div>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=actualizarEstadoCurso" >
				<?php 
		        if($estadocurso=="0"){	
	            ?>
				<div class="form-group">
				  <label class="control-label col-sm-5" for="datosprofesor">Archivo excel para cargar profesores:</label>
				  <div class="col-sm-4">
					<b><input name="datosprofesor" type="file"></input></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-5" for="datosalumno">Archivo excel para cargar alumnos:</label>
				  <div class="col-sm-4">
					<b><input name="datosalumno" type="file"></input></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-5" for="datostfg">Archivo excel para cargar TFG's:</label>
				  <div class="col-sm-4">
					<b><input name="datostfg" type="file"></input></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-5" for="fechaCurso">Introduzca año del curso</label>
				  <div class="col-sm-6">
					<b><input class="form-control" name="fechaCurso" required="required" pattern="\d{2}/\d{2}" title="Fecha incorrecta, introduzca dos años consecutivos (Por Ej 16/17)" placeholder="aa/aa"></input></b>
				  </div>
				</div>
				<?php 
				}
		        if($estadocurso=="0" || $estadocurso=="1" || $estadocurso=="2" || $estadocurso=="3" || $estadocurso=="4"){	
	            ?>
				<div class="form-group">
				  <label class="control-label col-sm-5" for="fecha">
				  <?php
				  if($estadocurso=="0") echo 'Fecha l&iacute;mite que se mostrará en el email:';
				  if($estadocurso=="1") echo 'Fecha l&iacute;mite que se mostrará en el email:';
				  if($estadocurso=="2") echo 'Fecha l&iacute;mite que se mostrará en el email:';
				  if($estadocurso=="3") echo 'Fecha l&iacute;mite que se mostrará en el email:';
				  if($estadocurso=="4") echo 'Fecha l&iacute;mite que se mostrará en el email:';
				  ?>
				  </label>
				  <div class="col-sm-6">
					<b><input class="form-control" name="fecha" required="required" pattern="\d{2}/\d{2}/\d{4}" title="Fecha incorrecta, inserte d&iacute;a, mes y año (Por Ej 01/01/2017)" placeholder="dd/mm/aaaa"></input></b>
				  </div>
				</div>
				<?php 
				}	
				?>		
				  <b><input type="hidden" class="form-control" name="estado" value="<?php 
					if(strval($estadocurso)=="0"){
					$curso=1;
					}
					if(strval($estadocurso)=="1"){
					$curso=2;
					}
					if(strval($estadocurso)=="2"){
					$curso=3;
					}
					if(strval($estadocurso)=="3"){
					$curso=4;
					}
					if(strval($estadocurso)=="4"){
					$curso=5;
					}
                    if(strval($estadocurso)=="5"){
					$curso=6;
					}					
					?>"></b>			
				<input type="hidden" class="form-control" name="nuevoEstadoCurso" value="<?php echo $curso;?>">
				<div class="form-group">        
				  <div class="col-sm-offset-5 col-sm-10">
						<input type="submit" class="btn btn-default" value="<?php if($estadocurso=="5"){ echo 'Nuevo curso';}else{echo 'Avanzar de fase';} ?>" >
				  </div>
				</div>
			</form>
		</div>
        <!-- /.row -->
		</div>
        <?php 
		if($estadocurso=="2"){	
	    ?>		
        <div class="row">
		<hr>
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionPropuestas">Gestionar propuestas</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s realizar la gesti&oacute;n de las distintas propuestas de TFG presentadas por los profesores.</p>               
		</div>
        <!-- /.row -->
        <?php 
		}	

		if($estadocurso=="1"){	
	    ?>		
        <div class="row">
		<hr>
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionSolicitudes">Gestionar solicitudes</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s comprobar las distintas solicitudes de TFG de mutuo acuerdo entre profesor y alumno.</p>               
		</div>
        <!-- /.row -->
        <?php 
		}
         if($estadocurso=="4" || $estadocurso=="6"){		
	    ?>
        <div class="row">
		<hr>
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionTFGs">
					<?php if($estadocurso=="4"){
					echo 'Gestionar asignaciones provisionales';
					}else{
					echo 'Gestionar TFGs';
					}
					?>
					</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute;s realizar la gesti&oacute;n de los TFG's que se encuentren asignados en este momento.</p>               
		</div>
        <!-- /.row -->
        <?php 
		}	
	    ?>
		<br>
		<hr>
        <div class="row">		
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=gestionUsuarios">Gestionar usuarios</a>
                </p> 
                <p>En esta opci&oacute;n podr&aacute; consultar los distintos usuarios del sistema, as&iacute; como modificarlos.</p>               
		</div>		
		<hr>
        <div class="row">		
                <p>
                    <a class="btn btn-default btn-lg" href="index.php?controller=coordinador&action=modifyCr">Modificar cuenta</a>
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