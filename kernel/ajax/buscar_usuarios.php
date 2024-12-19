<?php
# Conectarse a la base de datos
require ('../../global.php');

$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $link->real_escape_string($_REQUEST['search']) : ''; // Captura y filtra el término de búsqueda

if (!empty($search)) {
    // Prepara la consulta con el filtro de búsqueda
    $query = $link->query("SELECT username FROM usuarios WHERE username LIKE '%$search%' AND rank <= 12 ORDER BY username ASC LIMIT 10");

    $result = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row['username']; // Agregar cada nombre de usuario al array
    }

    // Devolver los resultados en formato JSON
    echo json_encode($result);
}
?>
