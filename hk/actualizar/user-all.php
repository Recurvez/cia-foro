<?php 
require ('../../global.php');

$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        break;
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 8) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit;
    }
}

// Obtener los datos enviados desde el formulario
$user_edit = strip_tags($_POST['user_edit']);
$newusername = strip_tags($_POST['newusername']);
$tag = strip_tags($_POST['tag']);
$newtag = strip_tags($_POST['newtag']);
$id = strip_tags($_POST['id']);

// Verificar si el nuevo nombre de usuario ya existe en la base de datos
$verificar_usuario = $link->query("SELECT * FROM usuarios WHERE username = '$newusername' AND id != '$id'");
$verificar_tag = $link->query("SELECT * FROM usuarios WHERE TAG = '$newtag' AND id != '$id'");

if ($verificar_usuario->num_rows > 0 || $verificar_tag->num_rows > 0) {
    // Si ya existe, redirigimos con un mensaje de error
    header("Location: ../users.php?error=usuario_existente");
    exit;
} else {
    // Si no existe, procedemos con la actualización
    $consulta = "UPDATE usuarios SET username='$newusername', tag='$newtag', avatar='https://www.habbo.es/habbo-imaging/avatarimage?size=m&direction=2&head_direction=2&user={$newusername}' WHERE id = '$id'";
    $resultado = $link->query($consulta);

    // Guardar acción en Logs si se ha iniciado sesión
    $fecha_log = date('Y-m-d H:i:s');
    $accion = "Ha editado los datos del usuario $user_edit a $newusername con TAG $tag a $newtag";
    $enviar_log = "INSERT INTO logs (usuario, accion, fecha) values ('".$username."', '".$accion."', '".$fecha_log."')";
    $link->query($enviar_log);

    // Redirigir después de la actualización
    header("Location: ../users-all.php?success=actualizado");
    exit;
}
?>
