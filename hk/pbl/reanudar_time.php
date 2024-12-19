<?php
require ('../../global.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Obtener el tiempo acumulado
    $stmt = $link->prepare("SELECT time_acumulado FROM usuarios WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $time_acumulado = $row['time_acumulado'];

    // Reanudar el tiempo actualizando el tiempo de inicio a la hora actual
    $start_time = date('Y-m-d H:i:s');
    $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 1, time_pbl = ?, pbl_paused = 0 WHERE ID = ?");
    $stmt->bind_param('si', $start_time, $id);
    $stmt->execute();

    // Registrar la acción en los logs
    $encargado_pbl = $username;
    $accion = "El usuario $encargado_pbl ha reanudado el tiempo para el usuario con ID $id.";
    $fecha_log = date('Y-m-d H:i:s');
    $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $encargado_pbl, $accion, $fecha_log);
    $stmt->execute();

    header("Location: ../times.php?success=tiempo_reanudado");
    exit;
}
?>
