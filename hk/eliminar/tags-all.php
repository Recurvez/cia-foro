<?php require('../../global.php');

$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        // El usuario con dev == 1 tiene acceso
        break; 
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 12) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

if (isset($_GET['id'])){
    $id = $_GET['id'];

    // Ejecutar la consulta para eliminar
    $consulta = "DELETE FROM firmas WHERE id='$id' LIMIT 1";
    $link->query($consulta); // Ejecutar la consulta DELETE

    // Obtener los datos de usuario y firma
    $consulta_firma = $link->query("SELECT usuario, firma FROM firmas WHERE id='$id' LIMIT 1");

        $user_correcto = $row['usuario'];
        $firma = $row_firma['firma'];

        // Guardar acción en Logs
        $fecha_log = date('Y-m-d H:i:s');
        $accion = "Ha eliminado a $user_correcto con firma $firma de la lista de firmas [Generales]";
        $enviar_log = "INSERT INTO logs (usuario, accion, fecha) VALUES ('".$username."', '".$accion."', '".$fecha_log."')";
        $link->query($enviar_log); // Log guardado en base de datos

}

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'default_page.php';
header("Location: " . $referer);
exit;
?>
