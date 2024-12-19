<?php
# conectare la base de datos
require ('../../global.php');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $_REQUEST['search'] : ''; // Captura el término de búsqueda

if ($action == 'ajax') {
    require ('../../hk/pagination.php'); // incluir el archivo de paginación
    // las variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // la cantidad de registros que desea mostrar
    $adjacents  = 4; // brecha entre páginas después de varios adyacentes
    $offset = ($page - 1) * $per_page;

    // Prepara la consulta con el filtro de búsqueda
    $whereClause = !empty($search) ? "WHERE firma LIKE '%$search%' OR usuario LIKE '%$search%'" : "";
    $count_query   = $link->query("SELECT count(*) AS numrows FROM firmas $whereClause");
    
    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php?action=ajax&search=' . urlencode($search); // Mantén la búsqueda en el reload

    
    // consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM firmas $whereClause ORDER BY firma ASC LIMIT $offset, $per_page");
    
    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover" style="user-select:text;">
            <thead>
                <tr>
                    <th><?php echo $lang[27]; ?></th>
                    <th><?php echo'Firma'; ?></th>
                    <th><?php echo $lang[140]; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {

                ?>
                <tr>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['firma']; ?></td>
                    <td><a href="eliminar/tags-all.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-sm btn-danger"><span class="MPicon-cross"></span></button></a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div class="table-pagination pull-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $lang[195]; ?>
        </div>
        <?php
    }
}
?>
