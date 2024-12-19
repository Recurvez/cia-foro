<?php
require ('../../global.php'); // Asegúrate de que esto esté correctamente configurado para conectar con tu base de datos

// Obtener el contenido JSON de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $item) {
        $id = intval($item['id']); // Asegúrate de que el ID sea un entero
        $pagada = intval($item['pagada']); // 1 o 0 dependiendo del estado del checkbox

        // Asegúrate de que el ID sea válido
        if ($id > 0) {
            // Actualiza la base de datos
            $sql = "UPDATE logs_ventas SET pagada = $pagada WHERE id = $id";
            $link->query($sql);
        }
    }
    // Respuesta exitosa
    http_response_code(200);
} else {
    // Respuesta de error
    http_response_code(400);
}
?>
