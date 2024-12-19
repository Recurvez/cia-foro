<?php
require ('../../global.php'); // Conectar a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['username']) && $_REQUEST['username'] != NULL) ? $link->real_escape_string($_REQUEST['username']) : ''; // Captura y filtra el término de búsqueda

if ($action == 'ajax') {
    // Prepara la consulta con el filtro de búsqueda
    $whereClause = !empty($search) ? "WHERE username LIKE '%$search%' AND rank <= 12" : "WHERE rank <= 12";

    $query = $link->query("SELECT username FROM usuarios $whereClause LIMIT 10");
    $users = [];

    while ($row = mysqli_fetch_array($query)) {
        $users[] = $row; // Agregar cada usuario al array
    }

    echo json_encode($users); // Devolver los resultados en formato JSON
}
?>