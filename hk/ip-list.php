<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, dev, TAG FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $tag = $row['TAG'];

    // Permitir acceso si el usuario tiene 'dev == 1 o es un usuario de confianza'
    if ($username=='TheDantelp' || $username=='novalboschu:' || $username=='CARDARK50' || $dev == 1) {
        break;
    }

    if ($rangouser >= 1 && $rangouser < 13) {
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<!-- Enlaces a CSS de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="row">
        <!-- Primera tabla: Listado de Usuarios e IPs -->
        <div class="panel panel-default">
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Listado de Usuarios e IPs'; ?></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable">
                    <thead>
                        <tr>
                            <th><?php echo 'Usuario'; ?></th>
                            <th><?php echo 'IP'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT username, ip FROM usuarios WHERE rank >= 1 AND rank <= 11 ORDER BY username ASC");
                        while ($row = mysqli_fetch_array($resultado)) {
                        ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['ip']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Segunda tabla: Usuarios con IPs duplicadas -->
        <div class="panel panel-default">
            <div class="panel-heading red" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Usuarios con IPs Duplicadas'; ?></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="duplicateIpsTable">
                    <thead>
                        <tr>
                            <th><?php echo 'IP'; ?></th>
                            <th><?php echo 'Usuarios'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta para encontrar IPs duplicadas
                        $duplicates = $link->query("
                            SELECT ip, GROUP_CONCAT(username SEPARATOR ', ') AS usuarios
                            FROM usuarios
                            GROUP BY ip
                            HAVING COUNT(*) > 1 and IP != ''
                        ");

                        while ($row = mysqli_fetch_array($duplicates)) {
                        ?>
                        <tr>
                            <td><?php echo $row['ip']; ?></td>
                            <td><?php echo $row['usuarios']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTables
    $('#userTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
        }
    });

    $('#duplicateIpsTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        }
    });
});
</script>

<?php include "../Templates/Footer.php"; ?>
