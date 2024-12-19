<div class="container" style="max-width: 1200px; margin: auto;">
    <div class="row">
        <div class="col-md-8">
            <?php
            // Iteramos los rangos del 12 al 9 (orden descendente)
            for ($rank = 12; $rank >= 9; $rank--) {
                // Obtenemos los datos del rango actual
                $resultado = $link->query("SELECT * FROM rangos WHERE id = $rank");
                if ($row_rango = mysqli_fetch_array($resultado)) {

                    // Asignamos el code según el rango
                    $code = match ($rank) {
                        12 => 'F',
                        11 => 'MNG',
                        10 => 'ADM',
                        9 => 'JD',
                        default => '',
                    };

                    // Obtenemos la imagen correspondiente del code desde la tabla placas
                    $resultado_placas = $link->query("SELECT imagen FROM placas WHERE code = '$code'");
                    $row_placa = mysqli_fetch_array($resultado_placas);
                    $imagen_placa = $row_placa['imagen'] ?? 'ruta/default/placa.jpg'; // Imagen predeterminada si no se encuentra

                    // Panel de rango
                    echo '<div class="panel panel-default" style="margin-bottom: 20px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">';
                    echo '<div class="panel-heading ' . htmlspecialchars($row_rango['color']) . '">';
                    echo '<h3 class="panel-title" style="font-size: 1.5em; font-weight: bold; margin: 0; display: flex; align-items: center;">';

                    // Agregamos la imagen de la placa en el contenedor-badge
                    echo '<div class="contedor-badge" style="background-image: url(\'' . htmlspecialchars($imagen_placa) . '\'); background-size: cover; width: 50px; height: 50px; margin-right: 10px;"></div>';
                    echo htmlspecialchars($row_rango['nombre']);
                    echo '</h3>';
                    echo '</div>';

                    echo '<div class="panel-body" style="background-color: #f8f9fa; padding: 15px;">';

                    // Obtenemos los usuarios del rango actual
                    $resultado_usuarios = $link->query("SELECT * FROM usuarios WHERE rank = $rank ORDER BY num_mision DESC");
                    while ($row_usuario = mysqli_fetch_array($resultado_usuarios)) {
                        // Obtenemos la imagen del fondo del perfil del usuario
                        $equipo_fondo_perfil_id = $row_usuario['fondo_perfil'];
                        $queryEquipoFondo = $link->query("SELECT imagen FROM tienda WHERE id = '$equipo_fondo_perfil_id'");
                        $rowEquipoFondo = mysqli_fetch_assoc($queryEquipoFondo);
                        $equipo_fondo_perfil_url = $rowEquipoFondo['imagen'] ?? '';

                        // Obtenemos el efecto del perfil del usuario
                        $equipo_efecto_perfil = $row_usuario['efecto_perfil'];
                        $queryEquipoEfecto = $link->query("SELECT imagen FROM tienda WHERE id = '$equipo_efecto_perfil'");
                        $rowEquipoEfecto = mysqli_fetch_assoc($queryEquipoEfecto);
                        $equipo_efecto_perfil_url = $rowEquipoEfecto['imagen'] ?? '';

                        switch($row_usuario['efecto_perfil']) {
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

                        echo '<div class="usercontenedor" 
                            style="
                                background-color: #ffffff;
                                border-radius: 8px;
                                padding: 10px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                text-align: center;
                                transition: transform 0.3s;
                            " 
                            onmouseover="this.style.transform=\'scale(1.05)\'" 
                            onmouseout="this.style.transform=\'scale(1)\'" 
                            onclick="showUserProfile(
                                \'' . htmlspecialchars($row_usuario['username']) . '\',
                                \'' . htmlspecialchars($row_usuario['avatar']) . '\',
                                \'' . htmlspecialchars($row_rango['nombre']) . '\',
                                \'' . htmlspecialchars($row_usuario['motto']) . '\',
                                \'' . htmlspecialchars($row_usuario['TAG']) . '\',
                                \'' . htmlspecialchars($row_usuario['AP']) . '\',
                                \'' . htmlspecialchars($equipo_fondo_perfil_url) . '\',
                                \'' . htmlspecialchars($equipo_efecto_perfil_url) . '\'
                            )">
                            <div class="userperfileindex" style="margin-bottom: 10px; border: none;">
                                <img src="' . htmlspecialchars($row_usuario['avatar']) . '" alt="" style="width: 64px; height: 110px; border-radius: 8px;">
                            </div>
                            <div class="nameuserperfil" style="font-weight: bold; color: #333;">
                                <a style="color: #333; text-decoration: none;" href="javascript:void(0);">' . htmlspecialchars($row_usuario['username']) . '</a>
                            </div>
                        </div>';
                    }

                    echo '</div>'; // Cierre de panel-body
                    echo '</div>'; // Cierre de panel
                }
            }
            ?>
        </div>
        <div class="col-md-4">
            <?php echo $cartel_radio; ?>
            <?php echo $cartel_publicidad; ?>
        </div>
    </div>
</div>

<script>
    function showUserProfile(username, avatar, rango, motto, tag, ap, fondoPerfil, efectoPerfil) {
    const otherProfileSection = document.getElementById('other-profile-section');
    otherProfileSection.classList.add('show');

    const profileInfo = document.getElementById('other-profile-info');
    profileInfo.innerHTML = `
        <li><span class="close-btn" onclick="toggleOtherProfile()">Cerrar ×</span><br></li>
        <div class="profile-header" style="background-image: linear-gradient(to left, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0)), url('${fondoPerfil}');">
            <div class="efecto-avatar" style="background-image: url('${efectoPerfil}');"></div>
            <img src="${avatar}" alt="Avatar" class="avatar">
            <span class="username">${username}</span>
        </div>
        <li><b>Rango: </b>${rango}</li>
        <li><b>Misión: </b>${motto}</li>
        <li><b>Firma: </b>${tag}</li>
        <li><b>Ascendido por: </b>${ap}</li>
    `;
}
</script>

<style>
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
        background-position: <?php echo $background_position; ?>;
        filter: <?php echo $filter; ?>;
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