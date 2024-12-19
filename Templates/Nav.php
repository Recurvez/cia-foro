<?php

$mipefil = $lang[16];

$ajuste = $lang[17];

$cerrar = $lang[18];

function whos_stats($id){ $f = json_decode(file_get_contents("http://whos.amung.us/stats/data/?k=".$id)); return $f->total_count; } 
$visitantes = whos_stats("$contador");

if ($visitantes == 1) {
  $texto_visitantes = $lang[14];
} else {
  $texto_visitantes = $lang[15];
}

$bannertop = "<div class='banner-top'><div class='container'><div class='visible-desktop'><div class='logo'><a href='$url/index'><img class='logo' src='$logo'></a><div class='contador-visitas-fall'><b>$visitantes</b> $texto_visitantes</div></div>
</div></div>";

$menu = "<div class='banner-top' style='background-image:url(\"../images/background.png\"); background-size: cover;'><div class='container'><div class='visible-desktop'><div class='logo'><a href='index'><img class='logo' src='$logo'></a><div class='contador-visitas-fall'><b>$visitantes</b> $texto_visitantes</div></div>
</div></div>
      <nav class='navbar navbar-default fall'>
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
              <li><a href='$url/index'>$lang[1]</a></li>
              <li><a href='$url/noticias'>$lang[2]</a></li>
              <li><a href='$url/eventos'>$lang[3]</a></li>
              <li><a href='$url/misiones'>$lang[444]</a></li>
			        <li><a href='$url/equipo'>$lang[6]</a></li>
              <li><a href='$url/help'>$lang[10]</a></li>
              
              <li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>$lang[8] <span class='caret'></span></a>
                <ul class='dropdown-menu'>
                  
                  <li><a href='$url/placas'>$lang[11]</a></li>
                  <li><a href='$url/usuarios'>$lang[282]</a></li>
                </ul>
              </li>
              
            </ul>";
			
            $query = $link->query("
                SELECT usuarios.rank, usuarios.dev, usuarios.avatar, usuarios.motto, usuarios.tag, usuarios.AP, usuarios.lupas, usuarios.motto, usuarios.fondo_perfil, usuarios.efecto_perfil, rangos.nombre AS nombre_rango 
                FROM usuarios 
                LEFT JOIN rangos ON usuarios.rank = rangos.id 
                WHERE usuarios.username = '$username'
            ");
        
        if ($row = mysqli_fetch_assoc($query)) {
            $rango = $row['rank'];
            $dev = $row['dev'];
            $avatar = $row['avatar'];
            $motto = $row['motto'];
            $firma = $row['tag'];
            $ascendido_por = $row['AP'];
            $lupas = $row['lupas'];
            $nombre_rango = $row['nombre_rango'];
            $fondo_perfil_id = $row['fondo_perfil'];
            $efecto_perfil = $row['efecto_perfil'];
        
            // Segunda consulta: obtener la URL de la placa correspondiente al rango
            $queryPlaca = $link->query("SELECT imagen FROM placas WHERE id = '$rango'");
            $rowPlaca = mysqli_fetch_assoc($queryPlaca);
            $placa_url = $rowPlaca ? $rowPlaca['imagen'] : '';
        
            // Tercera consulta: obtener la URL del fondo desde la tabla tienda
            $queryFondo = $link->query("SELECT imagen FROM tienda WHERE id = '$fondo_perfil_id'");
            $rowFondo = mysqli_fetch_assoc($queryFondo);
            $fondo_perfil_url = $rowFondo ? $rowFondo['imagen'] : ''; // URL del fondo si existe, vacío si no

            $queryEfecto = $link->query("SELECT imagen FROM tienda WHERE id = '$efecto_perfil'");
            $rowEfecto = mysqli_fetch_assoc($queryEfecto);
            $efecto_perfil_url = $rowEfecto ? $rowEfecto['imagen'] : ''; // URL del efecto si existe, vacío si no
        }

        switch($efecto_perfil){
            case 10:
                // Kitsune
                $background_image = "url('https://i.imgur.com/y4NfCTE.png')";
                $background_position = 'bottom 15px left -15%';
                $background_size = '30%';
                $filter = 'none';
                $z_index = '0';
                
                break;
            case 11:
                // Dragón
                $background_image = "url('https://i.imgur.com/hY0q1jC.png')";
                $background_position = 'bottom 90% left 20%';
                $filter = 'none ';
                $z_index = '0';

                break;
            case 12:
                // Conejo Dorado
                $background_image = "url('https://i.imgur.com/KU4CEGT.png')";
                $background_position = 'bottom 50% left 15%';
                $filter = 'none';
                $z_index = '0';

                break;
            case 13:
                // Gato Morado
                $background_image = "url('https://i.imgur.com/iryhcxk.png')";
                $background_position = 'bottom 50% left 5%';
                $filter = 'none';
                $z_index = '0';

                break;
            case 14:
                // Mostrador supermercado
                $background_image = "url('https://i.imgur.com/ZFS64Q1.png')";
                $background_position = 'bottom 0% left 0%';
                $filter = 'none';
                $z_index = '0';

                break;  
            case 15:
                // Taxi
                $background_image = "url('https://i.imgur.com/mBKVPmc.gif')";
                $background_position = 'bottom 70% left -20%';
                $filter = 'none';
                $z_index = '0';

                break;
            case 16:
                // Puesto de chuches
                $background_image = "url('https://i.imgur.com/zL8z9CZ.png')";
                $background_position = 'bottom 60% left -5%';
                $filter = 'none';
                $z_index = '1';
                break;
            default:
            // Default: Sin efecto
                break;
        }

$query = $link->query('SELECT * FROM usuarios_amigos WHERE  (user = "' .$username. '") AND (estado_solicitud = "Pendiente")');
$solicitudes = mysqli_num_rows($query);

if ($solicitudes != 0) {
$notificacion_solicitud = "<span class='badge'>$solicitudes</span>";
} else { 
  $notificacion_solicitud = ""; 
}

if($_SESSION["logeado"] == "SI"){
	echo "$menu";
	echo '<ul class="nav navbar-nav navbar-right">';
  if("$rango" >= "5" || "$dev" == "1"){
      echo '<li><a href="hk/index.php?iniciohk">Control Panel</a></li>';
  }
  ?>

<li><a href="#" id="profile-link"><?php echo "$username";?></a></li>

<!--
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo "$username"; ?> <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="ajustes"><?php // echo $lang[17]; ?></a></li>
    <li><a href="perfil.php?user=<?php // echo "$username"; ?>"><?php // echo "$username"; ?></a></li>
  </ul>
</li>
-->
  <li><a href="kernel/login/cerrar.php"><?php echo $lang[23]; ?></a></li>
    </ul> <?php
}  else {
	echo "$menu";
	echo '<ul class="nav navbar-nav navbar-right">
              <li><a href="login">'.$lang[24].'</a></li>
              <li><a href="registro">'.$lang[25].'</a></li>
            </ul>';
}
?>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

<!-- Sección flotante de perfil -->
<div class="profile-section" id="profile-section">
    <!-- Vista de información del perfil -->
    <ul id="profile-info">
        <!-- Botón de cierre -->
        <li><span class="close-btn" onclick="toggleProfile()">Cerrar ×</span><br></li>
        <!-- Encabezado de perfil con fondo de otoño, avatar y nombre -->
        <div class="profile-header">
            <div class="efecto-avatar"></div>
            <img src="<?php echo $avatar;?>" alt="Avatar" class="avatar">
            <span class="username"><?php echo $username; ?></span>
        </div>
        <li><b>Rango: </b><?php echo "$nombre_rango";?>
            <?php if ($placa_url): ?>
                <img src="<?php echo $placa_url; ?>" alt="Placa" style="width:10%; margin-left: 5px;">
            <?php endif; ?>
        <li><b>Misión: </b><?php echo "$motto"?></li>
        <li><b>Firma: </b><?php echo "$firma"?></li>
        <li><b>Ascendido por: </b><?php echo "$ascendido_por"?></li>
        <li>
            <b>Monedas Foro</b>
            <!-- Enlace para abrir la sección modal -->
            <a href="#" onclick="showLupasInfo()" style=" margin:10px; border: 1px solid #999; border-radius: 6px;color:black;font-size:1em;"> 
               <img src="https://images.habbo.com/c_images/album1584/DE149.png" alt="Lupa">
               <?php echo $lupas;?>
            </a>
        </li>
        <li><a href="tienda.php">Ver Tienda Web</a></li>
        <!--<li><a href="perfil.php?user=<?php echo "$username"; ?>">Ver Perfil Completo</a></li>-->
    </ul>

    <!-- Vista modal dentro de la misma sección de perfil -->
    <div id="lupas-info">
        <span class="back-btn" onclick="showProfileInfo()">← Volver</span>
        <h2><img src="https://images.habbo.com/c_images/album1584/DE149.png" alt="Lupa">Lupas</h2>
        <p>
            <strong>Las lupas</strong> son la moneda principal de la web. 
            <br>Puedes ganar lupas siendo uno de los <strong>3 primeros en el ranking</strong> de ascensos semanales.
            <br>Con las lupas puedes <strong>comprar artículos</strong> en la tienda web, así como <strong>misiones dentro del juego</strong>.
        </p>
    </div>
</div>

<!-- Sección flotante de otro perfil -->
<div class="profile-section" id="other-profile-section">
    <!-- Vista de información del perfil -->
    <ul id="other-profile-info">
        <!-- Esto se rellena en el script -->
    </ul>
</div>

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

    /* Estilo para la sección de perfil flotante */
    .profile-section {
          position: fixed;
          z-index: 2;
          top: 0;
          right: -100%; /* Inicialmente fuera de pantalla */
          min-width: 300px;
          height: auto;
          margin: 10px;
          border: 2px solid black;
          border-radius: 5px;
          background-color: white;
          box-shadow: -2px 0 5px rgba(0,0,0,0.5);
          padding: 20px;
          transition: right 0.3s ease; /* Animación de deslizamiento */
      }

      .profile-section.show {
          right: 0; /* Muestra la sección al ponerla en 0 */
      }

      .profile-section ul {
          list-style: none;
          padding: 0px;
      }

      .profile-section ul li {
          padding: 10px;
          padding-left: 0px;
          border-bottom: 1px solid #ccc;
      }

      .profile-section a{
        text-decoration: none;
        padding: 10px;
        color: #666;
        border-left: 4px solid #d2d2d2;
        font-size: 1em;
      }

      /* Estilo del contenedor de avatar y nombre */
      .profile-header {
          display: flex;
          position: relative;
          align-items: center;
          background-image: linear-gradient(to left, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0)), url(<?php echo $fondo_perfil_url; ?>);
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;
          padding: 0px;
          border-radius: 8px; 
      }

      .efecto-avatar{
        width: 100%;
        height: 100%;
        position: absolute;
        background-image: <?php echo $background_image; ?>;
        background-repeat: no-repeat;
        background-position: <?php echo $background_position; ?>;
        filter: <?php echo $filter; ?>;
        transform: <?php echo $transform; ?>;
        z-index: <?php echo $z_index; ?>;  
        }

      /* Estilo del avatar */
      .avatar {
          filter: drop-shadow(-5px 0px 0px rgba(0, 0, 0, 0.3));
      }

      /* Nombre de usuario */
      .username {
        font-size: 1.2em;
        color: white;
        z-index: 1; /* Asegura que el texto esté por encima del avatar y efecto */
        padding-left: 40px;
        padding-right: 5px;
        font-weight: bold;
        white-space: nowrap; /* Evita que el texto se desborde */
        word-wrap: normal; /* Asegura que no se rompa el texto en lugares no deseados */
        word-break: break-word; /* Permite que las palabras largas no se dividan */
        filter: drop-shadow(1px 1px 0 rgba(0, 0, 0, 0.5)) drop-shadow(-1px 1px 0 rgba(0, 0, 0, 0.5)) drop-shadow(1px -1px 0 rgba(0, 0, 0, 0.5)) drop-shadow(-1px -1px 0 rgba(0, 0, 0, 0.5)); 
      }

      /* Estilos para la nueva vista modal dentro del perfil */
      #lupas-info {
          display: none; /* Inicialmente oculto */
          max-width: 250px;
          height: auto;
          padding: 20px;
          box-sizing: border-box; /* Asegura que el padding no aumente el tamaño */
      }

      .back-btn, .close-btn{
          cursor: pointer;
          font-size: 1.2em;
      }

      /* Ajustes en la sección de perfil */
      .profile-section ul, #lupas-info {
          padding: 0;
          margin: 0;
          list-style-type: none;
      }
