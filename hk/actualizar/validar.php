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
    if ($rangouser >= 1 && $rangouser <= 8) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el nombre del usuario que se va a validar
    $consulta_usuario = "SELECT username FROM usuarios WHERE id='$id'";
    $resultado = $link->query($consulta_usuario);
    
    // Verificar que el usuario existe
    if ($resultado && $resultado->num_rows > 0) {
        $usuario_validado = $resultado->fetch_assoc()['username'];

        // Actualizar el estado de validación a 1
        $consulta = "UPDATE usuarios SET validacion = 1 WHERE id = '$id'";
        $link->query($consulta);

        // Guardar acción en Logs si se ha iniciado sesión
        $fecha_log = date('Y-m-d H:i:s');
        $accion = "Ha validado al usuario $usuario_validado";
        $enviar_log = "INSERT INTO logs (usuario,accion,fecha) VALUES ('".$username."','".$accion."','".$fecha_log."')";
        $link->query($enviar_log);
        // Log guardado en Base de datos
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>
