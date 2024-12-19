<?php 
require ('../../global.php');
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

$nameweb = $_POST['nameweb'];
$url = $_POST['url'];
$pclaves = $_POST['pclaves'];
$descripcion = $_POST['descripcion'];
$logo = $_POST['logo'];
$facebook = $_POST['facebook'];
$facebookimg = nl2br($_POST['facebookimg']);
$id = '1';

$consulta = "UPDATE config SET nameweb='$nameweb', url='$url', pclaves='$pclaves', descripcion='$descripcion', logo='$logo', facebook='$facebook', facebookimg='$facebookimg' WHERE id='$id'";
$resultado = $link->query($consulta);

// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date('Y-m-d H:i:s');
$accion = "Ha actualizado la configuración de la web";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos

header("Location: ../configuracion.php");

?>