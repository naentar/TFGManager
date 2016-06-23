<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $infoCoordinador = $view->getVariable("coordinadorInf");
 $listarAlumnos = $view->getVariable("listarAlumnos");
 $listaProfesores = $view->getVariable("listaProfesores");
 ?>  


    <!-- Page Content -->
	<div class="container">
	<br>
	 <h2>Lista de usuarios</h2>
	 <p>A continuaci&oacute;n se muestran las listas correspondientes a profesores y alumnos, con sus correspondientes formularios para insertar nuevos.</p>
	<hr>
	<div class="panel-group" id="accordion">
	    <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				<h4>Lista de Alumnos</h4>
			  </h4>
			   </a>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
			<?php if(empty($listarAlumnos)){
			echo '<p>No existen alumnos registrados en el sistema.</p>';			
			}else{
			?>
			<table class="table table-hover">
				<thead>
				  <tr>		  
					<th>Dni</th>
					<th>Email</th>
					<th>Contraseña</th>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Nota Media</th>
					<th>Direccion</th>
					<th>Provincia</th>
					<th>Localidad</th>
					<th>Opci&oacute;n</th>
					<th>Opci&oacute;n</th>
				  </tr>
				</thead>
				<tbody>		  
		    <?php foreach($listarAlumnos as $alumno):
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarAlumnoC">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="dniAlumno" value="'.$alumno["dniAlumno"].'" disabled></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="email" class="form-control" name="email" value="'.$alumno["email"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="password" class="form-control" name="contrasenhaAl" value="'.$alumno["contrasenhaAl"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="nombre" value="'.$alumno["nombre"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="telefono" value="'.$alumno["telefono"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="notaMedia" value="'.$alumno["notaMedia"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="direccion" value="'.$alumno["direccion"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="provincia" value="'.$alumno["provincia"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="localidad" value="'.$alumno["localidad"].'"></th>';
				echo '</div>';					
				echo '<div class="form-group">'; 
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="dniAlumno" value="'.$alumno["dniAlumno"].'">';
				echo '</form>';
				echo '</tr>';
		    endforeach; ?> 
		</tbody>
	  </table>
	  <?php 
	  }
	  ?>			  
			  </div>
			</div>			
	 <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
				<h4>Lista de Profesores</h4>
			  </h4>
			   </a>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
			<?php if(empty($listaProfesores)){
			echo '<p>No existen profesores registrados en el sistema.</p>';			
			}else{
			?>
			<table class="table table-hover">
				<thead>
				  <tr>		  
					<th>Dni</th>
					<th>Email</th>
					<th>Contraseña</th>
					<th>Nombre</th>
					<th>Area de conocimiento</th>
					<th>Departamento</th>
					<th>Opci&oacute;n</th>
					<th>Opci&oacute;n</th>
				  </tr>
				</thead>
				<tbody>		  
		    <?php foreach($listaProfesores as $profesor):
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarProfesorC">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="dniProfesor" value="'.$profesor["dniProfesor"].'" disabled></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="email" class="form-control" name="email" value="'.$profesor["email"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="password" class="form-control" name="contrasenhaPr" value="'.$profesor["contrasenhaPr"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="nombre" value="'.$profesor["nombre"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="areaDeConocimiento" value="'.$profesor["areaDeConocimiento"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="departamento" value="'.$profesor["departamento"].'"></th>';
				echo '</div>';					
				echo '<div class="form-group">'; 
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="dniProfesor" value="'.$profesor["dniProfesor"].'">';
				echo '</form>';
				echo '</tr>';
		    endforeach; ?> 
		</tbody>
	  </table>
	  <?php 
	  }
	  ?>			  
			  </div>
			</div>	
      <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				<h4>Insertar Alumno</h4>
			  </h4>
			   </a>
			</div>
			<div id="collapse3" class="panel-collapse collapse">					
		<div class="row">
		<br>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=gestionarAlumnoC" >
				<div class="mycenter red">
		           <?php echo $view->popFlash();?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="dniAlumno">Dni:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="dniAlumno" placeholder="Introduzca dni del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="email">Email:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="email" placeholder="Introduzca email del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="nombre">Nombre:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="nombre" placeholder="Introduzca nombre del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="notaMedia">Nota Media:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="notaMedia" placeholder="Introduzca la nota media del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="telefono">Tel&eacute;fono:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="telefono" placeholder="Introduzca telefono del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="direccion">Direcci&oacute;n:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="direccion" placeholder="Introduzca direcci&oacute;n del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="localidad">Localidad:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="localidad" placeholder="Introduzca localidad del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="provincia">Provincia:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="provincia" placeholder="Introduzca provincia del alumno"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="contrasenhaAl">Contraseña:</label>
				  <div class="col-sm-4">          
					<b><input type="password" class="form-control" name="contrasenhaAl" placeholder="Introduzca contraseña del alumno"></b>
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" name="insertar" value="Insertar" >
				  </div>
				</div>
			</form>
		</div>
			  </div>
	 </div>
    <div class="panel panel-default">
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
				<h4>Insertar Profesor</h4>
			  </h4>
			   </a>
			</div>
			<div id="collapse4" class="panel-collapse collapse">					
		<div class="row">
		<br>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=gestionarProfesorC" >
				<div class="mycenter red">
		           <?php echo $view->popFlash();?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="dniProfesor">Dni:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="dniProfesor" placeholder="Introduzca el dni del profesor"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="email">Email:</label>
				  <div class="col-sm-4">
					<b><input type="email" class="form-control" name="email" placeholder="Introduzca el email del profesor"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="nombre">Nombre:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="nombre" placeholder="Introduzca el dni del profesor"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="areaDeConocimiento">Area de Conocimiento:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="areaDeConocimiento" placeholder="Introduzca area de conocimiento del profesor"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="departamento">Departamento:</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="departamento" placeholder="Introduzca departamento del profesor"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4 " for="contrasenhaPr">Contraseña:</label>
				  <div class="col-sm-4">          
					<b><input type="password" class="form-control" name="contrasenhaPr" placeholder="Introduzca contraseña del profesor"></b>
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" name="insertar" value="Insertar" >
				  </div>
				</div>
			</form>
	    </div>
	  </div>
	 </div>		 
	</div>	  
   </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>