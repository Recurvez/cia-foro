<?php
require ('../../global.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Obtener el tiempo actual de inicio y el tiempo acumulado
    $stmt = $link->prepare("SELECT time_pbl, time_acumulado FROM usuarios WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $start_time = $row['time_pbl'];
    $time_acumulado = $row['time_acumulado'];

    // Calcular el tiempo transcurrido desde el inicio hasta el momento actual
    $tiempo_transcurrido = strtotime(date('Y-m-d H:i:s')) - strtotime($start_time);
    $nuevo_tiempo_acumulado = $time_acumulado + $tiempo_transcurrido;

    // Detener el tiempo y actualizar los valores en la base de datos
    $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 0, time_acumulado = ?, pbl_paused = 0 WHERE ID = ?");
    $stmt->bind_param('ii', $nuevo_tiempo_acumulado, $id);
    $stmt->execute();

    // Registrar la acción en los logs
    $encargado_pbl = $username;
    $accion = "El usuario $encargado_pbl ha detenido el tiempo para el usuario con ID $id.";
    $fecha_log = date('Y-m-d H:i:s');
    $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $encargado_pbl, $accion, $fecha_log);
    $stmt->execute();

    header("Location: ../times.php?success=tiempo_detenido");
    exit;
}
?>
