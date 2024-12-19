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
              <h3 class="panel-title"><?php echo $lang[427]; ?></h3>
            </div>
            <div class="panel-body">

<div class="formulariohk">
<form action="" method="post" enctype="multipart/form-data">
             <label><?php echo $lang[418]; ?></label>
             <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="titulo" placeholder="El titulo de tu promo" value="" />  <br>

              <label>Imagen URL</label>
              <input style="margin-bottom: 10px;" type="text" class="form-control" name="imagen" placeholder="La imagen URL" required="" value="" />  <br>
			  
              <label>URL de boton</label>
              <input style="margin-bottom: 10px;" type="text" class="form-control" name="url_promo" placeholder="URL de <label><?php echo $lang[416]; ?></label> o evento" required="" value="" />  <br>
			  
			  <label>¿Quieres colocar esta promo como principal?</label><br>
                    <select width="100px" name="principal">
					<option value="No">No</option>
                    <option value="active">Si</option>
                </select><br><br>
			  
			  <label>Texto</label>
              <textarea name="texto" style="margin:10px;" cols="80" required="" rows="10" class="form-control"></textarea>  <br>
			
                    <center><input class="btn btn-primary" name="guardar" type="submit" value="Crear Promo" style="width: 120px;" /></center>
                      </form>
					  
					  <?php
if ($_POST['guardar'] && $_POST['titulo']) {
$enviar = "INSERT INTO banner (titulo,imagen,principal,texto,url_promo) values ('".strip_tags($_POST['titulo'])."','".strip_tags($_POST['imagen'])."','".$_POST['principal']."','".strip_tags($_POST['texto'])."','".strip_tags($_POST['url_promo'])."')";

if (@$link->query($enviar)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$fecha_log = date('Y-m-d H:i:s');
$accion = "Ha creado una Promo";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
?>
<script type="text/javascript">
  location.href ="<?php echo $_SERVER['HTTP_REFERER']; ?>";
</script>
<?php
 }
}
?>
					  
</div></div>
			</div>
          </div>

		</div>
      </div><!-- /container -->
<?php 

include "../../Templates/Hk_Footer_2.php";

?>
