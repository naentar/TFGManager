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
	  <p>Selecciona la opci&oacute;n a realizar, en cada uno de los casos.</p>
	  <table class="table table-hover">
		<thead>
		  <tr>			  
			<th>T&iacute;tulo</th>
			<th>Empresa</th>
			<th>Alumno</th>
			<th>Tutor</th>
			<th>Cotutor</th>
			<th>Opci&oacute;n:</th>
			<th>Opci&oacute;n:</th>
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarTFGs as $propuesta):
			    if($propuesta["tituloEn"]!="aceptado"){
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarSolicitud">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="titulo" value="'.$propuesta["tituloEs"].'"></th>';
				echo '</div>';
				if($propuesta["empresa"]==0){
				echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa">
							<option value="0">No</option>
							<option value="1">S&iacute;</option>
						  </select>				
				     </div></th>';
				}else{
                echo '<th><div class="form-group">			
						  <select class="form-control" name="empresa">
							<option value="1">S&iacute;</option>
							<option value="0">No</option>
						  </select>				
				     </div></th>';
				}				
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="alumno" >
				        <option value="$propuesta["Alumno_dniAlumno"]">'.$propuesta[2].'</option>
						</select></th>';
				echo '</div>';	 
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="tutor">
					       <option value="'.$propuesta["Profesor_dniProfesor"].'">'.$propuesta[0].'</option>';
					    foreach($listaProfesores as $profesor):
					    if($propuesta["Profesor_dniProfesor"]!=$profesor["dniProfesor"] && $propuesta["Profesor_dniProfesorCotutor"]!=$profesor["dniProfesor"]){
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
						}
					 endforeach;
				    '</select></th>';
                echo '</div>';
                echo '<div class="form-group">';				
				if($propuesta[1]!="NULL"){
				echo '<th><select class="form-control" name="cotutor">
					       <option value="'.$propuesta["Profesor_dniProfesorCotutor"].'">'.$propuesta[1].'</option>';
					    foreach($listaProfesores as $profesor):
					    if($propuesta["Profesor_dniProfesor"]!=$profesor["dniProfesor"] && $propuesta["Profesor_dniProfesorCotutor"]!=$profesor["dniProfesor"]){
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
						}
					 endforeach;
			        echo '<option value="NULL">Sin cotutor</option>';		 
				    '</select></th>';
				}else{
				echo '<th><select class="form-control" name="cotutor">
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
                echo '<th><input type="submit" class="btn btn-info btn-sm" name="aceptar" value="Aceptar" ></th>';				
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="idTFG" value="'.$propuesta["idTFG"].'">';
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