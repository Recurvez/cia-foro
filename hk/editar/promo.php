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
              <h3 class="panel-title">Editar Promo</h3>
            </div>
            <div class="panel-body">

              <?php
$id = $_GET['id'];
$consulta =<<<SQL
SELECT *
FROM
banner WHERE id = '$id'
LIMIT 1
SQL;
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
?>
<div class="formulariohk">
              <form method="post" action="../actualizar/promo.php">
			  <input type="hidden" name="id" value="<?php echo $columnas['id']; ?>"/>

              <label>Titulo</label>
             <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="titulo" placeholder="El titulo de tu promo" value="<?php echo $columnas['titulo']; ?>" />  <br>

              <label>Imagen URL</label>
              <input style="margin-bottom: 10px;" type="text" class="form-control" name="imagen" placeholder="La imagen URL" required="" value="<?php echo $columnas['imagen']; ?>" />  <br>
			  
              <label>URL de boton</label>
              <input style="margin-bottom: 10px;" type="text" class="form-control" name="url_promo" placeholder="URL de noticia o evento" required="" value="<?php echo $columnas['url_promo']; ?>" />  <br>
			  
			  <label>¿Quieres colocar esta promo como principal?</label><br>
                    <select width="100px" name="principal">
                    <option value="<?php echo $columnas['principal']; ?>"><?php echo $columnas['principal']; ?></option>
					<option value="active">Si</option>
                    <option value="No">No</option>
                </select><br><br>
			  
			  <label>Texto</label>
              <textarea name="texto" style="margin:10px;" cols="80" required="" rows="10" class="form-control"><?php echo $columnas['texto']; ?></textarea>  <br>
					
                    <center><input class="btn btn-primary" type="submit" value="Guardar" style="width: 120px;" /></center>
                      </form>
</div></div>
			</div>
          </div>

		</div>
      </div><!-- /container -->
<?php 

include "../../Templates/Hk_Footer_2.php";

?>
