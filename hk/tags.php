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
        // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 8) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
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
            <div class="panel-heading blue"
                style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Listado de Firmas'; ?></h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped" id="userTable" style="user-select:text;">
                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th><?php echo 'Firma'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM usuarios WHERE rank >= 3 && rank <= 12 ORDER BY ua ASC");
                        while ($row = mysqli_fetch_array($resultado)) {
                        ?>
                        <tr>
                            <td class="username"><?php echo $row['username']; ?></td>
                            <td class="TAG"><?php echo $row['TAG']; ?></td>
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
    $(document).ready(function () {
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
            }
        });

        $('#userInput').on('keyup', function () {
            let search = $(this).val();
            if (search.length > 2) {
                $.ajax({
                    url: '../kernel/ajax/buscar_usuarios.php',
                    method: 'GET',
                    data: { search: search },
                    success: function (data) {
                        let suggestions = JSON.parse(data);
                        let suggestionList = $('#suggestions');

                        suggestionList.empty();
                        if (suggestions.length > 0) {
                            suggestions.forEach(function (user) {
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

        $(document).on('click', '.suggestion-item', function () {
            $('#userInput').val($(this).text());
            $('#suggestions').hide();
        });
    });
</script>

<?php include "../Templates/Footer.php"; ?>