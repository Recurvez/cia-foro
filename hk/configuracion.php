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
              <h3 class="panel-title"><?php echo $lang[387]; ?></h3>
            </div>
            <div class="panel-body">
<div class="formulariohk">
              <form method="post" action="actualizar/config.php">
                            <?php
                      
                      $resultado = $link->query("SELECT * FROM config WHERE id = 1");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
              <label><?php echo $lang[388]; ?></label>
                    <input style="margin-bottom: 10px;width:250px;" type="text" required="" class="form-control" name="nameweb" placeholder="<?php echo $lang[395]; ?>" value="<?php echo "$row[nameweb]"; ?>" />  <br>
					
              <label><?php echo $lang[389]; ?></label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="url" placeholder="<?php echo $lang[396]; ?>" value="<?php echo "$row[url]"; ?>" />  <br>

                     <label><?php echo $lang[390]; ?></label>
                    <input style="margin-bottom: 10px;" type="text" class="form-control" name="pclaves" placeholder="<?php echo $lang[397]; ?>" required="" value="<?php echo "$row[pclaves]"; ?>" />  <br>
					
                     <label><?php echo $lang[391]; ?></label>
<input style="margin-bottom: 10px;" type="text" class="form-control" name="descripcion" placeholder="<?php echo $lang[398]; ?>" required="" value="<?php echo "$row[descripcion]"; ?>" />  <br>

                    <label><?php echo $lang[392]; ?></label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="logo" placeholder="<?php echo $lang[399]; ?>" value="<?php echo "$row[logo]"; ?>" />  <br>
					
                    <label><?php echo $lang[393]; ?></label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="facebook" placeholder="<?php echo $lang[400]; ?>" value="<?php echo "$row[facebook]"; ?>" />  <br>
					
                    <label><?php echo $lang[394]; ?></label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="facebookimg" placeholder="<?php echo $lang[401]; ?>" value="<?php echo "$row[facebookimg]"; ?>" />  <br>
					
                            <?php
                          }
                            ?>
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
