<?php
include "../Templates/Hk_Head.php";

$query = $link->query('SELECT rank FROM usuarios WHERE username = "' .$username. '"');
while($row = mysqli_fetch_array($query))
{
  $rangouser = $row['rank'];
  //$dev = $row['dev'];
}
if ($rangouser >= 1 && $rangouser <= 12) {
  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit;
}

include "../Templates/Hk_Nav.php";
?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">
         
         <div style="width: 600px" class="panel panel-default">
                  <div class="panel-heading green">
              <h3 class="panel-title"><?php echo $lang[371]; ?></h3>
            </div>
            <div class="panel-body">
<div class="container-fluid">
<form action="" method="post" enctype="multipart/form-data">
    <div style="float:left;">
              <label><?php echo $lang[371]; ?>Nombre</label>
        <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="user" placeholder="<?php echo $lang[175]; ?>" value="" /></div>
		
				    <div style="float:left;margin-left:10px;">
              <label><?php echo $lang[374]; ?></label>
        <input style="margin-bottom: 10px;width:250px;" type="number" required="" class="form-control" name="cantidad" placeholder="<?php echo $lang[372]; ?>" value="" /></div>
					
<input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[371]; ?>" style="margin-top: 10px;" /></form>
    
					  <?php
if ($_POST['cantidad'] && $_POST['user']) {
$consulta1 = $link->query("SELECT * FROM usuarios WHERE username = '".$_POST['user']."'");
$resultados = mysqli_num_rows($consulta1);

if ($resultados == 0) {
  echo "<br><div class='alerta-no'>$lang[373]</div>";
} else {
  $fecha_log = date("Y-m-d");
$rango_mio = $link->query("SELECT * FROM usuarios WHERE username = '".$username."'");
while ($row = mysqli_fetch_array($rango_mio)) {
  $rango_mio_1 = $row['rank'];
}

$rango_name = $link->query("SELECT * FROM rangos WHERE id = '".$rango_mio_1."'");
while ($row = mysqli_fetch_array($rango_name)) {
  $rango = $row['nombre'];
}

$mensaje = "$lang[375] $_POST[cantidad] $lang[376] $username ($rango $lang[377] $nameweb)<br><center><div class=cantidad><img src=http://i.imgur.com/iC0Nkou.png> $_POST[cantidad]</div></center>";
$asunto = $lang[378];

while ($row = mysqli_fetch_array($consulta1)) {
  $diamantes = $row['diamantes'];
}

$cantidad = $diamantes + $_POST['cantidad'];

$actualizar = "UPDATE usuarios SET diamantes='$cantidad' WHERE username = '".$_POST['user']."' ";
$link->query($actualizar);

$user_recibido = $_POST['user'];

$enviar_mensaje_1 = "INSERT INTO usuarios_mensajes_privados (user_enviado,user_recibido,asunto,mensaje,fecha) VALUES ('".$username."','".$user_recibido."','".$asunto."','".$mensaje."','".$fecha_log."')";
$link->query($enviar_mensaje_1);

// Guardar acción en Logs si se ha iniciado sesión
$accion = "$lang[379] $_POST[cantidad] $lang[380] $_POST[user]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  echo "<br><div class='alerta-si'>$lang[381] $_POST[cantidad] $lang[380] $_POST[user] $lang[71]</div>";
}
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
