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
              <h3 class="panel-title"><?php echo $lang[402]; ?></h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                          <thead>
                            <tr>
                              <th><?php echo $lang[312]; ?></th>
                              <th><?php echo $lang[123]; ?></th>
                              <th><?php echo $lang[403]; ?></th>
                              <th><?php echo $lang[140]; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                      
                      $resultado = $link->query("SELECT * FROM secciones_furnis ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                            <tr>
                              <td><?php echo "$row[id]"; ?></td>
                              <td><?php echo "$row[nombre]"; ?></td>
                              <td><?php echo "$row[url_seccion]"; ?></td>
                              <td><a href="editar/catalogo_secciones.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-success"><span class="MPicon-pencil"></span></button></a></td>
                            </tr>
                            <?php
                          }
                            ?>
                          </tbody>
                        </table>

			</div>
          </div>
      </div><!-- /container -->
</div>

<?php 

include "../Templates/Footer.php";

?>
