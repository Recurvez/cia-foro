<?php
include "../Templates/Hk_Head.php";

$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 12) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

include "../Templates/Hk_Nav.php";
?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">

          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[275]; ?></h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                          <thead>
                            <tr>
                              <th><?php echo $lang[312]; ?></th>
                              <th><?php echo $lang[123]; ?></th>
                              <th><?php echo $lang[315]; ?></th>
                              <th><?php echo $lang[314]; ?></th>
                              <th><?php echo $lang[140]; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                      
                      $resultado = $link->query("SELECT * FROM rangos WHERE id > 1   ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                            <tr>
                              <td><?php echo "$row[id]"; ?></td>
                              <td><?php echo "$row[nombre]"; ?></td>
                              <td><?php echo "$row[mision]"; ?></td>
                              <td><?php echo "$row[color]"; ?></td>
                              <td><a href="editar/rango.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-success"><span class="MPicon-pencil"></span></button></a> <a href="eliminar/rango.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-danger"><span class="MPicon-cross"></span></button></a></td>
                            </tr>
                            <?php
                          }
                            ?>
                          </tbody>
                        </table>

			</div>
          </div>
         
         <div style="width: 600px" class="panel panel-default">
                  <div class="panel-heading green">
              <h3 class="panel-title"><?php echo $lang[316]; ?></h3>
            </div>
            <div class="panel-body">

<div style="float:left;margin:10px;height: 110px;display: block;">
<form action="" method="post" enctype="multipart/form-data">
    <div style="float:left;margin-left:10px;">
              <label><?php echo $lang[123]; ?></label>
        <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="nombre" placeholder="<?php echo $lang[317]; ?>" value="" /></div>
		
				    <div style="float:left;margin-left:10px;">
              <label><?php echo $lang[315]; ?></label>
        <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="mision" placeholder="<?php echo $lang[318]; ?>" value="" /></div>

    <div style="float:left;margin-left:10px;">
                    <label><?php echo $lang[312]; ?></label><br>
                    <select required="" name="id">
                    <option value="10">10</option>
                    <option value="9">9</option>
                    <option value="8">8</option>
                    <option value="7">7</option>
                    <option value="6">6</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
					</select></div>
					
    <div style="float:left;margin-left:10px;">
                    <label><?php echo $lang[140]; ?></label><br>
                    <select required="" name="color">
                    <option value="blue"><?php echo $lang[319]; ?></option>
                    <option value="orange"><?php echo $lang[320]; ?></option>
                    <option value="oscuro"><?php echo $lang[321]; ?></option>
                    <option value="gren"><?php echo $lang[322]; ?></option>
                    <option value="rosa"><?php echo $lang[323]; ?></option>
                    <option value="red"><?php echo $lang[324]; ?></option>
					</select></div>
					
<div style="margin-right: 10%;margin-left: 10px;">
<input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
    </div></form>
    
					  <?php
if ($_POST['guardar'] && $_POST['nombre']) {
$enviar = "INSERT INTO rangos (id,nombre,mision,color) values ('".$_POST['id']."','".$_POST['nombre']."','".$_POST['mision']."','".$_POST['color']."')";

if (@$link->query($enviar)) { header ("Location: rangos.php"); }
}
?>
                
			</div>
          </div>

		</div>
      </div><!-- /container -->
</div>

<?php 

include "../Templates/Footer.php";

?>
