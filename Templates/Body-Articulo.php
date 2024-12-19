	  <div class="container">
<?php 
$consulta = "SELECT * FROM usuarios WHERE username = '".$username."' LIMIT 1";
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);
  $avatar = $columnas['avatar'];

$id = $_GET['id'];
$consulta = "SELECT *FROM noticias WHERE id = '".$id."' LIMIT 1";
 $filas1 = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas1);

  $noticia_id = $columnas['id'];


  $verificacion = mysqli_num_rows($filas1);

  if ($verificacion == 0) {

    echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[203]</div>";

    echo "<center><div><img style='margin:25px;' src='https://cdn.habtium.com/album/3/Galeria_Habbo/Frank/register4.gif'></div></center></div>";
    include "Templates/Footer.php";
    exit();
  }

?>
     <div class="row">
        <div class="col-md-8">

			<div class="datos-articulo"><span><?php echo $lang[34]; ?>: <?php echo "$columnas[fecha]"; ?> <span style="margin-left:15px;"><?php echo $lang[35]; ?>: <?php echo "$columnas[categoria]"; ?><span style="margin-left:15px;"><?php echo $lang[36]; ?>: <?php echo "$columnas[autor]"; ?></span></span></span></div>
			<br><br>
			<div id="likes"></div>
			<?php
if($_SESSION["logeado"] == "SI"){
?>
    <div style="position: relative;bottom: -20px;height: 50px;max-height: 50px;overflow: hidden;">
        <div style="width: 100%;height: 25px;">
        <form class="form-horizontal" action="articulo.php?id=<?php echo $columnas['id']; ?>#likes" method="post" enctype="multipart/form-data">
            <button type="submit" name="megusta" class="btn btn-primary" style="float:left;font-size: 15px;"><i style="font-size: 15px;" class="material-icons">thumb_up</i> <?php echo $columnas['megusta']; ?></button>
            </form>
        <form class="form-horizontal" action="articulo.php?id=<?php echo $columnas['id']; ?>#likes" method="post" enctype="multipart/form-data">
            <button type="submit" name="no_megusta" class="btn btn-danger" style="margin-left:18px;float:left;font-size: 15px;"><i style="font-size: 15px;" class="material-icons">thumb_down</i> <?php echo $columnas['no_megusta']; ?></button>
            </form>
        </div>
			</div>
          <?php

          $id_noticia = $columnas['id'];

if (isset($_POST['megusta'])) {

	$tipo = 'megusta';

$consulta = $link->query("SELECT * FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = '$tipo')");
$resultados = mysqli_num_rows($consulta);

$consulta1 = $link->query("SELECT * FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = 'no_megusta')");
$resultados1 = mysqli_num_rows($consulta1);

if ($resultados1 != 0) {


$resultado = $link->query("SELECT * FROM noticias WHERE id = '$id_noticia'");
while ($row = mysqli_fetch_array($resultado)) {
	$no_megusta = $row['no_megusta'];
}

$aumento = $no_megusta - 1;
$actualizar = "UPDATE noticias SET no_megusta ='$aumento' WHERE id = '$id_noticia'";
$link->query($actualizar);

$eliminar = "DELETE FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = 'no_megusta')";
$link->query($eliminar);

	}

if ($resultados == 0) {

$resultado = $link->query("SELECT * FROM noticias WHERE id = '$id_noticia'");
while ($row = mysqli_fetch_array($resultado)) {
	$megusta = $row['megusta'];
}

$aumento = $megusta + 1;
$actualizar = "UPDATE noticias SET megusta ='$aumento' WHERE id = '$id_noticia'";
$link->query($actualizar);

$enviar_voto = "INSERT INTO votos (username,tipo,noticia_id) values ('".$username."','".$tipo."','".$id_noticia."')";
$link->query($enviar_voto);

echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[204]</div>";
} else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[205]</div>";
}
			}

if (isset($_POST['no_megusta'])) {

	$tipo = 'no_megusta';

$consulta = $link->query("SELECT * FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = '$tipo')");
$resultados = mysqli_num_rows($consulta);

$consulta1 = $link->query("SELECT * FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = 'megusta')");
$resultados1 = mysqli_num_rows($consulta1);

if ($resultados1 != 0) {


$resultado = $link->query("SELECT * FROM noticias WHERE id = '$id_noticia'");
while ($row = mysqli_fetch_array($resultado)) {
	$megusta = $row['megusta'];
}

$aumento = $megusta - 1;
$actualizar = "UPDATE noticias SET megusta ='$aumento' WHERE id = '$id_noticia'";
$link->query($actualizar);

$eliminar = "DELETE FROM votos WHERE (username = '$username') AND (noticia_id = '$id_noticia') AND (tipo = 'megusta')";
$link->query($eliminar);

	}

if ($resultados == 0) {

$resultado = $link->query("SELECT * FROM noticias WHERE id = '$id_noticia'");
while ($row = mysqli_fetch_array($resultado)) {
	$megusta = $row['no_megusta'];
}

$aumento = $megusta + 1;
$actualizar = "UPDATE noticias SET no_megusta ='$aumento' WHERE id = '$id_noticia'";
$link->query($actualizar);

$enviar_voto = "INSERT INTO votos (username,tipo,noticia_id) values ('".$username."','".$tipo."','".$id_noticia."')";
$link->query($enviar_voto);

echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[206]</div>";
} else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[207]</div>";
}
			}

			 } else { ?> 

    <div style="position: relative;bottom: -20px;height: 50px;max-height: 50px;overflow: hidden;">
        <div style="width: 100%;height: 25px;">
            <div style="float:left;font-size: 20px;opacity: 0.5;"><i style="font-size: 20px;" class="material-icons">thumb_up</i> <?php echo $columnas['megusta']; ?></div>
            <div style="margin-left:18px;float:left;font-size: 20px;opacity: 0.5;"><i style="font-size: 20px;" class="material-icons">thumb_down</i> <?php echo $columnas['no_megusta']; ?></div>
        </div>
			</div>

			<?php } ?><br>

	<div class="panel panel-default">
            <div class="panel-heading orange">
              <h3 class="panel-title"><div class='contedor-badge' style="background-image:url(&quot;https://www.habbo.es/habbo-imaging/badge/b08134s43011s78115s86114s80113ccf79940fb6c1d4e3d9e9ac11ae7fb19.gif&quot;);background-repeat:no-repeat;"><div class='icon-news'></div></div> <?php echo $columnas['titulo']; ?></h3>
            </div>
            <div class="panel-body">

			<div class="eventotext">

			<p><?php echo $columnas['noticia']; ?></p>
