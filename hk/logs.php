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
    if ($rangouser >= 1 && $rangouser <= 10) {
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
            <div class="panel-heading green" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
              <h3 class="panel-title"><?php echo $lang[276]; ?></h3>
              <input type="text" id="search" placeholder="Buscar..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
            </div>
            <div class="panel-body">

            <?php if ($rangouser == 12 || $dev == 1) { ?> 
                <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                    <a href="eliminar/logs.php">
                        <button type="button" class="btn btn-sm btn-danger"><?php echo $lang[346]; ?></button>
                    </a>
                </div>
            <?php } ?>

            <div id="loader" style="text-aling:center;margin-left:50%;"> <img src="loader.gif"></div>
		<div class="outer_div"></div><!-- Datos ajax Final -->
			</div>
          </div>

          <br>

          <div class="panel panel-default">
    <div class="panel-heading red" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
        <h3 class="panel-title"><?php echo $lang[347]; ?></h3>
        <input type="text" id="searchVentas" placeholder="Buscar..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
    </div>
    <div class="panel-body">
        <?php if ($rangouser == 12 || $dev == 1) { ?> 
            <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                <a href="eliminar/logs_sospechosos.php">
                    <button type="button" class="btn btn-sm btn-danger"><?php echo $lang[346]; ?></button>
                </a>
            </div>
        <?php } ?>
        <div id="loader1" style="text-align:center;margin-left:50%;"> <img src="loader.gif"></div>
        <div class="logs-sospechosos"></div><!-- Datos ajax Final -->
    </div>
        </div>      

		</div>
      </div><!-- /container -->

<?php 

include "../Templates/Footer.php";

?>

<script>
document.getElementById("searchVentas").addEventListener("keyup", function() {
    var query = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../kernel/ajax/Hk_logs_sospechosos_ajax.php?action=ajax&search=" + query, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector(".logs-sospechosos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>

<script>
document.getElementById("search").addEventListener("keyup", function() {
    var query = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../kernel/ajax/Hk_logs_ajax.php?action=ajax&search=" + query, true);
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
    load1(1);
  });

  function load1(page){
    var parametros = {"action":"ajax","page":page};
    $("#loader1").fadeIn('slow1');
    $.ajax({
      url:'../kernel/ajax/Hk_logs_sospechosos_ajax.php',
      data: parametros,
       beforeSend: function(objeto){
      $("#loader1").html("<img src='loader.gif'>");
      },
      success:function(data){
        $(".logs-sospechosos").html(data).fadeIn('slow1');
        $("#loader1").html("");
      }
    })
  }
  </script>

    <script>
  $(document).ready(function(){
    load(1);
  });

  function load(page){
    var parametros = {"action":"ajax","page":page};
    $("#loader").fadeIn('slow');
    $.ajax({
      url:'../kernel/ajax/Hk_logs_ajax.php',
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