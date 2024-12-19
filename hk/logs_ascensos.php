<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, dev, TAG FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $tag = $row['TAG'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        break;
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 7) {
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<!-- Agregar enlaces para CSS y JavaScript de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Registro de Ascensos'; ?></h3>
        </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable"> <!-- Agregar clases Bootstrap -->

            <?php if ($rangouser > 12 || $dev == 1) { ?> 
                <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                    <a href="eliminar/logs_ascensos.php">
                        <button type="button" class="btn btn-sm btn-danger"><?php echo $lang[346]; ?></button>
                    </a>
                </div>
            <?php } ?>

                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th><?php echo $lang[140]; ?></th>
                            <th><?php echo $lang[415]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM logs_ascensos $whereClause ORDER BY fecha DESC");
                        while ($row = mysqli_fetch_array($resultado)) {
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
            </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading red" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Registro de Ventas'; ?></h3>
        </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable2"> <!-- Agregar clases Bootstrap -->

                <?php if ($rangouser > 12 || $dev == 1) { ?> 
                <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                    <a href="eliminar/logs_ventas.php">
                        <button type="button" class="btn btn-sm btn-danger"><?php echo $lang[346]; ?></button>
                    </a>
                </div>
            <?php } ?>

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
                        $resultado = $link->query("SELECT * FROM logs_ventas $whereClause ORDER BY fecha DESC");
                        while ($row = mysqli_fetch_array($resultado)) {
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
                            <td><?php echo $diferenciaTexto; ?></td> <!-- Aquí se muestra la diferencia en lugar de la fecha -->
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
            </div>
        </div>

    </div>
</div>

<!-- Agregar scripts de DataTables y activar DataTables en la tabla -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
        }
    });

    $('#userInput').on('keyup', function() {
        let search = $(this).val();
        if (search.length > 2) {
            $.ajax({
                url: '../kernel/ajax/buscar_usuarios.php',
                method: 'GET',
                data: { search: search },
                success: function(data) {
                    let suggestions = JSON.parse(data);
                    let suggestionList = $('#suggestions');

                    suggestionList.empty();
                    if (suggestions.length > 0) {
                        suggestions.forEach(function(user) {
                            suggestionList.append('<li class="suggestion-item">' + user + '</li>');
                        });
                        suggestionList.show();
                    } else {
                        suggestionList.hide();
                    }
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });
    
    $(document).on('click', '.suggestion-item', function() {
        $('#userInput').val($(this).text());
        $('#suggestions').hide();
    });
});
</script>

<script>
$(document).ready(function() {
    $('#userTable2').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
        }
    });

    $('#userInput2').on('keyup', function() {
        let search = $(this).val();
        if (search.length > 2) {
            $.ajax({
                url: '../kernel/ajax/buscar_usuarios.php',
                method: 'GET',
                data: { search: search },
                success: function(data) {
                    let suggestions = JSON.parse(data);
                    let suggestionList = $('#suggestions');

                    suggestionList.empty();
                    if (suggestions.length > 0) {
                        suggestions.forEach(function(user) {
                            suggestionList.append('<li class="suggestion-item">' + user + '</li>');
                        });
                        suggestionList.show();
                    } else {
                        suggestionList.hide();
                    }
                }
            });
        } else {
            $('#suggestions').hide();
        }
    });
    
    $(document).on('click', '.suggestion-item', function() {
        $('#userInput').val($(this).text());
        $('#suggestions').hide();
    });
});
</script>

<?php include "../Templates/Footer.php"; ?>
