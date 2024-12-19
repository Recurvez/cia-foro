<?php 
require('../../global.php');

// Obtener el rango y dev del usuario que está realizando la acción
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        break;
    }

    // Si 'dev != 1' y el rango no está permitido, redirigir
    if ($rangouser >= 1 && $rangouser <= 9) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el destinatario del correo que se va a eliminar
    $consulta_email = "SELECT destinatario FROM emails_pendientes WHERE id='$id'";
    $resultado = $link->query($consulta_email);
    $correo_eliminado = $resultado->fetch_assoc()['destinatario'];

    // Eliminar el correo de la tabla emails_pendientes
    $consulta = <<<SQL
    DELETE FROM emails_pendientes
    WHERE id='$id'
    LIMIT 1
    SQL;
    $link->query($consulta);

    // Guardar acción en logs
    $fecha_log = date('Y-m-d H:i:s');
    $accion = "Ha eliminado el correo enviado a $correo_eliminado";
    $enviar_log = "INSERT INTO logs (usuario,accion,fecha) VALUES ('$username','$accion','$fecha_log')";
    $link->query($enviar_log);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
