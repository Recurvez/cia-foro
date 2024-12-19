<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, TAG FROM usuarios WHERE username = "' .$username. '"');
$row = mysqli_fetch_array($query);
$rangouser = $row['rank'];
$tag = $row['TAG']; // Guardamos el TAG en una variable

if("$rangouser" == "1" || "$rangouser" == "2" || "$rangouser" == "3" || "$rangouser" == "4") {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

include "../Templates/Hk_Nav.php";
?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo $lang[6]; ?></h3>
                <input type="text" id="search" placeholder="Buscar usuario..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
            </div>

            <div class="panel-body"> 
                <table class="table table-striped" id="userTable">
                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th><?php echo $lang[436]; ?></th>
                            <th><?php echo $lang[435]; ?></th>
                            <th><?php echo $lang[439]; ?></th>
                            <th><?php echo $lang[122]; ?></th>
                            <th><?php echo $lang[440]; ?></th> <!-- Añadir columna para la diferencia de tiempo -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM usuarios WHERE rank > 1 && rank <= 4 ORDER BY rank DESC");
                        while ($row = mysqli_fetch_array($resultado)) {
                            // Convertir la fecha almacenada en 'ua' a un formato legible
                            $fechaAscenso = new DateTime($row['ua']);
                            $fechaActual = new DateTime();
                            $diferencia = $fechaActual->diff($fechaAscenso);
                            
                            // Calcular los segundos transcurridos desde el ascenso
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
                                    case 2:
                                        echo "SEG";
                                        break;
                                    case 3:
                                        echo "TRN";
                                        break;
                                    case 4:
                                        echo "LOG";
                                        break;
                                }
                                ?>
                            </td>
                            <td><?php echo $diferenciaTexto; ?></td> <!-- Mostrar la diferencia o mensaje -->
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
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="user" placeholder="<?php echo $lang[175]; ?>" value="" />
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[438]; ?></label><br>
                            <select required="" name="mision">
                                <?php
                                if ($rangouser >= 7) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 1 AND num <= 30 ORDER BY num ASC");
                                } elseif ($rangouser == 6) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 1 AND num <= 20 ORDER BY num ASC");
                                } elseif ($rangouser == 5) {
                                    $resultado = $link->query("SELECT * FROM misiones WHERE num >= 1 AND num <= 10 ORDER BY num ASC");
                                }

                                while ($row = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $row['num'] . '">' . $row['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo "Ascendido por"; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="ap" placeholder="<?php echo $tag; ?>" value="<?php echo $tag; ?>" readonly />
                        </div>

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
                        $misionQuery = $link->query("SELECT nombre FROM misiones WHERE num='$misionId'");
                        $misionRow = mysqli_fetch_array($misionQuery);
                        $misionNombre = $misionRow['nombre']; 

                        // Obtener el motto actual del usuario para guardarlo en AM
                        $query = $link->query("SELECT motto, rank FROM usuarios WHERE username='$user'");
                        $row = mysqli_fetch_array($query);
                        $antiguaMision = $row['motto']; 
                        $rangoActual = $row['rank'];

                        // Lógica de actualización de rango basada en la misión seleccionada
                        if ($misionId >= 1 && $misionId <= 10) {
                            $nuevoRango = 2; 
                        } elseif ($misionId >= 11 && $misionId <= 20) {
                            $nuevoRango = 3; 
                        } elseif ($misionId >= 21 && $misionId <= 30) {
                            $nuevoRango = 4; 
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
                            11 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            12 => range(1, 12),
                        ];

                        if (!in_array($rangoActual, $limite_rangos[$rangouser])) {
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
                            $enviar = "UPDATE usuarios SET AP='$tag', AM='$antiguaMision', motto='$misionNombre', rank='$nuevoRango', ua='$fechaActual' WHERE username='$user'";
                            if ($link->query($enviar)) {
                                echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'El ascenso y la misión se han actualizado correctamente.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'xat.php';
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

<script>
document.getElementById("search").addEventListener("keyup", function() {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll("#userTable tbody tr");
    
    rows.forEach(function(row) {
        var username = row.querySelector(".username").textContent.toLowerCase();
        if (username.includes(input)) {
            row.style.display = ""; // Mostrar fila
        } else {
            row.style.display = "none"; // Ocultar fila
        }
    });
});
</script>

<?php include "../Templates/Footer.php"; ?>
