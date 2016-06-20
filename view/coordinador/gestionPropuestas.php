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
	  <p>Selecciona la opci&oacute;n a realizarSelecciona la opci&oacute;n a realizar, en cada uno de los casos.</p>
	  <table class="table table-hover">
		<thead>
		  <tr>			  
			<th>T&iacute;tulo</th>
			<th>Descripci&oacute;n</th>
			<th>Tutor</th>
			<th>Cotutor</th>
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarPropuestas as $propuesta):
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarPropuestaC">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="titulo" value="'.$propuesta["titulo"].'" disabled></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="descripcion" value="'.$propuesta["descripcion"].'" disabled></th>';
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
				echo '<input type="hidden" class="form-control" name="idpropuesta" value="'.$propuesta["idPropuestasDeTFG"].'">';
				echo '<input type="hidden" class="form-control" name="tutor" value="'.$propuesta["Profesor_dniProfesor"].'">';
				echo '<input type="hidden" class="form-control" name="cotutor" value="'.$propuesta["Profesor_dniProfesorCotutor"].'">';
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