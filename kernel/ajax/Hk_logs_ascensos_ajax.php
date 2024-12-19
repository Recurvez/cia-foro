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
    $whereClause = !empty($search) ? "WHERE accion LIKE '%$search%'" : "";
    $count_query   = $link->query("SELECT count(*) AS numrows FROM logs_ascensos $whereClause");
    
    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php';
    
    // consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM logs_ascensos $whereClause ORDER BY id DESC LIMIT $offset, $per_page");
    
    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><?php echo $lang[27]; ?></th>
                    <th><?php echo $lang[140]; ?></th>
                    <th><?php echo $lang[415]; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                // Convertir la fecha almacenada a un formato legible
                $fechaAccion = new DateTime($row['fecha']); // Asumiendo que 'fecha' es el nombre del campo
                $fechaActual = new DateTime();
                $diferencia = $fechaActual->diff($fechaAccion);

                // Calcular los segundos transcurridos desde la fecha de acción
                $segundosTranscurridos = $fechaActual->getTimestamp() - $fechaAccion->getTimestamp();

                // Definir el texto de diferencia de tiempo
                if ($segundosTranscurridos < 60) {
                    $diferenciaTexto = "Recientemente";
                } else {
                    $diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos";
                }
                ?>
                <tr>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['accion']; ?></td>
                    <td><?php echo $diferenciaTexto; ?></td> <!-- Aquí se muestra la diferencia en lugar de la fecha -->
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
