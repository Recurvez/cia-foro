<?php
# Conectarse a la base de datos
require ('../../global.php');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $link->real_escape_string($_REQUEST['search']) : ''; // Captura y filtra el término de búsqueda

if ($action == 'ajax') {
    require ('../../hk/pagination.php'); // Incluir el archivo de paginación

    // Variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // Número de registros a mostrar
    $adjacents = 4; // Brecha entre páginas después de varios adyacentes
    $offset = ($page - 1) * $per_page;

    // Prepara la consulta con el filtro de búsqueda
    $whereClause = !empty($search) ? "WHERE username LIKE '%$search%' AND rank <= 8" : "WHERE rank <= 8";

    $count_query   = $link->query("SELECT count(*) AS numrows FROM usuarios $whereClause");

    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php';

    // Consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM usuarios $whereClause ORDER BY id DESC LIMIT $offset, $per_page");

    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover " style="user-select:text;">
            <thead>
                <tr>
                    <th><?php echo $lang[27]; ?></th>
                    <th><?php echo $lang[122]; ?></th>
                    <th><?php echo $lang[415]; ?></th>
                    <th>Trabajador de la Semana</th> <!-- Nueva columna -->
                    <th><?php echo $lang[140]; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo "$row[username]"; ?></td>
                    <td>
                        <?php
                        switch ($row['rank']) {
                            case 2:
                                echo "SEG";
                                break;
                            case 3:
                                echo "ENT";
                                break;
                            case 4:
                                echo "LOG";
                                break;
                            case 5:
                                echo "SUP";
                                break;
                            case 6:
                                echo "DIR";
                                break;
                            case 7:
                                echo "PRE";
                                break;
                            case 8:
                                echo "OP";
                                break;
                        }
                        ?>
                    </td>
                    <td><?php echo "$row[fecha]"; ?></td>
                    <td><?php echo $row['week_worker'] ? 'Sí' : 'No'; ?></td> <!-- Muestra si el usuario es "Trabajador de la Semana" -->
                    <td><a href="editar/user.php?id=<?php echo "$row[ID]"; ?>"><button type="button" class="btn btn-sm btn-success"><span class="MPicon-pencil"></span></button></a></td>
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
