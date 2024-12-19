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
<div class="col-md-8">
          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[326]; ?></h3>
            </div>
            <div class="panel-body">
<div class="formulariohk">
              <form method="post" action="actualizar/radio.php">

              <?php 
if ($radio_op == 1) {
  $dato_radio = $lang[328];
} else {
  $dato_radio = $lang[327];
}
?>

                    <label>Radio</label><br>
                    <select name="radio_op">
                    <option value="<?php echo $radio_op; ?>"><?php echo $dato_radio; ?></option>
                    <option value="<?php echo $radio_op; ?>"></option>
                    <option value="0"><?php echo $lang[327]; ?></option>
                    <option value="1"><?php echo $lang[328]; ?></option>
                    </select><br><br>

                   <label><?php echo $lang[329]; ?></label>
                   <input style='margin-bottom: 10px;' type='text' class='form-control' value='<?php echo $nombre_radio; ?>' name='nombre_radio' placeholder='<?php echo $lang[329]; ?>'/><br>

                   <label><?php echo 'URL de la Radio'; ?></label>
                   <textarea style="margin-bottom: 10px;" type='text' class='form-control' name="radio" placeholder='<?php echo '$lang[331]'; ?>' required=""><?php echo $radio_coder; ?></textarea>  <br>

                    <center><input class="btn btn-primary" type="submit" value="<?php echo $lang[192]; ?>" style="width: 120px;" /></center>
                      </form>
</div></div>
			</div>
          </div>

		</div>
      </div><!-- /container -->

 <?php 

include "../Templates/Footer.php";

?>
