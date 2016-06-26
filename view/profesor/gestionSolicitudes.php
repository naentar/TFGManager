 <?php
 require_once(__DIR__ . "/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $listarTFGs = $view->getVariable("listarTFGs");
 $listaProfesores = $view->getVariable("listaProfesores");
 $listaAlumnos = $view->getVariable("listaAlumnos");
 $listaProfesoresSol = $view->getVariable("listaProfesoresSol");
 ?>  


    <!-- Page Content -->
	<div class="container">
	  <div class="row">
	    <br>
	    <h3>Realizar solicitud de acuerdo mutuo:</h3>
        <hr>
		<form class="form-horizontal" role="form" method="post" action="index.php?controller=users&action=mutuoAcuerdo" >
				<div class="mycenter red">
		           <?php echo $view->popFlash();
				   $view->setFlash("");?>
	            </div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="titulo">T&iacute;tulo del TFG</label>
				  <div class="col-sm-4">
					<b><input type="text" class="form-control" name="titulo" placeholder="Introduce t&iacute;tulo"></b>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="empresa">¿Se realiza en empresa?:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="empresa">
					<option value="0">No</option>
					<option value="1">S&iacute;</option>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="alumno">Seleccione alumno:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="alumno">
				    <option value="sin">Seleccione alumno</option>
					<?php foreach($listaAlumnos as $alumno):
						echo '<option value="'.$alumno["dniAlumno"].'">'.$alumno["nombre"].'</option>';
					 endforeach; ?>
				  </select>				
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-sm-4" for="cotutor">Seleccione cotutor:</label>
				  <div class="col-sm-4">			
				  <select class="form-control" name="cotutor">
					<option value="NULL">Sin cotutor</option>
					<?php foreach($listaProfesoresSol as $profesor):
						echo '<option value="'.$profesor["dniProfesor"].'">'.$profesor["nombre"].'</option>';
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
		  </tr>
		</thead>
		<tbody>		  
		    <?php foreach($listarTFGs as $propuesta):
			    echo '<tr>';
				echo '<form method="post" action="index.php?controller=users&action=gestionarSolicitudMutuo">';
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
				echo '<th><select class="form-control" name="alumno">
					       <option value="'.$propuesta["Alumno_dniAlumno"].'">'.$propuesta[2].'</option>';
						$alactual = $propuesta["Alumno_dniAlumno"];   
					    foreach($listaAlumnos as $alumno):
						if($alumno["dniAlumno"]!=$alactual){
						echo '<option value="'.$alumno["dniAlumno"].'">'.$alumno["nombre"].'</option>';
						}
					 endforeach;	 
				    '</select></th>';
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
				echo '<input type="hidden" class="form-control" name="tituloEn" value="'.$propuesta["tituloEn"].'">';
				echo '<input type="hidden" class="form-control" name="tutor" value="'.$propuesta["Profesor_dniProfesor"].'">';
				echo '<input type="hidden" class="form-control" name="idTFG" value="'.$propuesta["idTFG"].'">';
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