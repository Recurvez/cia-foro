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
    if ($rangouser >= 1 && $rangouser <= 4) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

include "../Templates/Hk_Nav.php";
?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">
        <div class="col-md-8">

          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[284]; ?> <?php echo "$username"; ?></h3>
            </div>
            <div class="panel-body">

<div style="padding:10px;"><?php echo $lang[285]; ?> <?php echo "$nameweb"; ?> <?php echo $lang[286]; ?><br><br> <?php echo $lang[287]; ?><br><br> <?php echo $lang[288]; ?><br><br><div style="text-align: center;"><img src="https://2.bp.blogspot.com/-9zGo8-BLSpM/Upu538pdggI/AAAAAAAAE9o/qD8kMCeHjOc/s1600/habs.gif"></div></div>

			<div class="eventotext">



			</div>

            </div>
          </div>

		</div>
        <div class="col-md-4">
        

<?php echo $cartel_publicidad; ?>

		</div>
      </div>

    </div> <!-- /container -->

<?php 

include "../Templates/Footer.php";

?>
