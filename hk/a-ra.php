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
                <h3 class="panel-title"><?php echo 'Ascensos Altos (SUP/DIR/PRE/OP)'; ?></h3>
        </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable" style="user-select:text;"> <!-- Agregar clases Bootstrap -->
                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th><?php echo $lang[436]; ?></th>
                            <th><?php echo $lang[435]; ?></th>
                            <th><?php echo $lang[439]; ?></th>
                            <th><?php echo $lang[122]; ?></th>
                            <th><?php echo $lang[440]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM usuarios WHERE rank > 4 && rank <= 8 ORDER BY ua DESC");
                        while ($row = mysqli_fetch_array($resultado)) {
                            $fechaAscenso = new DateTime($row['ua']);
                            $fechaActual = new DateTime();
                            $diferencia = $fechaActual->diff($fechaAscenso);
                            
                            $segundosTranscurridos = $fechaActual->getTimestamp() - $fechaAscenso->getTimestamp();

                            if ($segundosTranscurridos < 60) {
                                $diferenciaTexto = "Ascendido recientemente";
                            } else {
                                $diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos";
                            }
                        ?>
                        <tr>
                            <td class="username"><?php echo $row['username']; ?></td>
                            <td><?php echo $row['motto']; ?></td>
                            <td><?php echo $row['AM']; ?></td>
                            <td><?php echo $row['AP']; ?></td>
                            <td>
                                <?php
                                switch ($row['rank']) {
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
                            <td><?php echo $diferenciaTexto; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="width: 900px" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo $lang[437]; ?></h3>
            </div>
            <div class="panel-body">
                <div style="float:left;margin:10px;height: auto;display: block;">
                    <form action="" method="post" enctype="multipart/form-data">
                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[27]; ?></label>
                        <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="user" id="userInput" placeholder="<?php echo $lang[175]; ?>" value="" />
                        
                        <!-- Estilos aplicados directamente en el desplegable -->
                        <ul id="suggestions" style="list-style-type: none; margin: 0; padding: 5px; background-color: #f8f9fa; border: 1px solid #ddd; max-height: 150px; overflow-y: auto; width: 200px; position: absolute; z-index: 1000; display: none; border-radius: 4px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <!-- Las sugerencias aparecerán aquí -->
                        </ul>
                    </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[438]; ?></label><br>
                            <select required="" name="mision" id="misionSelect">
                                <?php
                                if ($rangouser >= 11) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 31 AND num <= 83 ORDER BY num ASC");
                                }
                                else if ($rangouser == 10) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 31 AND num <= 72 ORDER BY num ASC");
                                } elseif ($rangouser == 9) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 31 AND num <= 62 ORDER BY num ASC");
                                } elseif ($rangouser == 8) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 31 AND num <= 45 ORDER BY num ASC");
                                }

                                while ($row = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $row['num'] . '" data-precio="' . $row['precio'] . '">' . $row['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo "Ascendido por"; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="ap" placeholder="<?php echo $tag; ?>" value="<?php echo $tag; ?>" readonly />
                        </div>

                        <?php if ($rangouser >= 10) { ?>
                            <div>
                                <label>
                                    <input type="checkbox" id="ventaCheckbox" name="ventaCheckbox" onclick="togglePriceInput()"> Venta
                                </label>
                                <div id="precioContainer" style="display: none;">
                                    <label for="precio">Precio:</label>
                                    <input type="text" id="precio" name="precio" readonly required="" />
                                </div>

                                <label>
                                    <input type="checkbox" id="trasladoCheckbox" name="trasladoCheckbox" onclick="toggleAgencyInput()"> Traslado
                                </label>
                                <div id="agenciaContainer" style="display: none;">
                                    <label for="agencia">Agencia:</label>
                                    <input type="text" id="agencia" name="agencia" required="" readonly />
                                </div>
                            </div>
                         <?php } ?>

                        <br style="clear: both;" />

                        <div style="float:left;margin-left:10px; width: 100%;">
                            <input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
                        </div>
                    </form>

                    <?php
                    if ($_POST['guardar'] && $_POST['user']) {
                        $user = $_POST['user'];
                        $misionId = $_POST['mision'];

                        
                        // Obtener el nombre de la misión seleccionada
                        $misionQuery = $link->query("SELECT nombre, num, precio FROM misiones WHERE num='$misionId'");
                        $misionRow = mysqli_fetch_array($misionQuery);
                        $misionNombre = $misionRow['nombre']; 
                        $misionSeleccionadaNum = $misionRow['num'];
                        $misionSelPrecio = $misionRow['precio'];

                        // Obtener el motto actual del usuario para guardarlo en AM
                        $query = $link->query("SELECT motto, rank, num_mision FROM usuarios WHERE username='$user'");
                        $row = mysqli_fetch_array($query);
                        $antiguaMision = $row['motto']; 
                        $rangoActual = $row['rank'];
                        $misionActualNum = $row['num_mision']; 

                        // Obtener el precio de la misión actual del usuario
                        $query = $link->query("SELECT precio FROM misiones WHERE num='$misionActualNum'");
                        $misionAcRow = mysqli_fetch_array($query);
                        $misionAcPrecio = $misionAcRow['precio']; // Cambia $row por $misionAcRow para acceder correctamente al precio

                        // Lógica de actualización de rango basada en la misión seleccionada
                        if ($misionId >= 31 && $misionId <= 45) {
                            $nuevoRango = 5; 
                        } elseif ($misionId >= 46 && $misionId <= 62) {
                            $nuevoRango = 6; 
                        } elseif ($misionId >= 63 && $misionId <= 72) {
                            $nuevoRango = 7; 
                        } elseif ($misionId >= 73 && $misionId <= 83) {
                            $nuevoRango = 8; 
                        } else {                            
                            $nuevoRango = $rangoActual;
                        }

                        // Lógica de validación de rango
                        $limite_rangos = [
                            5 => [1, 2],
                            6 => [1, 2, 3],
                            7 => [1, 2, 3, 4],
                            8 => [1, 2, 3, 4, 5],
                            9 => [1, 2, 3, 4, 5, 6],
                            10 => [1, 2, 3, 4, 5, 6, 7, 8],
                            11 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
                            12 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                            13 => range(1, 13),
                        ];

                            // Lógica de validación de rangos para evitar degradación
                        if ($rangouser < 9 && ($nuevoRango < $rangoActual || $misionSeleccionadaNum <= $misionActualNum)) {
                            echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No puedes degradar a un usuario a un rango o misión igual o inferior.',
                            });
                            </script>";
                        } 
                        elseif (!in_array($rangoActual, $limite_rangos[$rangouser])) {
                            echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No puedes ascender a un usuario de rango superior o igual al permitido por tu rango.',
                            });
                            </script>";
                        } else {
                            // Guardar la fecha y hora actual en 'ua'
                            $fechaActual = date('Y-m-d H:i:s');
                            
                            // Actualización en la base de datos
                            $enviar = "UPDATE usuarios SET AP='$tag', AM='$antiguaMision', motto='$misionNombre', num_mision='$misionSeleccionadaNum', rank='$nuevoRango', ua='$fechaActual' WHERE username='$user'";
                            if ($link->query($enviar)) {
                                
                                if($misionSeleccionadaNum < $misionActualNum){
                                    // Guardar acción en Logs si se ha iniciado sesión
                                $fecha_log = $fechaActual;
                                $accion = "Ha degradado al usuario <strong><u>$user</u></strong> de <strong>$antiguaMision</strong> a <strong>$misionNombre</strong>";
                                $enviar_log = "INSERT INTO logs_ascensos (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
                                $resultado_log = $link->query($enviar_log);
                                // Log guardado en Base de datos
                                } else {
                                $fecha_log = $fechaActual;
                                // Obtengo si el checkbox está marcado
                                if (isset($_POST['ventaCheckbox']) && $_POST['ventaCheckbox'] == 'on') {
                                    $resulttt = $misionSelPrecio - $misionAcPrecio;
                                    $accion = "Ha vendido al usuario <strong><u>$user</u></strong> con Antigua Misión: <strong>$antiguaMision</strong> la misión <strong>$misionNombre</strong> por <strong><u>$resulttt</u></strong> créditos.";
                                    $enviar_log = "INSERT INTO logs_ventas (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
                                
                                } elseif(isset($_POST['trasladoCheckbox']) && $_POST['trasladoCheckbox'] == 'on'){

                                    $agencia =  $_POST['agencia'];
                                    $accion = "Ha trasladado al usuario <strong><u>$user</u></strong> con la misión <strong>$misionNombre</strong> de la agencia <strong>$agencia</strong>.";
                                    $enviar_log = "INSERT INTO logs_ascensos (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";

                                }
                                
                                elseif (!isset($_POST['trasladoCheckbox']) ||  !isset($_POST['ventaCheckbox'])) {

                                    $accion = "Ha ascendido al usuario <strong><u>$user</u></strong> de <strong>$antiguaMision</strong> a <strong>$misionNombre</strong>";
                                    $enviar_log = "INSERT INTO logs_ascensos (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
                                    // Guardar acción en Logs si se ha iniciado sesión

                                }
                                $resultado_log = $link->query($enviar_log);
                                // Log guardado en Base de datos
                            }

                                echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'El ascenso y la misión se han actualizado correctamente.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'a-ra';
                                    }
                                });
                                </script>";
                            } else {
                                echo "Error: " . $link->error;
                            }
                        }
                    }
                    ?>
                </div>
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
document.getElementById("misionSelect").addEventListener("change", function() {
    var selectedOption = this.options[this.selectedIndex];
    var precio = selectedOption.getAttribute("data-precio");
    document.getElementById("precio").value = precio ? precio : "0"; // Mostrar precio o 0 si no hay
});
</script>
<script>
function togglePriceInput() {
    var checkbox = document.getElementById("ventaCheckbox");
    var precioContainer = document.getElementById("precioContainer");
    var precioInput = document.getElementById("precio");

    if (checkbox.checked) {
        precioContainer.style.display = "block"; // Mostrar el contenedor de precio
    } else {
        precioContainer.style.display = "none"; // Ocultar el contenedor de precio
        precioInput.value = ""; // Limpiar el campo de precio si no está chequeado
    }
}

document.getElementById("misionSelect").addEventListener("change", function() {
    var selectedOption = this.options[this.selectedIndex];
    var precio = selectedOption.getAttribute("data-precio");
    if (!document.getElementById("ventaCheckbox").checked) {
        document.getElementById("precio").value = precio ? precio : "0"; // Mostrar precio o 0 si no hay
    }
});
</script>
<script>
function toggleAgencyInput() {
    var checkbox = document.getElementById("trasladoCheckbox");
    var agenciaContainer = document.getElementById("agenciaContainer");
    var agenciaInput = document.getElementById("agencia");

    if (checkbox.checked) {
        agenciaContainer.style.display = "block"; // Mostrar el contenedor de la agencia
        agenciaInput.removeAttribute("readonly"); // Habilitar el campo de agencia para que se pueda escribir
        agenciaInput.focus(); // Enfocar el campo de texto
    } else {
        agenciaContainer.style.display = "none"; // Ocultar el contenedor de la agencia
        agenciaInput.value = ""; // Limpiar el campo de texto si no está chequeado
        agenciaInput.setAttribute("readonly", true); // Deshabilitar el campo de agencia
    }
}
</script>

<?php include "../Templates/Footer.php"; ?>
