<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $infoCoordinador = $view->getVariable("coordinadorInf");
 $listarTFGs = $view->getVariable("listarTFGs");
 $listaProfesores = $view->getVariable("listaProfesores");
 ?>  


    <!-- Page Content -->
	<div class="container">
	  <h2>Lista de solicitudes de mutuo acuerdo</h2>
	  <p>Selecciona la opci&oacute;n eliminar, en caso de que sea necesario.</p>
	  <table class="table table-hover">
		<thead>
		  <tr>			  
			<th>T&iacute;tulo</th>
			<th>Empresa</th>
			<th>Alumno</th>
			<th>Tutor</th>
			<th>Cotutor</th>
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarTFGs as $propuesta):
			    if($propuesta["tituloEn"]!="aceptado"){
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarSolicitud">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="titulo" value="'.$propuesta["tituloEs"].'" disabled></th>';
				echo '</div>';
				if($propuesta["empresa"]==0){
				echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa" disabled>
							<option value="0">No</option>
						  </select>				
				     </div></th>';
				}else{
                echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa" disabled>
							<option value="1">S&iacute;</option>
						  </select>				
				     </div></th>';
				}				
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="alumno" disabled>
				        <option value="$propuesta["Alumno_dniAlumno"]">'.$propuesta[2].'</option>
						</select></th>';
				echo '</div>';	 
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="tutor" disabled>
					       <option value="'.$propuesta["Profesor_dniProfesor"].'">'.$propuesta[0].'</option>';
				    '</select></th>';
                echo '</div>';
                echo '<div class="form-group">';				
				if($propuesta[1]!="NULL"){
				echo '<th><select class="form-control" name="cotutor" disabled>
					       <option value="'.$propuesta["Profesor_dniProfesorCotutor"].'">'.$propuesta[1].'</option>';	 
				    '</select></th>';
				}else{
				echo '<th><select class="form-control" name="cotutor" disabled>
					       <option value="NULL">Sin cotutor</option>';
				    '</select></th>';
				}
				echo '</div>';		
				echo '<div class="form-group">';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="idTFG" value="'.$propuesta["idTFG"].'">';
				echo '<input type="hidden" class="form-control" name="tutor" value="'.$propuesta["Profesor_dniProfesor"].'">';
				echo '<input type="hidden" class="form-control" name="cotutor" value="'.$propuesta["Profesor_dniProfesorCotutor"].'">';
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