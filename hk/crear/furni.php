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
              <h3 class="panel-title"><?php echo $lang[425]; ?></h3>
            </div>
            <div class="panel-body">

<div class="formulariohk">
<form action="" method="post" enctype="multipart/form-data">
             <label><?php echo $lang[123]; ?></label>
             <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="nombre" placeholder="El nombre del Furni" value="" />  <br>

              <label>Imagen URL</label>
              <input style="margin-bottom: 10px;" type="text" class="form-control" name="imagen" placeholder="La imagen URL" required="" value="" />  <br>

                    <label>Icono de compra</label><br>
                    <select required="" name="icon">
                    <option value="http://i.imgur.com/QpP3wav.png">Creditos</option>
                    <option value="http://i.imgur.com/hntEBNE.png">Sofa polar</option>
                    <option value="http://i.imgur.com/NBanQ6z.png">Vip</option>
                    <option value="http://i.imgur.com/6nXSdBS.png">Throne</option>
                    <option value="http://i.imgur.com/2sjGOmJ.png">Diamante</option>
                    </select><br><br>

                    <label>Seccion del Furni</label><br>
                    <select required="" name="seccion">
                    <?php 
                    $consulta = $link->query("SELECT * FROM secciones_furnis");
                    while ($row = mysqli_fetch_array($consulta)) {?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php } ?>
                    </select><br><br>

                                         <label>Valor del furni</label>
              <input style="margin-bottom: 10px;width: 220px;" type="text" class="form-control" name="creditos" placeholder="El valor del furni" required="" value="" />  <br>
			
                    <center><input class="btn btn-primary" name="guardar" type="submit" value="Subir Furni" style="width: 120px;" /></center>
                      </form><?php
if ($_POST['guardar'] && $_POST['nombre']) {
$enviar = "INSERT INTO furnis (nombre,creditos,imagen,icon,seccion) values ('".strip_tags($_POST['nombre'])."','".strip_tags($_POST['creditos'])."','".strip_tags($_POST['imagen'])."','".strip_tags($_POST['icon'])."','".strip_tags($_POST['seccion'])."')";

if ($link->query($enviar)) {
// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date("Y-m-d");
$accion = "Ha subido un furni";
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
?></div></div>
			</div>
          </div>

		</div>
      </div><!-- /container -->

<?php 

include "../../Templates/Hk_Footer_2.php";

?>