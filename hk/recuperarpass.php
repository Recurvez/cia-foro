<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
$row = mysqli_fetch_array($query);
$rangouser = $row['rank'];
$dev = $row['dev'];

if ($dev != 1 && $rangouser < 12) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

include "../Templates/Hk_Nav.php";
?>

<div class="container">
    <div class="row">
        <div class="panel panel-default" style="user-select:text;">
            <div class="panel-heading blue" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="panel-title">Listado de Recuperación de Contraseña</h3>
                <input type="text" id="search" placeholder="Buscar..." class="form-control" style="width: 200px;">
            </div>
            <div class="panel-body">
                <div id="loader" style="text-align:center;margin-left:50%;"> <img src="loader.gif"></div>
                <div class="outer_div"></div>
            </div>
        </div>
    </div>
</div>

<?php include "../Templates/Footer.php"; ?>

<script>
$(document).ready(function(){
    load(1);
    $("#search").on("keyup", function() {
        load(1);
    });
});

function load(page){
    var search = document.getElementById("search").value;
    var parametros = {"action":"ajax","page":page, "search": search};
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'../kernel/ajax/hk_recuperarpass_ajax.php',
        data: parametros,
        beforeSend: function(objeto){
            $("#loader").html("<img src='loader.gif'>");
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $("#loader").html("");
        }
    });
}
</script>
