<?php
$query = $link->query('SELECT username, rank, dev, rank_pbl FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $usernamee = $row['username'];
    $rangouseruser = $row['rank'];
    $dev = $row['dev'];
    $rank_pbl = $row['rank_pbl'];
}

function whos_stats($id) {
    $f = json_decode(file_get_contents("http://whos.amung.us/stats/data/?k=" . $id));
    return $f->total_count;
}

$visitantes = whos_stats("$contador");

if ($visitantes == 1) {
    $texto_visitantes = $lang[14];
} else {
    $texto_visitantes = $lang[15];
}

if ($_SESSION["logeado"] == "SI") {
    echo "$bannertop";
    echo "
    <div class='banner-top' style='background-image:url(\"/images/background.png\"); background-size: cover;'><div class='container'><div class='visible-desktop'><div class='logo'><a href='$url/index'><img class='logo' src='$logo'></a><div class='contador-visitas-xmas'>$visitantes $texto_visitantes</div></div></div></div>
    <nav class='navbar navbar-default xmas'>
        <div class='container'>
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' style='background-color: gray' href='$url'><img src='https://www.habbo.es/habbo-imaging/badge/b08134s86115s96114s80113t271111fd2ce747251db16d890f73b86a9cb03.gif' style='width: 100%;'></a>
            </div>
            <div id='navbar' class='navbar-collapse collapse'>
                <ul class='nav navbar-nav'>
                    <li><a href='$url/hk/index.php'>$lang[1]</a></li>";

    if ($rangouseruser >= $rango5 || $dev == 1) {
        echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>$lang[446] <span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a href='$url/hk/a-rb'>$lang[447]</a></li>
                    <li><a href='$url/hk/a-ra'>$lang[448]</a></li>
                    <li><a href='$url/hk/a-admin'>$lang[449]</a></li>
                </ul>
              </li>";
    }

    if ($rangouseruser >= $rango9 || $dev == 1) {
        echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>$lang[268]<span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a href='$url/hk/logs_ascensos.php'>$lang[450]</a></li>
                    <li><a href='$url/hk/validar-user.php'>$lang[451]</a></li>
                    <li><a href='$url/hk/users.php'>$lang[455]</a></li>
                    <li><a href='$url/hk/tags.php'>$lang[452]</a></li>
                    <li><a href='$url/hk/pagas.php'>$lang[454]</a></li>  
                    <li><a href='$url/hk/ban.php'>$lang[274]</a></li>
                    <li><a href='$url/hk/recuperarpass.php'>Recuperador de Contraseñas</a></li>
                    <li><a href='$url/hk/venta_vip.php'>VIPs</a></li>
                </ul>
              </li>";
    }

    if ($rangouseruser == $rango13 || $dev == 1) {
        echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Developer <span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a href='$url/hk/logs.php'>$lang[276]</a></li>
                    <li><a href='$url/hk/users-all.php'>$lang[282] [Todos]</a></li>    
                    <li><a href='$url/hk/eventos.php'>$lang[3]</a></li>  
                    <li><a href='$url/hk/noticias.php'>$lang[2]</a></li>
                    <li><a href='$url/hk/promos.php'>$lang[269]</a></li>
                    <li><a href='$url/hk/placas.php'>$lang[129]</a></li>
                    <li><a href='$url/hk/rangos.php'>$lang[275]</a></li>
                    <li><a href='$url/hk/estadisticas.php'>$lang[277]</a></li>
                    <li><a href='$url/hk/mantenimiento.php'>$lang[279]</a></li>
                    <li><a href='$url/hk/configuracion.php'>$lang[280]</a></li>
                    <li><a href='$url/hk/radio.php'>$lang[281]</a></li>
                    <li><a href='$url/hk/reportes.php'>$lang[273]</a></li>
                    <li><a href='$url/hk/mensajes.php'>$lang[20]</a></li>    
                    <li><a href='$url/hk/comentarios.php'>Comentarios</a></li>     
                    <li><a href='$url/hk/tags-all.php'>$lang[453]</a></li>
                                 
                </ul>
              </li>";
    }

    if ($rangouser >= $rango12 || $rank_pbl >= 1 || $dev == 1) {
        echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>PBL<span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a href='$url/hk/sorteo.php'>Sorteo</a></li>                    
                </ul>
              </li>";
    } 

    if ($username=='TheDantelp' || $username=='novalboschu:' || $username=='CARDARK50' || $dev == 1) {
        echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Control<span class='caret'></span></a>
                <ul class='dropdown-menu'>
                    <li><a href='$url/hk/ip-list.php'>IPs</a></li>   
                    <li><a href='$url/hk/usuarios_activos.php'>Usuarios Activos</a></li>                      
                </ul>
              </li>";
    }

    echo '</ul>';
    echo '<ul class="nav navbar-nav navbar-right">';
    ?>
                
                <li><a href="<?php echo $url; ?>/index.php?hkcerrada"><?php echo $lang[283]; ?></a></li>
                <li><a href="<?php echo $url; ?>/kernel/login/cerrar.php"><?php echo $lang[18]; ?></a></li>
            </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
<?php
}
?>

