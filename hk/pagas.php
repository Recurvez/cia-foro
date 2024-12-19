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
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 9) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
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

            <?php if ($rangouser > 10 || $dev == 1) { ?> 
                <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                    <a href="eliminar/pagas.php">
                        <button type="button" class="btn btn-sm btn-danger"><?php echo 'Reiniciar Lista'; ?></button>
                    </a>
                </div>
            <?php } ?>

                <table class="table table-striped" id="userTable">
                    <thead>
                        <tr>
                            <th><?php echo 'ID'; ?></th>
                            <th><?php echo $lang[27]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Configuración de paginación
                        $elementos_por_pagina = 10; // Número de elementos por página
                        $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Obtener página actual
                        $inicio = ($pagina_actual - 1) * $elementos_por_pagina; // Calcular el inicio

                        // Obtener el total de usuarios
                        $total_resultados = $link->query("SELECT COUNT(*) AS total FROM pagas WHERE id > 0");
                        $total_row = mysqli_fetch_array($total_resultados);
                        $total_usuarios = $total_row['total'];
                        $total_paginas = ceil($total_usuarios / $elementos_por_pagina); // Calcular total de páginas

                        // Consulta para obtener los usuarios en la página actual
                        $resultado = $link->query("SELECT * FROM pagas WHERE id > 0 ORDER BY id ASC LIMIT $inicio, $elementos_por_pagina");
                        while ($row = mysqli_fetch_array($resultado)) {
                        ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>                            
                        <td class="username"><?php echo $row['usuario']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

<!-- Controles de paginación -->
<?php if ($total_paginas > 1): // Solo mostrar controles si hay más de una página ?>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?php if($pagina_actual <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php 
        // Mostrar páginas de manera que muestre un rango limitado
        $rango = 4; // Número de páginas a mostrar a cada lado de la página actual
        for ($i = 1; $i <= $total_paginas; $i++): ?>
            <?php if ($i == 1 || $i == $total_paginas || ($i >= $pagina_actual - $rango && $i <= $pagina_actual + $rango)): ?>
                <li class="page-item <?php if($i == $pagina_actual) echo 'active'; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php elseif ($i == $pagina_actual - $rango - 1 || $i == $pagina_actual + $rango + 1): ?>
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <li class="page-item <?php if($pagina_actual >= $total_paginas) echo 'disabled'; ?>">
            <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php endif; // Fin de la verificación para mostrar controles ?>
            </div>
        </div>
        <div style="width: 500px" class="panel panel-default">
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

                        <br style="clear: both;" />

                        <div style="float:left;margin-left:10px; width: 100%;">
                            <input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
                        </div>
                    </form>

                    <?php
                    if ($_POST['guardar'] && $_POST['user']) {
                        $user = $_POST['user'];;
                            
                            // Actualización en la base de datos
                            $enviar = "INSERT INTO pagas (usuario) VALUES ('$user')";
                            if ($link->query($enviar)) {
                                
                                    // Guardar acción en Logs si se ha iniciado sesión
                                $fecha_log = $fechaActual;
                                $accion = "Ha anotado al usuario <strong><u>$user</u></strong> a la lista de pagas.";
                                $enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
                                $resultado_log = $link->query($enviar_log);

                                echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'El usuario se ha registrado correctamente.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'pagas.php';
                                    }
                                });
                                </script>";

                                // Log guardado en Base de datos
                            }else {
                                echo "Error: " . $link->error;
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
