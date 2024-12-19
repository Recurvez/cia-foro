<?php
include "../Templates/Hk_Head.php";

// Obtener el rango del usuario logueado para verificar permisos
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
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
            <div class="panel-heading blue d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="panel-title" style="margin: 0;"><?php echo $lang[282]; ?></h3>
                <div class="input-group" style="width: 250px;">
                    <input type="text" id="search" placeholder="Buscar usuario..." class="form-control" style="z-index: 1;">
                </div>
            </div>
            <div class="panel-body">
                <div id="loader" style="text-align:center; margin-left:50%;">
                    <img src="loader.gif">
                </div>
                <div class="outer_div"></div><!-- Datos ajax Final -->
            </div>
        </div>

        <div style="width: 70%" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo $lang[405]; ?></h3>
            </div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[175]; ?></label>
                        <input style="margin-bottom: 10px;width:200px;" type="text" required class="form-control" name="user" placeholder="<?php echo $lang[175]; ?>" />
                    </div>

                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[307]; ?></label>
                        <input style="margin-bottom: 10px;width:300px;" type="text" required class="form-control" name="razon" placeholder="<?php echo $lang[406]; ?>" />
                    </div>

                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[308]; ?></label>
                        <input style="margin-bottom: 10px;width:auto;" type="date" required class="form-control" name="ban_f" />
                    </div>

                    <div style="margin-right: 10%;margin-left: 10px;">
                        <input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
                    </div>
                </form>

                <?php
                if (isset($_POST['guardar']) && !empty($_POST['user'])) {
                    $user = $_POST['user'];
                    $razon = $_POST['razon'];
                    $ban_i = date("d-m-Y");
                    $ban_f = DateTime::createFromFormat('Y-m-d', $_POST['ban_f'])->format('d-m-Y');

                    // Verifica si el usuario existe en la base de datos
                    $resultado = $link->query("SELECT username FROM usuarios WHERE username = '$user'");
                    if ($resultado->num_rows > 0) {
                        // El usuario existe
                        $user_correcto = $resultado->fetch_assoc()['username'];

                        // Verifica si ya está baneado
                        $resultado = $link->query("SELECT usuario FROM baneo WHERE usuario = '$user_correcto'");
                        if ($resultado->num_rows > 0) {
                            header("Location: ban.php?usuario_existente");
                        } else {
                            // Inserta el baneo
                            $consulta = "UPDATE usuarios SET validacion = '0' ,ban='1', ban_i='$ban_i', ban_f='$ban_f' WHERE username='$user_correcto'";
                            $link->query($consulta);

                            $enviar = "INSERT INTO baneo (usuario, razon, ban_i, ban_f) VALUES ('$user_correcto', '$razon', '$ban_i', '$ban_f')";
                            if ($link->query($enviar)) {
                                header("Location: ban.php?guardado");
                            }

        // Guardar acción en Logs
        $fecha_log = date('Y-m-d H:i:s');
        $accion = "Ha despedido a $user_correcto por el motivo de: $razon";
        $enviar_log = "INSERT INTO logs (usuario, accion, fecha) VALUES ('".$username."', '".$accion."', '".$fecha_log."')";
        $link->query($enviar_log); // Log guardado en base de datos
                            
                        }
                    } else {
                        // Usuario no encontrado
                        echo '<div class="alert alert-danger">Usuario no encontrado.</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "../Templates/Footer.php"; ?>

<script>
// Captura el evento de tecleo para realizar la búsqueda en tiempo real
document.getElementById("search").addEventListener("keyup", function() {
    var query = this.value;
    load(1, query);  // Pasar el valor del campo de búsqueda
});

// Función para cargar los datos con AJAX
function load(page, search = '') {
    var parametros = {"action": "ajax", "page": page, "search": search};
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../kernel/ajax/Hk_ban_ajax.php',
        data: parametros,
        beforeSend: function(objeto) {
            $("#loader").html("<img src='loader.gif'>");
        },
        success: function(data) {
            $(".outer_div").html(data).fadeIn('slow');
            $("#loader").html("");
        }
    });
}

$(document).ready(function(){
    load(1);  // Cargar los datos cuando la página se carga
});
</script>
