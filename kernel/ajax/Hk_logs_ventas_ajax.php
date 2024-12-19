<?php
# Conectar la base de datos
require ('../../global.php');

// Obtener el rango y dev del usuario actual
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
$row = mysqli_fetch_array($query);
$rangouser = $row['rank'];
$dev = $row['dev'];

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $_REQUEST['search'] : '';

if ($action == 'ajax') {
    require ('../../hk/pagination.php');
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10;
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;

    $whereClause = !empty($search) ? "WHERE accion LIKE '%$search%'" : "";
    $count_query = $link->query("SELECT count(*) AS numrows FROM logs_ventas $whereClause");

    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php';
    
    $query = $link->query("SELECT * FROM logs_ventas $whereClause ORDER BY id DESC LIMIT $offset, $per_page");

    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><?php echo $lang[27]; ?></th>
                    <th><?php echo $lang[140]; ?></th>
                    <th><?php echo $lang[415]; ?></th>
                    <?php if ($rangouser == 12 || $dev == 1) : ?>
                        <th>Pagado</th>
                        <th>Actualizar</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $fechaAccion = new DateTime($row['fecha']);
                $fechaActual = new DateTime();
                $diferencia = $fechaActual->diff($fechaAccion);
                $segundosTranscurridos = $fechaActual->getTimestamp() - $fechaAccion->getTimestamp();

                if ($segundosTranscurridos < 60) {
                    $diferenciaTexto = "Recientemente";
                } else {
                    $diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos";
                }

                // Estado de pago
                $estadoPagada = '';
                switch ($row['pagada']) {
                    case 1:
                        $estadoPagada = "Sí";
                        break;
                    case 0:
                    default:
                        $estadoPagada = "No";
                        break;
                }
                ?>
                <tr>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['accion']; ?></td>
                    <td><?php echo $diferenciaTexto; ?></td>
                    <?php if ($rangouser == 12 || $dev == 1) : ?>
                        <td><?php echo $estadoPagada; ?></td>
                        <td>
                            <a href="../../hk/actualizar/venta_paga.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                &#10004;
                            </a>
                        </td>
                    <?php endif; ?>
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