</style>

<script>
  // Función para mostrar u ocultar la sección del perfil
  function toggleProfile() {
        const profileSection = document.getElementById('profile-section');
        profileSection.classList.toggle('show'); // Alterna la clase 'show' para mostrar/ocultar
        showProfileInfo(); // Asegura que al abrir el perfil se muestre la vista de perfil por defecto
    }

    function toggleOtherProfile() {
        const otherProfileSection = document.getElementById('other-profile-section');
        otherProfileSection.classList.toggle('show'); // Alterna la clase 'show' para mostrar/ocultar
        showOtherProfileInfo(); // Asegura que al abrir el perfil se muestre la vista de perfil por defecto
    }

    function showOtherProfileInfo() {
        document.getElementById('other-profile-info').style.display = 'block';
    }

    // Función para mostrar la vista de perfil
    function showProfileInfo() {
        document.getElementById('profile-info').style.display = 'block';
        document.getElementById('lupas-info').style.display = 'none';
    }

    // Función para mostrar la vista de información de lupas
    function showLupasInfo() {
        document.getElementById('profile-info').style.display = 'none';
        document.getElementById('lupas-info').style.display = 'block';
    }

    // Evento para el enlace del perfil
    document.getElementById('profile-link').addEventListener('click', (e) => {
        e.preventDefault(); // Evita la navegación
        toggleProfile();
    });

    document.getElementById('other-profile-link').addEventListener('click', (e) => {
        e.preventDefault(); // Evita la navegación
        toggleOtherProfile();
    });
</script>