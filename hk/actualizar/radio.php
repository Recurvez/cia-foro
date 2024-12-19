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

$nombre_radio = $_POST['nombre_radio'];
$radio_op = $_POST['radio_op'];
$radio = $_POST['radio'];
$id = '1';

$consulta = "UPDATE config SET radio_op='$radio_op', radio='$radio', nombre_radio='$nombre_radio' WHERE id='".$id."'";
$resultado = $link->query($consulta);

// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date('Y-m-d H:i:s');
$accion = "Ha editado la radio";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos

header("Location: ../radio.php");

?>