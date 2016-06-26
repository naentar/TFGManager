<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $infoCoordinador = $view->getVariable("coordinadorInf");
 $listarTFGs = $view->getVariable("listarTFGs");
 $listaProfesores = $view->getVariable("listaProfesores");
 $estadocurso = $view->getVariable("estadocurso");
 $listarPropuestasTitulo = $view->getVariable("listarPropuestasTitulo");
 $listarAlumnos = $view->getVariable("listarAlumnos");
 ?>  


    <!-- Page Content -->
	<div class="container">
	  	<?php if($estadocurso=="4"){
		?>
		 <h2>Gestionar reclamaciones</h2>
	     <p>Este formulario te permite modificar el TFG asignado a un alumno, a uno de la lista de propuestas en caso de reclamaci&oacute;n. </p>
		  <br>
	      <div class="row">
		  <div class="mycenter red">
		   <?php echo $view->popFlash();
		   $view->setFlash("");?>
		  </div>
			<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=cambiarAsignacionTFG" >
                <div class="form-group">
				  <label class="control-label col-sm-4" for="alumno">Alumno:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="alumno">
					<option value="vacio1">Sin seleccionar</option>
					<?php foreach($listarAlumnos as $alumno):
						echo '<option value="'.$alumno["Alumno_dniAlumno"].'">'.$alumno[0].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="propuesta">Propuesta de TFG:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="propuesta">
					<option value="vacio2">Sin seleccionar</option>
					<?php foreach($listarPropuestasTitulo as $propuesta):
						echo '<option value="'.$propuesta["idPropuestasDeTFG"].'">'.$propuesta["titulo"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>	
                 <div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Solicitar" >
				  </div>
				</div>
		    </form>								
	      </div>
		  <hr>
		<?php
		}		
		?>
	  <h2>Lista de TFGs</h2>
	  <p>Selecciona la opci&oacute;n a realizar, en cada uno de los casos.</p>
	  <table class="table table-hover">
		<thead>
		  <tr>			  
			<th>T&iacute;tulo Es</th>
			<?php if($estadocurso!="4"){	
			echo '<th>T&iacute;tulo Ga</th>
			      <th>T&iacute;tulo En</th>';
			}?>
			<th>Empresa</th>
			<th>Alumno</th>
			<th>Tutor</th>
			<th>Cotutor</th>
			<?php if($estadocurso!="4"){	
			echo '<th>Opci&oacute;n:</th>';
			}?>
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarTFGs as $propuesta):
			    if(($propuesta["tituloEn"]=="solicitado" && $estadocurso=="4") || ($estadocurso=="5" && $propuesta["tituloEn"]!="solicitado" && $propuesta["tituloEn"]!="mutuo")){
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarTFGs">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="tituloEs" value="'.$propuesta["tituloEs"].'"';
				if($estadocurso=="4") echo 'disabled';
				echo '></th>';
				echo '</div>';
				if($estadocurso!="4"){
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="tituloGa" value="'.$propuesta["tituloGa"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="tituloEn" value="'.$propuesta["tituloEn"].'"></th>';
				echo '</div>';
				}
				if($propuesta["empresa"]==0){
				echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa"';
				if($estadocurso=="4") echo 'disabled';		  
				echo		  '>
							<option value="0">No</option>
							<option value="1">S&iacute;</option>
						  </select>				
				     </div></th>';
				}else{
                echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa"';
				if($estadocurso=="4") echo 'disabled';		  
				echo		  '>
							<option value="1">S&iacute;</option>
							<option value="0">No</option>
						  </select>				
				     </div></th>';
				}				
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="alumno" ';
				if($estadocurso=="4") echo 'disabled';
				echo    '>
				        <option value="$propuesta["Alumno_dniAlumno"]">'.$propuesta[2].'</option>
						</select></th>';
				echo '</div>';	 
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="tutor"';
				if($estadocurso=="4") echo 'disabled';
				echo    '>
					       <option value="'.$propuesta["Profesor_dniProfesor"].'">'.$propuesta[0].'</option>';
					    foreach($listaProfesores as $profesor):
					    if($propuesta["Profesor_dniProfesor"]!=$profesor["dniProfesor"] && $propuesta["Profesor_dniProfesorCotutor"]!=$profesor["dniProfesor"]){
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
						}
						
					 endforeach;
				    '</select></th>';
                echo '</div>';
                echo '<div class="form-group">';				
				if(empty($propuesta["Profesor_dniProfesorCotutor"])!=true){
				echo '<th><select class="form-control" name="cotutor"';
				if($estadocurso=="4") echo 'disabled';
				echo    '>
					       <option value="'.$propuesta["Profesor_dniProfesorCotutor"].'">'.$propuesta[1].'</option>';
					    foreach($listaProfesores as $profesor):
					    if($propuesta["Profesor_dniProfesor"]!=$profesor["dniProfesor"] && $propuesta["Profesor_dniProfesorCotutor"]!=$profesor["dniProfesor"]){
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
						}
					 endforeach;
			        echo '<option value="NULL">Sin cotutor</option>';		 
				    '</select></th>';
				}else{
				echo '<th><select class="form-control" name="cotutor" ';
				if($estadocurso=="4") echo 'disabled';
				echo    '>
					       <option value="NULL">Sin cotutor</option>';
					    foreach($listaProfesores as $profesor):
					    if($propuesta["Profesor_dniProfesor"]!=$profesor["dniProfesor"] && $propuesta["Profesor_dniProfesorCotutor"]!=$profesor["dniProfesor"]){
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
						}
					 endforeach;
				    '</select></th>';
				}
				echo '</div>';		
				echo '<div class="form-group">';
                if($estadocurso!="4"){				
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				}
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="idTFG" value="'.$propuesta["idTFG"].'">';
				echo '<input type="hidden" class="form-control" name="tutorant" value="'.$propuesta["Profesor_dniProfesor"].'">';
				echo '<input type="hidden" class="form-control" name="cotutorant" value="'.$propuesta["Profesor_dniProfesorCotutor"].'">';
				echo '</form>';
				echo '</tr>';
				}
		    endforeach; ?> 
		</tbody>
	  </table>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>