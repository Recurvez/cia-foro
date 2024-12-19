<?php
include "../Templates/Hk_Head.php";

// Preparar la consulta usando prepared statements para mayor seguridad
$stmt = $link->prepare('SELECT rank, dev, rank_pbl, encargado_pbl, time_pbl, pbl_time_on FROM usuarios WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $rank_pbl = $row['rank_pbl'];
    $pbl_time_on = $row['pbl_time_on'];

    if ($dev == 1 || $rank_pbl >= 1) {
        break; // Dev o pbl_time_on activo, dejar pasar
    }

    if ($rangouser >= 1 && $rangouser <= 11) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title">Listado de Firmas</h3>
                <input type="text" id="search" placeholder="Buscar Usuario..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
            </div>

            <div class="panel-body">
                <table class="table table-striped" id="userTable">
                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th>Encargado</th>
                            <th>Time</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM usuarios WHERE rank >= 2 && rank <= 9 ORDER BY id ASC");
                        while ($row = $resultado->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="username"><?php echo $row['username']; ?></td>
                            <td class="encargado_pbl"><?php echo $row['encargado_pbl']; ?></td>
                            <td class="time_pbl">
                                <span class="time-left" data-endtime="<?php echo $row['time_pbl']; ?>"></span>
                            </td>
                            <td>
                                <?php if ($row['pbl_time_on'] == 0) { ?>
                                    <a href="pbl/crear_time.php?id=<?php echo $row['ID']; ?>">
                                        <button type="button" class="btn btn-sm btn-success">
                                            <span class="glyphicon glyphicon-check"></span>
                                        </button>
                                    </a>
                                <?php } elseif ($row['pbl_time_on'] == 1 && $row['pbl_paused'] == 0) { ?>
                                    <a href="pbl/pausar_time.php?id=<?php echo $row['ID']; ?>">
                                        <button type="button" class="btn btn-sm btn-primary pause-btn" data-id="<?php echo $row['ID']; ?>">
                                            <span class="glyphicon glyphicon-pause"></span>
                                        </button>
                                    </a>
                                    <a href="pbl/detener_time.php?id=<?php echo $row['ID']; ?>">
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <span class="glyphicon glyphicon-stop"></span>
                                        </button>
                                    </a>
                                <?php } elseif ($row['pbl_paused'] == 1) { ?>
                                    <a href="pbl/reanudar_time.php?id=<?php echo $row['ID']; ?>">
                                        <button type="button" class="btn btn-sm btn-success">
                                            <span class="glyphicon glyphicon-play"></span>
                                        </button>
                                    </a>
                                    <a href="pbl/detener_time.php?id=<?php echo $row['ID']; ?>">
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <span class="glyphicon glyphicon-stop"></span>
                                        </button>
                                    </a>                                    
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Filtro de búsqueda
document.getElementById("search").addEventListener("keyup", function() {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(function(row) {
        var encargado = row.querySelector(".encargado_pbl").textContent.toLowerCase();
        var username = row.querySelector(".username").textContent.toLowerCase();

        if (encargado.includes(input) || username.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// Obtener tiempo transcurrido
function getTimeElapsed(starttime) {
    var total = Date.parse(new Date()) - Date.parse(starttime);
    var minutes = Math.floor((total / 1000 / 60) % 60);
    var seconds = Math.floor((total / 1000) % 60);

    return {
        'minutes': minutes,
        'seconds': seconds,
        'total': total
    };
}

// Inicializar temporizador
function initializeClock(span, starttime) {
    function updateClock() {
        var time = getTimeElapsed(starttime);
        span.innerHTML = ('0' + time.minutes).slice(-2) + ':' + ('0' + time.seconds).slice(-2);
    }

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
    span.timeinterval = timeinterval;
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    var clocks = document.querySelectorAll('.time-left');
    clocks.forEach(function(clock) {
        var starttime = clock.getAttribute('data-endtime');
        initializeClock(clock, starttime);
    });
});

// Función para pausar tiempo con AJAX
document.querySelectorAll('.pause-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var userId = this.getAttribute('data-id');
        var clock = this.closest('tr').querySelector('.time-left');

        clearInterval(clock.timeinterval);

        var starttime = clock.getAttribute('data-endtime');
        var timeElapsed = getTimeElapsed(starttime);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "pbl/pausar_time.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + userId + "&elapsed=" + timeElapsed.total);

        var newEndtime = new Date(Date.parse(new Date()) - timeElapsed.total).toISOString().slice(0, 19).replace('T', ' ');
        clock.setAttribute('data-endtime', newEndtime);
    });
});
</script>

<?php include "../Templates/Footer.php"; ?>
