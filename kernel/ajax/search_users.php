<?php
require ('../../global.php'); // Conectar a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['username']) && $_REQUEST['username'] != NULL) ? $link->real_escape_string($_REQUEST['username']) : ''; // Captura y filtra el término de búsqueda

if ($action == 'ajax') {
    // Variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // Número de registros a mostrar
    $offset = ($page - 1) * $per_page;

    // Prepara la consulta con el filtro de búsqueda
    $whereClause = !empty($search) ? "WHERE username LIKE '%$search%' AND rank <= 12" : "WHERE rank <= 12";

    $count_query = $link->query("SELECT count(*) AS numrows FROM usuarios $whereClause");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php'; // Cambiar esto a la página correcta para la paginación

    // Consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM usuarios $whereClause ORDER BY id DESC LIMIT $offset, $per_page");

    if ($numrows > 0) {
        ?>
        <ul style="list-style-type: none; padding: 0; margin: 0;">
        <?php
        while ($row = mysqli_fetch_array($query)) {
            ?>
            <li style="cursor: pointer;" onclick="selectUser ('<?php echo $row['username']; ?>')">
                <?php echo $row['username']; ?> (<?php echo $row['rank']; ?>)
            </li>
            <?php
        }
        ?>
        </ul>
        <div class="table-pagination pull-right">
            <?php echo paginate($reload, $page, $total_pages, 4); // Ajustar según sea necesario ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            No se encontraron usuarios.
        </div>
        <?php
    }
}
?>