<style>
    /* Estilo del menú de navegación en Halloween */
    .halloween {
        background-color: black; /* Rojo navideño */
        color: white; /* Texto en blanco */
    }

    /* Estilos de los enlaces */
    .halloween .navbar-nav > li > a {
        color: white; /* Texto blanco por defecto */
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces */
    .halloween .navbar-nav > li > a:focus,
    .halloween .navbar-nav > li > a:hover {
        color: black;
        background-color: orange; 
    }

    /* Estilo del menú desplegable */
    .halloween .dropdown-menu,
    .halloween .dropdown-menu > li > a {
        background-color: black; 
        color: white;
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces del menú desplegable */
    .halloween .dropdown-menu > li > a:hover {
        background-color: orange;
        color: black; 
    }

    /* Sombra de la barra de navegación */
    .halloween.navbar-default {
        box-shadow: 0 0 10px orange;
    }

    /* Estilo inicial para los elementos del menú desplegable al abrir el dropdown */
    .halloween .navbar-nav > .open > a,
    .halloween .navbar-nav > .open > a:focus,
    .halloween .navbar-nav > .open > a:hover {
        background-color: orange;
        color: black;
    }

    /* Estilo del menú de navegación en Otoño */
    .fall {
        background-color: #8B4513; /* Fondo naranja */
        color: white; /* Texto en blanco */
    }

    /* Estilos de los enlaces */
    .fall .navbar-nav > li > a {
        color: white; /* Texto blanco por defecto */
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces */
    .fall .navbar-nav > li > a:focus,
    .fall .navbar-nav > li > a:hover {
        color: #8B4513;
        background-color: white; /* Fondo blanco al pasar el mouse */
    }

    /* Estilo del menú desplegable */
    .fall .dropdown-menu,
    .fall .dropdown-menu > li > a {
        background-color: #8B4513; /* Fondo naranja */
        color: white;
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces del menú desplegable */
    .fall .dropdown-menu > li > a:hover {
        background-color: white; /* Fondo blanco al pasar el mouse */
        color: orange;
    }

    /* Sombra de la barra de navegación */
    .fall.navbar-default {
        box-shadow: 0 0 10px #8B4513; /* Sombra naranja */
    }

    /* Estilo inicial para los elementos del menú desplegable al abrir el dropdown */
    .fall .navbar-nav > .open > a,
    .fall .navbar-nav > .open > a:focus,
    .fall .navbar-nav > .open > a:hover {
        background-color: white; /* Fondo blanco */
        color: #8B4513;
    }
    
    /* Estilo del menú de navegación en Navidad */
    .xmas {
        background-color: #D32F2F; /* Rojo navideño */
        color: white; /* Texto en blanco */
    }

    /* Estilos de los enlaces */
    .xmas .navbar-nav > li > a {
        color: white; /* Texto blanco por defecto */
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces */
    .xmas .navbar-nav > li > a:focus,
    .xmas .navbar-nav > li > a:hover {
        color: #D32F2F; /* Rojo oscuro */
        background-color: #FFC107; /* Amarillo dorado */
    }

    /* Estilo del menú desplegable */
    .xmas .dropdown-menu,
    .xmas .dropdown-menu > li > a {
        background-color: #C2185B; /* Fondo rosa oscuro */
        color: white; /* Texto blanco */
    }

    /* Cambiar color y fondo al pasar el mouse sobre los enlaces del menú desplegable */
    .xmas .dropdown-menu > li > a:hover {
        background-color: #FFC107; /* Amarillo dorado */
        color: #D32F2F; /* Rojo oscuro */
    }

    /* Sombra de la barra de navegación */
    .xmas.navbar-default {
        box-shadow: 0 0 10px white;
    }

    /* Estilo inicial para los elementos del menú desplegable al abrir el dropdown */
    .xmas .navbar-nav > .open > a,
    .xmas .navbar-nav > .open > a:focus,
    .xmas .navbar-nav > .open > a:hover {
        background-color: #FFC107; /* Amarillo dorado */
        color: #D32F2F; /* Rojo oscuro */
    }

    /* Estilo para el contador de visitas en Halloween  */
    .contador-visitas-halloween{
        width: auto;
        height: 40px;
        border-radius: 3px;
        border: orange solid 1px;
        box-shadow: 0 0 0 3px rgba(100, 50, 0, 0.2);
        padding: 10px;
        position: relative;
        color: #fff;
        background-color: #000;
        float: right;
    }

     /* Estilo para el contador de visitas en Otoño  */
     .contador-visitas-fall {
        width: auto;
        height: 40px;
        border-radius: 3px;
        border: #d2691e solid 1px; /* Borde marrón anaranjado */
        box-shadow: 0 0 0 3px rgba(210, 105, 30, 0.2); /* Sombra en tono marrón anaranjado */
        padding: 10px;
        position: relative;
        color: #8B4513; /* Texto en blanco */
        background-color: white; /* Fondo naranja otoñal */
        float: right;
    }

    /* Estilo para el contador de visitas en Navidad  */
    .contador-visitas-xmas{
        width: auto;
        height: 40px;
        border-radius: 3px;
        border: red solid 1px;
        box-shadow: 0 0 0 3px red;
        padding: 10px;
        position: relative;
        color: red;
        background-color: white;
        float: right;
    }   

    img.logo{
      width: 15%;
    }
</style>