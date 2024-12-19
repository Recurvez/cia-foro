<?php
include "../../Templates/Hk_Head_2.php";

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

include "../../Templates/Hk_Nav.php";
?>

	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">
<div class="col-md-8">
          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title">Editar Rango</h3>
            </div>
            <div class="panel-body">

              <?php
$id = $_GET['id'];
$consulta =<<<SQL
SELECT *
FROM
rangos WHERE id = '$id'
LIMIT 1
SQL;
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
?>
<div class="formulariohk">
              <form method="post" action="../actualizar/rango.php">
			  
			  <input type="hidden" name="id" value="<?php echo $columnas['id']; ?>"/>

              <label>Nombre</label>
        <input style="margin-bottom: 15px;width:30%;" type="text" required="" class="form-control" name="nombre" placeholder="Nombre del rango" value="<?php echo $columnas['nombre']; ?>" />
		
              <label>Mision</label>
        <input style="margin-bottom: 15px;width:60%;" type="text" required="" class="form-control" name="mision" placeholder="Misión del rango" value="<?php echo $columnas['mision']; ?>" />
					
                    <label>Color</label><br>
                    <select style="margin-bottom: 15px;" required="" name="color">
                    <option value="<?php echo $columnas['color']; ?>"><?php echo $columnas['color']; ?></option>
                    <option value="blue">blue</option>
                    <option value="orange">orange</option>
                    <option value="oscuro">oscuro</option>
                    <option value="gren">green</option>
                    <option value="rosa">rosa</option>
                    <option value="red">red</option>
					</select>
					
                    <center><input class="btn btn-primary" type="submit" value="Guardar" style="width: 120px;" /></center>
                      </form>
</div></div>
			</div>
          </div>

		</div>
      </div><!-- /container -->
<?php 

include "../../Templates/Hk_Footer_2.php";

?>