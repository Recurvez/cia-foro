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
              <h3 class="panel-title">Editar Noticia</h3>
            </div>
            <div class="panel-body">

              <?php
$id = $_GET['noticia'];
$consulta =<<<SQL
SELECT *
FROM
noticias WHERE id = '$id'
LIMIT 1
SQL;
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
?>
<div class="formulariohk">
              <form method="post" action="../actualizar/noticia.php">
			  <input type="hidden" name="id" value="<?php echo $columnas['id']; ?>"/>

              <label>Titulo de Noticia</label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="titulo" placeholder="Titulo de la Noticia" value="<?php echo $columnas['titulo']; ?>" />  <br>

                     <label>Resumen</label>
                    <input style="margin-bottom: 10px;" type="text" class="form-control" name="resumen" placeholder="Resumen de la Noticia" required="" value="<?php echo $columnas['resumen']; ?>" />  <br>

                    <label>Categoria</label><br>
                    <select  required="" name="categoria">
                    <option value="<?php echo $columnas['categoria']; ?>" selected><?php echo $columnas['categoria']; ?></option>
                    <option value="Actualización">Actualización</option>
                    <option value="Proximamente">Proximamente</option>
                    <option value="Proximamente">Noticia</option>
                    </select><br><br>

                    <label>Fecha</label>
                    <input style="margin-bottom: 10px; width:200px;" type="date" required="" class="form-control" name="fecha" placeholder="Fecha" value="<?php echo $columnas['fecha']; ?>" />  <br>

                    <label>Imagen URL</label>
                    <input style="margin-bottom: 10px;" type="text" required="" class="form-control" name="imagen" placeholder="Inserta la URL de la imagen" value="<?php echo $columnas['imagen']; ?>" />  <br>

                     <label>Noticia</label>
                        <textarea name="noticia" style="margin:10px;" cols="80" required="" rows="10" id='edit'><?php echo $columnas['noticia']; ?></textarea>  <br>

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