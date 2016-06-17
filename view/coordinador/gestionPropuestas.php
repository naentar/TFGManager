<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $infoCoordinador = $view->getVariable("coordinadorInf");
 $listarPropuestas = $view->getVariable("listarPropuestas");
 $listaProfesores = $view->getVariable("listaProfesores");
 ?>  


    <!-- Page Content -->
	<div class="container">
	  <h2>Lista de propuestas</h2>
	  <p>Selecciona la opci&oacute;n a realizar, en caso de querer consultar toda la informaci&oacute;n referente a una propuesta, se recomienda seleccionar modificar para así poder consultar la descripci&oacute;n del mismo.</p>
	  <table class="table table-hover">
		<thead>
		  <tr>			  
			<th>T&iacute;tulo</th>
			<th>Descripci&oacute;n</th>
			<th>Tutor</th>
			<th>Cotutor</th>
			<th>Opci&oacute;n:</th>
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarPropuestas as $propuesta):
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarPropuesta">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="titulo" value="'.$propuesta["titulo"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="descripcion" value="'.$propuesta["descripcion"].'"></th>';
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
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="idpropuesta" value="'.$propuesta["idPropuestasDeTFG"].'">';
				echo '</form>';
				echo '</tr>';
		    endforeach; ?> 
		</tbody>
	  </table>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>