<br>

</div></div></div>

     <div class="panel panel-default">
            <div class="panel-heading blue">
              <h3 class="panel-title"><div class='contedor-badge' style="background-image:url('https://images.habbo.com/c_images/album1584/DE720.png'); background-repeat: no-repeat;"><div class='icon-comentarios'></div></div> <?php echo $lang[208]; ?></h3>
            </div>
            <div class="panel-body">
				<ul id="comments-list" class="comments-list">
			<?php
if($_SESSION["logeado"] == "SI"){
?>
				<li>
				   <div class="comment-main-level">
					<!-- Avatar -->
					<div class="comment-avatar" style="width:auto; border:0px; border-radius:0px;box-shadow:none;"><img src="<?php echo "$avatar";?>" alt=""></div>
					<!-- Contenedor del Comentario -->
					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><?php echo $lang[209]; ?></h6>
							<span></span>
						</div>
						<div class="comment-content">
						<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="noticia_id" value="<?php echo $columnas['id'];?>"/>
						<input type="hidden" name="avatar" value="<?php echo "$avatar";?>"/>
						<input type="hidden" name="username" value="<?php echo "$username";?>"/>
							<textarea name="comentario" style="padding: 10px;max-height:200px;margin: 0px;border-radius: 0px;border: #dacfcf solid 1px;height: 167px;" placeholder="<?php echo $lang[211]; ?>" required="" rows="10" class="form-control"></textarea>
							<input class="btn btn-primary" name="enviar" type="submit" value="<?php echo $lang[210]; ?>" style="margin: 15px 0px 0px 0px;width: 120px;" /></form>
						</div>
					</div>
				</div>
			</li>

<?php
$postnoticia_id = $_POST['noticia_id'];
$postusername = $_POST['username'];

if ("$noticia_id" == "$postnoticia_id") {
if ("$username" == "$postusername") {
  $htmlremplazar1 = strip_tags($_POST['comentario']);
if ($_POST['enviar'] && $_POST['noticia_id']) {
$enviar = "INSERT INTO comentarios (username,noticia_id,avatar,comentario) values ('".$_POST['username']."','".$_POST['noticia_id']."','".$_POST['avatar']."','".$htmlremplazar1."')";

if ($link->query($enviar)) { 
// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date("Y-m-d");
$accion = "Ha comentado en la noticia id: $noticia_id";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$resultado_log = $link->query($enviar_log);
// Log guardado en Base de datos
header ("Location: ../articulo.php?id=$noticia_id"); }
}}}} else {
	echo '<div style="margin: 10px;position:relative;">

	<div class="alert alert-warning">
	<strong>'.$lang[212].'</strong>
        <p>'.$lang[213].'. <a href="login">'.$lang[24].'</a> o <a href="registro">'.$lang[48].'</a></p>
      </div>

	</div>';
}
?>

<?php
  $query = $link->query('SELECT * FROM comentarios WHERE noticia_id = "'.$noticia_id.'" ORDER BY id DESC limit 5');
  while($row = mysqli_fetch_array($query))
  {
  ?>
			<li>
				<div class="comment-main-level">
					<!-- Avatar -->
					<div class="comment-avatar" style="width:auto; border:0px; border-radius:0px;box-shadow:none;"><a href="perfil.php?user=<?php echo $row['username'];?>"><img src="<?php echo $row['avatar'];?>" alt=""></a></div>
					<!-- Contenedor del Comentario -->
					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="perfil.php?user=<?php echo $row['username'];?>"><?php echo $row['username'];?></a></h6>
							<span></span>
						</div>
						<div class="comment-content">
<?php
$htmlremplazar = $row['comentario'];
echo strip_tags($htmlremplazar);?>
						</div>
					</div>
				</div>
			</li>
<?php
}
?>
		      </ul>
            </div>
          </div>

		</div>
      <div class="col-md-4">

	  <?php echo $cartel_radio; ?>

<?php echo $redes_sociales; ?>

<?php echo $cartel_publicidad; ?>

		</div>
      </div>

    </div> <!-- /container -->
