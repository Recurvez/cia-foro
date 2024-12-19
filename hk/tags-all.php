<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
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
    if ($rangouser >= 1 && $rangouser <= 8) {
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
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
              <h3 class="panel-title"><?php echo 'Listado de Firmas'; ?></h3>
              <input type="text" id="search" placeholder="Buscar..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
            </div>
            <div class="panel-body">

            <div id="loader" style="text-aling:center;margin-left:50%;"> <img src="loader.gif"></div>
		<div class="outer_div"></div><!-- Datos ajax Final -->
			</div>
          </div>
          
          <?php if ($rangouser >= 11 || $dev == 1) { ?>
        <div style="width: 900px" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo 'Registrar Firma'; ?></h3>
            </div>
            <div class="panel-body">
                <div style="float:left;margin:10px;height: auto;display: block;">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[27]; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="user" placeholder="<?php echo $lang[175]; ?>" value="" />
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo "Firma"; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="firma" placeholder="<?php echo 'TAG'; ?>" />
                        </div>

                        <br style="clear: both;" />

                        <div style="float:left;margin-left:10px; width: 100%;">
                            <input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
                        </div>
                    </form>

                    <?php
                    if ($_POST['guardar'] && $_POST['user']) {
                      $user = $_POST['user'];
                      $firma = $_POST['firma'];

                      // Guardar la fecha y hora actual en 'ua'
                      $fechaActual = date('Y-m-d H:i:s');
                      
                      // Verificar si el usuario o la firma ya existen en la base de datos
                      $verificar = "SELECT * FROM firmas WHERE usuario = '$user' OR firma = '$firma'";
                      $resultado_verificacion = $link->query($verificar);

                      if ($resultado_verificacion->num_rows > 0) {
                          // Si ya existe el usuario o la firma, mostrar alerta de error
                          echo "<script>
                          Swal.fire({
                              icon: 'error',
                              title: '¡Error!',
                              text: 'El usuario o la firma ya existen en la base de datos.',
                              confirmButtonText: 'OK'
                          });
                          </script>";
                      } else {
                          // Si no existen, realizar la inserción
                          $enviar = "INSERT INTO firmas (usuario, firma) VALUES ('$user', '$firma')";
                          if ($link->query($enviar)) {
                              // Guardar acción en Logs
                              $fecha_log = $fechaActual;
                              $accion = "Ha registrado la firma del usuario <strong><u>$user</u></strong> a <strong>$firma</strong>";
                              $enviar_log = "INSERT INTO logs (usuario,accion,fecha) VALUES ('".$username."','".$accion."','".$fecha_log."')";
                              $resultado_log = $link->query($enviar_log);

                              // Mostrar mensaje de éxito
                              echo "<script>
                              Swal.fire({
                                  icon: 'success',
                                  title: '¡Éxito!',
                                  text: 'El ascenso y la misión se han actualizado correctamente.',
                                  confirmButtonText: 'OK'
                              });
                              </script>";
                          } else {
                              // Mostrar error de inserción
                              echo "Error: " . $link->error;
                          }
                      }
                    }

                    ?>
                </div>
            </div>
        </div>
        <?php } ?>

		</div>
      </div><!-- /container -->

<?php 

include "../Templates/Footer.php";

?>

<script>
document.getElementById("search").addEventListener("keyup", function() {
    var query = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../kernel/ajax/Hk_tags-all.php?action=ajax&search=" + query, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector(".outer_div").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>

    <script>
  $(document).ready(function(){
    load(1);
  });

  function load(page){
    var search = document.getElementById("search").value; // Captura el valor de búsqueda
    var parametros = {"action":"ajax","page":page, "search": search}; // Incluye el término de búsqueda
    $("#loader").fadeIn('slow');
    $.ajax({
      url:'../kernel/ajax/Hk_tags-all.php',
      data: parametros,
       beforeSend: function(objeto){
      $("#loader").html("<img src='loader.gif'>");
      },
      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $("#loader").html("");
      }
    });
}

  </script>