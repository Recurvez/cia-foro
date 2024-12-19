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
              <h3 class="panel-title"><?php echo $lang[297]; ?></h3>
            </div>
            <div class="panel-body">
					<div id="loader" style="text-aling:center;margin-left:50%;"> <img src="loader.gif"></div>
		<div class="outer_div"></div><!-- Datos ajax Final -->
<div class="col-md-4"></div>
			</div>
          </div>

		</div>
      </div> <!-- /container -->

        <?php
    $query = $link->query("SELECT * FROM reportes order by id DESC");
    while($row = mysqli_fetch_array($query)) {
    ?>

       <!-- Modal -->
  <div class="modal fade" id="enviar_mensaje" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[95]; ?> <?php echo $row['user_reportado']; ?></h4>
        </div>
        <div class="modal-body">
      
<form class="form-horizontal" action="reportes.php" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?></label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="asunto" value="Advertencia" placeholder="<?php echo $lang[102]; ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" name="mensaje" placeholder="<?php echo $lang[106]; ?> <?php echo $row['user_reportado']; ?> de <?php echo $username; ?>" id="textArea"></textarea>
        <span class="help-block"></span>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" name="guardar" class="btn btn-primary"><?php echo $lang[98]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
      
        </div>
      </div>
      
    </div>
  </div>
  
  <?php
if ($_POST['mensaje'] && $_POST['asunto']) {
    if($_SESSION["logeado"] == "SI"){
  $fecha_log = date("Y-m-d");
$enviar1 = "INSERT INTO usuarios_mensajes_privados (user_enviado,user_recibido,asunto,mensaje,fecha) values ('".$username."','".strip_tags($row['user_reportado'])."','".strip_tags($_POST['asunto'])."','".strip_tags($_POST['mensaje'])."','".$fecha_log."')";
$consulta = "UPDATE reportes SET estado='Resuelto' WHERE id='$row[id]'";
$resultado = $link->query($consulta);

if (@$link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión
$accion = "Ha enviado un mensaje a $row[user_reportado] Como medida a reporte id: $row[id]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alerta-si'>$lang[99] $row[user_reportado] $lang[71]</div>";

    } else {
  echo "<div class='alerta-no'>$lang[100]</div>";
}}
  }
?>

                    <!-- Modal -->
  <div class="modal fade" id="ver_reporte_<?php echo "$row[id]"; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[301]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo "$row[user_enviado]"; ?>"><?php echo "$row[user_enviado]"; ?></a></h4>
        </div>
        <div class="modal-body">
      
<form class="form-horizontal" action="ajustes.php?regalos" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[298]; ?>:</label>
      <div class="col-lg-10">
        <?php echo "$row[user_reportado]"; ?>
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[299]; ?>:</label>
      <div class="col-lg-10">
        <?php echo "$row[estado]"; ?> 
        <span class="help-block"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[300]; ?>:</label>
      <div class="col-lg-10">
        <?php echo "$row[tipo]"; ?>
        <span class="help-block"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?>:</label>
      <div class="col-lg-10">
        <?php echo "$row[mensaje]"; ?>
        <span class="help-block"></span>
      </div>
    </div>
    <br>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <a href="eliminar/reporte.php?id=<?php echo "$row[id]"; ?>"><button type="reset" data-dismiss="modal" class="btn btn-danger"><?php echo $lang[302]; ?></button></a>
        <button data-toggle="modal" data-dismiss="modal" data-target="#acciones_<?php echo "$row[id]"; ?>" name="guardar" class="btn btn-primary"><?php echo $lang[303]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
      
        </div>
      </div>
      
    </div>
  </div>

                      <!-- Modal -->
  <div class="modal fade" id="acciones_<?php echo "$row[id]"; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[304]; ?>:  <a href="<?php echo $url; ?>/perfil.php?user=<?php echo "$row[user_reportado]"; ?>"><?php echo "$row[user_reportado]"; ?></a></h4>
        </div>
        <div class="modal-body">
      
  <fieldset>
    <div class="form-group">
      <div class="col-lg-12 col-lg-offset-1">
      <button type="reset" data-toggle="modal" data-dismiss="modal" data-target="#enviar_mensaje" class="btn btn-primary"><?php echo $lang[55]; ?></button>
        <button type="reset" data-toggle="modal" data-dismiss="modal" data-target="#banear_user" class="btn btn-warning"><?php echo $lang[305]; ?></button>
      </div>
    </div>
  </fieldset>
      
        </div>
      </div>
      
    </div>
  </div>

                 <!-- Modal -->
  <div class="modal fade" id="banear_user" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[306]; ?></h4>
        </div>
        <div class="modal-body">
      
<form class="form-horizontal" action="reportes.php" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-4 control-label"><?php echo $lang[175]; ?></label>
      <div class="col-lg-6">
        <input style="margin-bottom: 10px;width:200px;" type="text" required="" disabled="true" class="form-control" name="" placeholder="Nombre de usuario" value="<?php echo $row['user_reportado']; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-4 control-label"><?php echo $lang[307]; ?></label>
      <div class="col-lg-6">
        <input style="margin-bottom: 10px;width:300px;" type="text" required="" class="form-control" name="razon" placeholder="La razon del baneo" value="<?php echo $row['tipo']; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-4 control-label"><?php echo $lang[308]; ?></label>
      <div class="col-lg-6">
        <input style="margin-bottom: 10px;width:auto;" type="date" required="" class="form-control" name="ban_f" placeholder="Fecha limite" value="" />
        <span class="help-block"></span>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" name="banear" type="submit" class="btn btn-danger"><?php echo $lang[306]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
      
        </div>
      </div>
      
    </div>
  </div>
      <?php
if ($_POST['ban_f'] && $_POST['razon']) {
  if($_SESSION["logeado"] == "SI"){
$ban_i = date("Y-m-d");
$ban_f = nl2br($_POST['ban_f']);

$actualizar_ban = "UPDATE usuarios SET ban='1', ban_i='".$ban_i."', ban_f='".$ban_f."' WHERE username='".$row['user_reportado']."'";
$insertar_ban = "INSERT INTO baneo (usuario,razon,ban_i,ban_f) values ('".$row['user_reportado']."','".$_POST['razon']."','".$ban_i."','".$ban_f."')";

$link->query($actualizar_ban);
$link->query($insertar_ban);

if (@$link->query($actualizar_ban)) { 

$consulta = "UPDATE reportes SET estado='Resuelto' WHERE id='$row[id]'";
$resultado = $link->query($consulta);

// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date("Y-m-d");
$accion = "Ha baneado a $row[user_reportado] como medida a reporte id: $row[id]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alerta-si'>$lang[309] $row[user_reportado] $lang[71]</div><br>";

    } else {
  echo "<div class='alerta-no'>$lang[310]</div><br>";
}}
  }
?>

<?php 
}
include "../Templates/Footer.php";

?>

        <script>
  $(document).ready(function(){
    load(1);
  });

  function load(page){
    var parametros = {"action":"ajax","page":page};
    $("#loader").fadeIn('slow');
    $.ajax({
      url:'../kernel/ajax/Hk_reportes_ajax.php',
      data: parametros,
       beforeSend: function(objeto){
      $("#loader").html("<img src='loader.gif'>");
      },
      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $("#loader").html("");
      }
    })
  }
  </script>