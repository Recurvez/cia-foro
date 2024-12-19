<?php
include "../../Templates/Hk_Head_2.php";

$query = $link->query('SELECT ID,rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $iddd = $row['ID'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 8) {
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
              <h3 class="panel-title">Editar usuario</h3>
            </div>
            <div class="panel-body">

              <?php
$id = $_GET['id'];
$consulta =<<<SQL
SELECT *
FROM
usuarios WHERE ID = $id
LIMIT 1
SQL;

 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
?>
<div class="formulariohk">
    <form method="post" action="../actualizar/user.php">
        <input type="hidden" name="id" value="<?php echo $columnas['ID']; ?>"/>

        <input type="hidden" name="user_edit" value="<?php echo $columnas['username']; ?>"/>

        <label>Nombre de Usuario</label>
        <div class="input-group date">
            <input type="text" id="nacimiento" class="form-control" name="newusername" placeholder="Nombre de usuario" aria-describedby="basic-addon2" value="<?php echo $columnas['username']; ?>" required="" />
        </div>  <br>

        <input type="hidden" name="tag" value="<?php echo $columnas['TAG']; ?>" />

        <label>Firma</label>
        <input type="text" id = "nacimiento" class="form-control" name="newtag" value="<?php echo $columnas['TAG']; ?>" style="width: 60px;" />  <br>

        <label for="lupas-input">Lupas</label>
<div style="display: flex; align-items: center; gap: 10px; border: 1px solid #999; border-radius: 6px; padding: 5px; width: fit-content;">
    <img src="https://images.habbo.com/c_images/album1584/DE149.png" alt="Lupa" style="width: 24px; height: 24px;">
    <input type="text" id="lupas-input" class="form-control" name="lupas" value="<?php echo $columnas['lupas'];?>" 
        style="border: none; font-size: 1em; outline: none; width: 60px;">
</div><br>


        <label>Fecha de creación</label>
        <div class="input-group date">
            <input type="text" id="nacimiento" class="form-control" name="fecha" placeholder="Fecha de Creación" aria-describedby="basic-addon2" value="<?php echo $columnas['fecha']; ?>" readonly=""/>
        </div>    <br>

        <?php if ($rangouser >= 12 || $dev == 1 || $iddd == 6) { ?>

        <label>Trabajador de la Semana</label>
        <select class="form-control" name="week_worker" style="width: 200px;">
            <option value="0" <?php if ($columnas['week_worker'] == 0) echo 'selected'; ?>>No</option>
            <option value="1" <?php if ($columnas['week_worker'] == 1) echo 'selected'; ?>>Sí</option>
        </select><br>
            <?php } ?>
        <?php					
		$fechaup = new DateTime($columnas['uc']); // Fecha guardada en la base de datos
		$fechaActual = new DateTime(); // Fecha y hora actual

		// Calcular la diferencia
		$diferencia = $fechaActual->diff($fechaup);

	    // Construir el texto con la diferencia de tiempo
		$diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos, " . $diferencia->s . " segundos";
		?>
        
        <label>Última vez conectado</label>
        <div class="input-group date">
        <input type="text" id="nacimiento" class="form-control" name="uc" aria-describedby="basic-addon2" value="<?php echo $diferenciaTexto; ?>" readonly="" style="width: 350px;"/>
        </div>    <br>

        <label>Avatar</label>
        <img class="media-object" src="<?php echo $columnas['avatar'];?>" width="70" height="100" />

        <center><input class="btn btn-primary" type="submit" value="Guardar" style="width: 120px;" /></center>
    </form>
</div>
</div>
			</div>
          </div>

		</div>
      </div><!-- /container -->
<?php 

include "../../Templates/Hk_Footer_2.php";

?>