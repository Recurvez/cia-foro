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
	  
	  <?php
                      $resultado = $link->query("SELECT * FROM config WHERE id = 1");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      if("$row[mantenimiento]" == "1") {
                      $dato_mantenimiento = "Activo";
                      } else {
                      $dato_mantenimiento = "Desactivo";
                      }
                      $mantenimiento_date = $row['mantenimiento'];


                     if("$row[iniciar_sesion]" == "1") {
                      $dato_iniciarsesion = "Activo";
                      } else {
                      $dato_iniciarsesion = "Desactivo";
                      }
                      $iniciarid = $row['iniciar_sesion'];

                      if("$row[registro]" == "1") {
                      $dato_registro = "Activo";
                      } else {
                      $dato_registro = "Desactivo";
                      }
                      $registro_date = $row['registro'];

                      if("$row[publicidad]" == "1") {
                      $dato_publicidad = "Activo";
                      } else {
                      $dato_publicidad = "Desactivo";
                      }
                      $publicidad_date = $row['publicidad'];
                      $dato_codigo = $row['codigo'];
                      }
?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">
<div class="col-md-8">
          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[339]; ?></h3>
            </div>
            <div class="panel-body">
<div class="formulariohk">
              <form method="post" action="actualizar/mantenimiento.php">

                    <label><?php echo $lang[340]; ?></label><br>
                    <select name="mantenimiento">
                    <option value="<?php echo $mantenimiento_date; ?>"><?php echo $dato_mantenimiento; ?></option>
                    <option value="0"></option>
                    <option value="0"><?php echo $lang[327]; ?></option>
                    <option value="1"><?php echo $lang[328]; ?></option>
                    </select><br><br>

                    <label><?php echo $lang[241]; ?></label><br>
                    <select name="iniciar_sesion">
                    <option value="<?php echo $iniciarid; ?>"><?php echo $dato_iniciarsesion; ?></option>
                    <option value="1"></option>
                    <option value="0"><?php echo $lang[327]; ?></option>
                    <option value="1"><?php echo $lang[328]; ?></option>
                    </select><br><br>

                    <label><?php echo $lang[341]; ?></label><br>
                    <select name="registro">
                    <option value="<?php echo $registro_date; ?>"><?php echo $dato_registro; ?></option>
                    <option value="1"></option>
                    <option value="0"><?php echo $lang[327]; ?></option>
                    <option value="1"><?php echo $lang[328]; ?></option>
                    </select><br><br>

                    <label><?php echo $lang[342]; ?></label><br>
                    <select name="publicidad">
                    <option value="<?php echo $publicidad_date; ?>"><?php echo $dato_publicidad; ?></option>
                    <option value="1"></option>
                    <option value="0"><?php echo $lang[327]; ?></option>
                    <option value="1"><?php echo $lang[328]; ?></option>
                    </select><br><br>

                   <label><?php echo $lang[343]; ?></label>
                   <input style='margin-bottom: 10px;' type='text' class='form-control' value='<?php echo $dato_codigo; ?>' name='codigo' placeholder='<?php echo $lang[344]; ?>'/><br>

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
