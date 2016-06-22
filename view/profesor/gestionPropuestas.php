<!DOCTYPE html>
<html lang="en">
 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $listarPropuestas = $view->getVariable("listarPropuestas");
 $listaProfesores = $view->getVariable("listaProfesores");
 $listaProfesoresProp = $view->getVariable("listaProfesoresProp");
 $listaAlumnos = $view->getVariable("listaAlumnos");
 $numeroPropPor = $view->getVariable("numeroPropPor");
 $numProp = $view->getVariable("numProp");
 $dniProf = $view->getVariable("dniProf");
 ?>  


    <!-- Page Content -->
	<div class="container">
		<div class="row">
	    <br>
	    <h3>Realizar propuesta de TFG:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=realizarPropuesta" >
		        <div class="mycenter red">
		           <?php echo $view->popFlash();
				   $view->setFlash("");?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="numero">N&uacute;mero de propuestas a realizar:</label>
				  <div class="col-sm-4">
					<b><input class="form-control" name="numero" value="<?php
					$actual = $numeroPropPor - $numProp;
					if($actual<=0){
					echo "Ya has realizado el min&iacute;mo de propuestas.";
					}else {
					echo "Te falta ".$actual." TFG para cumplir el m&iacute;nimo.";
					}?>" disabled></input></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="titulo">T&iacute;tulo:</label>
				  <div class="col-sm-4">
					<b><textarea class="form-control" rows="2" name="titulo" placeholder="Introduzca el t&iacute;tulo del TFG"></textarea></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="descripcion">Descripci&oacute;n</label>
				  <div class="col-sm-4">
					<b><textarea class="form-control" rows="5" name="descripcion" placeholder="Realice una descripci&oacute;n del TFG"></textarea></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="cotutor">Seleccione cotutor:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="cotutor">
					<option value="NULL">Sin cotutor</option>
					<?php foreach($listaProfesoresProp as $profesor):
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">        
				  <div class="col-sm-offset-4 col-sm-10">
						<input type="submit" class="btn btn-default" value="Presentar" >
				  </div>
				</div>
			</form>
		</div>
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
			<th>Opci&oacute;n:</th>
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarPropuestas as $propuesta):
			    if($propuesta["Profesor_dniProfesor"]==$dniProf["dniProfesor"]){
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarPropuesta">';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="titulo" value="'.$propuesta["titulo"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><input type="text" class="form-control" name="descripcion" value="'.$propuesta["descripcion"].'"></th>';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<th><select class="form-control" name="tutor" disabled>
					       <option value="'.$propuesta["Profesor_dniProfesor"].'">'.$propuesta[0].'</option>';
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
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="modificar" value="Modificar" ></th>';
				echo '<th><input type="submit" class="btn btn-info btn-sm" name="eliminar" value="Eliminar" ></th>';
				echo '</div>';
				echo '<input type="hidden" class="form-control" name="idpropuesta" value="'.$propuesta["idPropuestasDeTFG"].'">';
				echo '<input type="hidden" class="form-control" name="tutor" value="'.$propuesta["Profesor_dniProfesor"].'">';
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