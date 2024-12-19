<?php require('../../global.php');
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

$vaciar= "TRUNCATE TABLE logs_sospechosos";

$link->query($vaciar);

// Guardar acción en Logs si se ha iniciado sesión

$fecha_log = date('Y-m-d H:i:s');
$accion = "Ha reiniciado los Logs sospechosos";
$enviar_log = "INSERT INTO logs_sospechosos (user_logeado,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
	
header("Location: " . $_SERVER['HTTP_REFERER']);


?>