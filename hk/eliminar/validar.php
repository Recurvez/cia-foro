<?php 
require('../../global.php');

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
    if ($rangouser >= 1 && $rangouser <= 8) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el nombre del usuario que se va a eliminar
    $consulta_usuario = "SELECT username FROM usuarios WHERE id='$id'";
    $resultado = $link->query($consulta_usuario);
    $usuario_eliminado = $resultado->fetch_assoc()['username'];

    // Eliminar el usuario
    $consulta = <<<SQL
    DELETE FROM usuarios
    WHERE id='$id'
    LIMIT 1
    SQL;
    $link->query($consulta);

    // Guardar acción en Logs si se ha iniciado sesión
    $fecha_log = date('Y-m-d H:i:s');
    $accion = "Ha eliminado al usuario $usuario_eliminado";
    $enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
    $link->query($enviar_log);
    // Log guardado en Base de datos
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
