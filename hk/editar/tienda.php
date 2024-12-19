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
              <h3 class="panel-title">Editar Contenido de Tienda</h3>
            </div>
            <div class="panel-body">

              <?php
$id = $_GET['id'];
$consulta =<<<SQL
SELECT *
FROM
tienda WHERE id = '$id'
LIMIT 1
SQL;
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
?>
<div class="formulariohk">
              <form method="post" action="../actualizar/tienda.php">
			  <input type="hidden" name="id" value="<?php echo $columnas['id']; ?>"/>

              <label>Code</label>
             <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="code" placeholder="Aquí el code de la placa ejemplo: WAR" value="<?php echo $columnas['code_placa']; ?>" />  <br>

               <label>Precio</label>
             <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="precio" placeholder="El precio de la placa" value="<?php echo $columnas['precio']; ?>" />  <br>

                    <label>Compra en:</label><br>
                    <select  required="" name="icono">
                    <option value="<?php echo $columnas['icono']; ?>" selected><?php echo $columnas['icono']; ?></option>
                    <option value="<?php echo $columnas['icono']; ?>"></option>
                    <option value="creditos">Creditos</option>
                    <option value="diamantes">Diamantes</option>
                    </select><br><br>

              <label>Unidades</label>
             <input style="margin-bottom: 10px;" type="number" required="" class="form-control" name="unidades" placeholder="La cantidad de veces que se puede comprar" value="<?php echo $columnas['unidades']; ?>" />  <br>
					
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