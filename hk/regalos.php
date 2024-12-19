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
              <h3 class="panel-title"><?php echo $lang[311]; ?></h3>
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
    $query = $link->query("SELECT * FROM usuarios_regalos order by id DESC");
    while($row = mysqli_fetch_array($query)) {
    ?>

       <!-- Modal -->
  <div class="modal fade" id="ver_regalo_<?php echo "$row[id]"; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[145]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo "$row[user_enviado]"; ?>"><?php echo "$row[user_enviado]"; ?> para <a href="<?php echo $url; ?>/perfil.php?user=<?php echo "$row[user_recibido]"; ?>"><?php echo "$row[user_recibido]"; ?></a></h4>
        </div>
        <div class="modal-body">
      
<form class="form-horizontal" action="ajustes.php?regalos" method="post" enctype="multipart/form-data">
    <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $row['asunto_regalo']; ?>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $row['mensaje_regalo']; ?>
        <span class="help-block"></span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[103]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $lang[143]; ?>: <?php echo $row['code_placa']; ?> 
                <?php 
            $placa1=$link->query("SELECT * FROM placas WHERE code = '".$row['code_placa']."'");
            while($row=mysqli_fetch_array($placa1)){
              $imagen_placa = $row['imagen']; ?>
            <img src="<?php echo $imagen_placa; ?>">
            <?php } ?>
      </div>
    </div>
  </fieldset>
</form>
      
        </div>
      </div>
      
    </div>
  </div>

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
      url:'../kernel/ajax/Hk_regalos_ajax.php',
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