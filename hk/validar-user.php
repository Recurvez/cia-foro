<?php
include "../Templates/Hk_Head.php";

// Consulta para obtener el rango del usuario actual
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
            <div class="panel-heading blue d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="panel-title" style="margin: 0;"><?php echo $lang[282]; ?></h3>
                <div class="input-group" style="width: 250px;">
                    <input type="text" id="search" placeholder="Buscar usuario..." class="form-control" style="z-index: 1;">
                </div>
            </div>
            <div class="panel-body">
                <div id="loader" style="text-align:center; margin-left:50%;">
                    <img src="loader.gif">
                </div>
                <div class="outer_div"></div><!-- Datos ajax Final -->
            </div>
        </div>
  </div>
</div>

<?php
include "../Templates/Footer.php";
?>

<script>
// Captura el evento de tecleo para realizar la búsqueda en tiempo real
document.getElementById("search").addEventListener("keyup", function() {
  var query = this.value;
  load(1, query);  // Cargar datos con búsqueda
});

// Función para cargar los datos con AJAX
function load(page, search = '') {
  var parametros = {"action": "ajax", "page": page, "search": search};
  $("#loader").fadeIn('slow');
  $.ajax({
    url: '../kernel/ajax/Hk_validar_ajax.php',
    data: parametros,
    beforeSend: function(objeto) {
      $("#loader").html("<img src='loader.gif'>");
    },
    success: function(data) {
      $(".outer_div").html(data).fadeIn('slow');
      $("#loader").html("");
    }
  });
}

// Cargar datos cuando la página se carga
$(document).ready(function(){
  load(1);
});
</script>
