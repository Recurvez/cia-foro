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

$fecha_hoy = date("Y-m-d");

$visitantes = $link->query("SELECT * FROM logs_visitantes WHERE fecha_i = '".$fecha_hoy."'");
$visitantes_hoy = mysqli_num_rows($visitantes);

$usuarios = $link->query("SELECT * FROM usuarios");
$usuarios_registrados = mysqli_num_rows($usuarios);

$equipo = $link->query("SELECT * FROM usuarios WHERE rank > 2");
$miembros_equipo = mysqli_num_rows($equipo);

$logs = $link->query("SELECT * FROM logs");
$logs_normales = mysqli_num_rows($logs);
$logs_visit = $link->query("SELECT * FROM logs_visitantes");
$logs_visitantes = mysqli_num_rows($logs_visit);
$logs_sospe = $link->query("SELECT * FROM logs_sospechosos");
$logs_sospechosos = mysqli_num_rows($logs_sospe);

$total_logs = $logs_normales + $logs_sospechosos;

$comentarios = $link->query("SELECT * FROM comentarios");
$comentarios_total = mysqli_num_rows($comentarios);

$noticias = $link->query("SELECT * FROM noticias");
$noticias_total = mysqli_num_rows($noticias);
$eventos = $link->query("SELECT * FROM eventos");
$eventos_total = mysqli_num_rows($eventos);

$total_publicaciones = $noticias_total + $eventos_total;

$regalos = $link->query("SELECT * FROM usuarios_regalos");
$regalos_total = mysqli_num_rows($regalos);

$mensajes = $link->query("SELECT * FROM usuarios_mensajes_privados");
$mensajes_total = mysqli_num_rows($mensajes);

$images = $link->query("SELECT * FROM images");
$imagenes_total = mysqli_num_rows($images);

$reportes = $link->query("SELECT * FROM reportes");
$reportes_total = mysqli_num_rows($reportes);

$furnis = $link->query("SELECT * FROM furnis");
$furnis_total = mysqli_num_rows($furnis);

$tienda = $link->query("SELECT * FROM tienda");
$tienda_total = mysqli_num_rows($tienda);

$baneos = $link->query("SELECT * FROM baneo");
$baneos_total = mysqli_num_rows($baneos);

$total = $usuarios_registrados + $total_logs + $comentarios_total + $total_publicaciones + $regalos_total + $mensajes_total + $imagenes_total + $reportes_total + $logs_visitantes + $furnis_total + $tienda_total + $baneos_total;

?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">

          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[353]; ?></h3>
            </div>
            <div class="panel-body">
<div class="container-fluid">
<div class="row">
        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></h2>
<h4><?php echo $lang[354]; ?></h4>
<h3><?php echo $visitantes_hoy; ?></h3>
      </div></center>
        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-user" aria-hidden="true"></span></h2>
<h4><?php echo $lang[355]; ?></h4>
<h3><?php echo $usuarios_registrados; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span></h2>
<h4><?php echo $lang[356]; ?></h4>
<h3><?php echo $miembros_equipo; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></h2>
<h4><?php echo $lang[357]; ?></h4>
<h3><?php echo $total_logs; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></h2>
<h4><?php echo $lang[358]; ?></h4>
<h3><?php echo $comentarios_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></h2>
<h4><?php echo $lang[359]; ?></h4>
<h3><?php echo $total_publicaciones; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-gift" aria-hidden="true"></span></h2>
<h4><?php echo $lang[360]; ?></h4>
<h3><?php echo $regalos_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></h2>
<h4><?php echo $lang[361]; ?></h4>
<h3><?php echo $mensajes_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></h2>
<h4><?php echo $lang[362]; ?></h4>
<h3><?php echo $imagenes_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-flag" aria-hidden="true"></span></h2>
<h4><?php echo $lang[363]; ?></h4>
<h3><?php echo $reportes_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-certificate" aria-hidden="true"></span></h2>
<h4><?php echo $lang[364]; ?></h4>
<h3><?php echo $furnis_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></h2>
<h4><?php echo $lang[365]; ?></h4>
<h3><?php echo $tienda_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></h2>
<h4><?php echo $lang[366]; ?></h4>
<h3><?php echo $logs_visitantes; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></h2>
<h4><?php echo $lang[367]; ?></h4>
<h3><?php echo $baneos_total; ?></h3>
      </div></center>

        </div>

        <div class="col-xs-6 col-sm-3">
          <center><div class="well">
<h2><span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span></h2>
<h4><?php echo $lang[368]; ?></h4>
<h3><?php echo $total; ?></h3>
      </div></center>

        </div>

        </div>

      </div>

			</div>
          </div>

		</div>
      </div> <!-- /container -->

<?php 

include "../Templates/Footer.php";

?>