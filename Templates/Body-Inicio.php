<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- Iniciar sesión en Index -->
            <?php
            $stmt = $link->prepare("SELECT * FROM config WHERE id = ?");
            $id = 1;
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado1 = $stmt->get_result();
            $row = $resultado1->fetch_assoc();
            $iniciar_sesion_op = $row['iniciar_sesion'] ?? 0;

            if ($iniciar_sesion_op == 0) {
                echo '
				<div class="panel panel-default">
					<div class="panel-heading oscuro">
						<h3 class="panel-title">' . $lang[24] . '</h3>
					</div>
					<div class="panel-body">
						<div class="loginindex">
							<span style="font-size:19px;color:red;"><center>Bloqueado</center></span>
							<br>
							<span style="font-size:16px;color:red;">' . $lang[26] . '</span>
						</div>
					</div>
				</div>
				<br>';
            } else {
                if ($_SESSION["logeado"] !== "SI") {
                    echo "
					<div class='panel panel-default'>
						<div class='panel-heading oscuro'>
							<h3 class='panel-title'>
								<div class='contedor-badge' style='background-image: url(\"https://images.habbo.com/c_images/album1584/PTB32.png\"); background-repeat: no-repeat; background-size: cover;'><div class='icon-login'></div></div> 
								$lang[24]
							</h3>
						</div>
						<div class='panel-body'>
							<div class='loginindex'>
								<form class='form form-signup' role='form' method='post' action='kernel/login/entrar.php'>
									<h5 class='colr bold mp'>$lang[27]</h5>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon'><span class='glyphicon glyphicon-user'></span></span>
											<input type='text' class='form-control' required name='username' id='username' placeholder='$lang[27]'/>
										</div>
									</div>
									<h5 class='colr bold mp'>$lang[28]</h5>
									<div class='form-group'>
										<div class='input-group'>
											<span class='input-group-addon'><span class='glyphicon glyphicon-lock'></span></span>
											<input type='password' id='password' required name='password' class='form-control' placeholder='$lang[28]'/>
										</div>
									</div>
									<a href='$url/recuperar.php' class='forgot'>$lang[29]</a>
									<input type='submit' name='Submit recordar' value='$lang[24]' class='btn btn-sm btn-primary btn-block loginbuttom'>
								</div>
							</div>
						</div>
						<br>";
                }
            }
            ?>

            <!-- Ultimas Placas subidas -->
            <div class="panel panel-default placas">
                <div class="panel-heading orange">
                    <h3 class="panel-title">
                        <div class='contedor-badge'
                            style="background-image:url('https://www.habbo.es/habbo-imaging/badge/b08134s86115s96114s80113t271111fd2ce747251db16d890f73b86a9cb03.gif'); background-repeat: no-repeat;">
                            <div class='icon-badges'></div>
                        </div>
                        <?php echo $lang[30]; ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="placas">
                        <?php
                        $stmt = $link->query("SELECT * FROM placas ORDER BY id DESC limit 16");
                        while ($row = $stmt->fetch_assoc()) {
                            echo "
							<div data-toggle='tooltip' title='" . $row['code'] . "' class='badgehabbink'>
								<div class='iconbadge'>
									<img src='" . $row['imagen'] . "' alt='' style='padding:7px;'>
								</div>
							</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <?php echo $cartel_publicidad; ?>

            <!--SORTEO SEMANAL -->

            <?php
            // Obtener datos del usuario actual desde la base de datos
            $stmt = $link->query("SELECT * FROM usuarios WHERE username = '" . $_SESSION['username'] . "'");
            $row = $stmt->fetch_assoc();

            if ($stmt->num_rows > 0) {
                $rango = $row['rank'];
                $participa_sorteo = $row['participa_sorteo'];
            }

            // Procesar la participación cuando se hace clic en el botón
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participar'])) {
                $username = $_SESSION['username'];
                $stmt_update = $link->query("UPDATE usuarios SET participa_sorteo = 1 WHERE username = '$username'");
                if ($stmt_update) {
                    // Actualizar la variable local para reflejar el cambio
                    $participa_sorteo = 1;
                }
            }

            // Comprobar rango y estado de participación para mostrar la sección del sorteo
            if (($rango >= 2 && $rango <= 9 || $dev == 1) && $participa_sorteo == 0) {
                echo '
    <div class="panel panel-default">
        <div class="panel-heading orange" style="padding: 15px; background-color: #FFA500; color: #fff;">
            <h3 class="panel-title" style="font-size: 1.5em; font-weight: bold;">
                <div class="contedor-badge" style="display: inline-block; background-image: url(\'https://images.habbo.com/c_images/album1584/SCH02.png\'); background-size: contain; background-repeat: no-repeat; width: 50px; height: 50px; vertical-align: middle;"></div>
                Participar en Sorteo Semanal
            </h3>
        </div>
        <div class="panel-body">
            <center>
                <form method="POST" action="index.php?sorteo">
                    <button type="submit" name="participar" class="btn btn-success">Participar en el Sorteo</button>
                </form>
            </center>
        </div>
    </div>
    ';
            } elseif ($participa_sorteo == 1) {
                // No mostrar el cuadro si el usuario ya está participando
            }
            ?>

            <!--FIN SORTEO SEMANAL -->


            <?php echo $week_worker_cartel; ?>
            <?php echo $cartel_radio; ?>

            <?php if ($_SESSION["logeado"] == "SI") {
                //echo $wordle;
            } ?>

        </div>
        <div class="col-md-8">
            <div class="no-celular">
                <!-- Promociones -->
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        <!--
                        <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="5"></li>
                         -->
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $stmt = $link->query("SELECT * FROM banner ORDER BY id DESC limit 6");
                        while ($row = $stmt->fetch_assoc()) {
                            echo "
							<div class='item " . $row['principal'] . "'>
								<img style='border-radius:10px;' src='" . $row['imagen'] . "' alt='" . $nameweb . "'>
								<div style='float:right;position: absolute;bottom: 0px;right: 0px;background-color: rgba(0, 0, 0, 0.42);width: 100%;border-radius: 0px 0px 10px 10px;padding: 15px;'>
								<!--	<a href='" . $row['url_promo'] . "'><input class='btn btn-warning' type='button' value='" . $lang[200] . "'></a> -->
								</div>
								<div class='textpromo'><b>" . $row['titulo'] . "</b><div class='textpromosmall'>" . $row['texto'] . "</div></div>
							</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>

            <!-- Top 10 semanal -->
            <?php
            // Consulta para obtener el top 10 de usuarios con más ascensos en la última semana
            $stmt = $link->query("
        SELECT l.usuario, COUNT(*) AS total_ascensos
        FROM logs_ascensos AS l
        JOIN usuarios AS u 
            ON CONVERT(l.usuario USING utf8mb3) COLLATE utf8mb3_unicode_ci = CONVERT(u.username USING utf8mb3) COLLATE utf8mb3_unicode_ci
        WHERE STR_TO_DATE(l.fecha, '%Y-%m-%d %H:%i:%s') >= '2024-12-18 22:00:00' 
        AND l.accion LIKE 'Ha ascendido%'
        AND u.rank < 9
        GROUP BY l.usuario
        ORDER BY total_ascensos DESC
        LIMIT 10;
    ");

            // Verificar si hay resultados
            if ($stmt->num_rows > 0) {
                echo '
    <div class="panel panel-default">
        <div class="panel-heading orange" style="padding: 15px; background-color: #FFA500; color: #fff;">
            <h3 class="panel-title" style="font-size: 1.5em; font-weight: bold;">
                <div class="contedor-badge" style="display: inline-block; background-image: url(\'https://www.habboassets.com/assets/badges/TC253.gif\'); background-size: contain; background-repeat: no-repeat; width: 50px; height: 50px; vertical-align: middle;"></div>
                Top Ascensos Semanales
            </h3>
        </div>
        <div class="panel-body" style="padding: 0;">
            <table class="table table-striped" style="
                width: 100%;
                border-collapse: collapse;
                font-family: Arial, sans-serif;
                background-color: #f7f9fc;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            ">
                <thead>
                    <tr>
                        <th style="background-color: #4a90e2; color: #ffffff; font-weight: bold; padding: 12px; text-align: center;">Posición</th>
                        <th style="background-color: #4a90e2; color: #ffffff; font-weight: bold; padding: 12px; text-align: center;">Usuario</th>
                        <th style="background-color: #4a90e2; color: #ffffff; font-weight: bold; padding: 12px; text-align: center;">Total de Ascensos</th>
                        <th style="background-color: #4a90e2; color: #ffffff; font-weight: bold; padding: 12px; text-align: center;">Recompensas</th>
                    </tr>
                </thead>
                <tbody>';

                // Inicializar la posición
                $posicion = 1;
                while ($row = $stmt->fetch_assoc()) {
                    // Asignar el número de lupas según la posición
                    $lupas = 1;
                    if ($posicion == 1) {
                        $lupas = 9;
                    } elseif ($posicion == 2) {
                        $lupas = 7;
                    } elseif ($posicion == 3) {
                        $lupas = 5;
                    }

                    // Mostrar la fila con colores y recompensas
                    echo "
            <tr style='background-color: " . ($posicion % 2 == 0 ? "#f1f1f1" : "#ffffff") . ";
                        transition: background-color 0.3s;'
                 onmouseover='this.style.backgroundColor=\"#e3f2fd\";'
                 onmouseout='this.style.backgroundColor=\"" . ($posicion % 2 == 0 ? "#f1f1f1" : "#ffffff") . "\";'>";

                    echo "<td style='padding: 10px; text-align: center; font-weight: bold; color: #4a90e2;'>{$posicion}</td>";
                    echo "<td style='padding: 10px; text-align: center;'>{$row['usuario']}</td>";
                    echo "<td style='padding: 10px; text-align: center;'>{$row['total_ascensos']}</td>";

                    // Columna de recompensas (imagen de lupa + cantidad)
                    echo "<td style='padding: 10px; text-align: center;'>
                <span style='margin-left: 5px; font-weight: bold; color: #333;'>{$lupas}</span>
                <img src='https://images.habbo.com/c_images/album1584/DE149.png' alt='Lupa' style='width: 20px; vertical-align: middle;'>
              </td>";

                    echo "</tr>";
                    $posicion++;
                }

                echo '        </tbody>
            </table>
        </div>
    </div>';
            }
            ?>

            <!-- Últimos Usuarios registrados -->
            <div class="panel panel-default"
                style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <div class="panel-heading oscuro" style="background-color: #333; color: #fff; padding: 15px;">
                    <h3 class="panel-title"
                        style="font-size: 1.5em; font-weight: bold; display: flex; align-items: center;">
                        <div class='contedor-badge'
                            style="background-image: url('https://images.habbo.com/c_images/album1584/VPV14.png'); background-size: contain; background-repeat: no-repeat; width: 50px; height: 50px; margin-right: 10px;">
                        </div>
                        <?php echo $lang[32]; ?>
                    </h3>
                </div>
                <div class="panel-body" style="background-color: #f5f5f5; padding: 20px;">
                    <div class="panel-users"
                        style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                        <?php
                        $stmt = $link->query("SELECT u.*, r.nombre AS rango_nombre 
                FROM usuarios u
                LEFT JOIN rangos r ON u.rank = r.id 
                ORDER BY u.id DESC 
                LIMIT 6");
                        while ($row_inicio = $stmt->fetch_assoc()) {
                            $username = $row_inicio['username'];
                            $avatar = $row_inicio['avatar'];
                            $rango_nombre = $row_inicio['rango_nombre'];

                            $inicio_fondo_perfil_id = $row_inicio['fondo_perfil'];
                            $queryInicioFondo = $link->query("SELECT imagen FROM tienda WHERE id = '$inicio_fondo_perfil_id'");
                            $rowInicioFondo = mysqli_fetch_assoc($queryInicioFondo);
                            $inicio_fondo_perfil_url = $rowInicioFondo['imagen'] ?? '';

                            // Obtenemos el efecto del perfil del usuario
                            $inicio_efecto_perfil = $row_inicio['efecto_perfil'];
                            $queryInicioEfecto = $link->query("SELECT imagen FROM tienda WHERE id = '$inicio_efecto_perfil'");
                            $rowIncioEfecto = mysqli_fetch_assoc($queryInicioEfecto);
                            $inicio_efecto_perfil_url = $rowInicioEfecto['imagen'] ?? '';

                            switch ($row_inicio['efecto_perfil']) {
                                case 10:
                                    // Kitsune
                                    $background_image = "url('https://i.imgur.com/y4NfCTE.png')";
                                    $background_position = 'bottom 15px left -15%';
                                    $background_size = '30%';
                                    $filter = 'none';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
                                    break;
                                case 11:
                                    // Dragón
                                    $background_image = "url('https://i.imgur.com/hY0q1jC.png')";
                                    $background_position = 'bottom 90% left 20%';
                                    $filter = 'none ';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
                                    break;
                                case 12:
                                    // Conejo Dorado
                                    $background_image = "url('https://i.imgur.com/KU4CEGT.png')";
                                    $background_position = 'bottom 50% left 15%';
                                    $filter = 'none';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
                                    break;
                                case 13:
                                    // Gato Morado
                                    $background_image = "url('https://i.imgur.com/iryhcxk.png')";
                                    $background_position = 'bottom 50% left 5%';
                                    $filter = 'none';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
                                    break;
                                case 14:
                                    // Mostrador supermercado
                                    $background_image = "url('https://i.imgur.com/ZFS64Q1.png')";
                                    $background_position = 'bottom 0% left 0%';
                                    $filter = 'none';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
                                    break;
                                case 15:
                                    // Taxi
                                    $background_image = "url('https://i.imgur.com/mBKVPmc.gif')";
                                    $background_position = 'bottom 70% left -20%';
                                    $filter = 'none';
                                    $z_index = '0';

                                    $row_inicio['avatar'] = "https://www.habbo.es/habbo-imaging/avatarimage?user=" . urlencode($username) . "&direction=2&head_direction=2&action=,sit&gesture=nrm&size=m&size=b";
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
                        \'' . htmlspecialchars($row_inicio['username']) . '\',
                        \'' . htmlspecialchars($row_inicio['avatar']) . '\',
                        \'' . htmlspecialchars($row_inicio['rango_nombre'] ?: 'Sin rango') . '\',
                        \'' . htmlspecialchars($row_inicio['motto'] ?: 'Sin misión') . '\',
                        \'' . htmlspecialchars($row_inicio['TAG'] ?: 'Sin firma') . '\',
                        \'' . htmlspecialchars($row_inicio['AP'] ?: 'Sin UA') . '\',
                        \'' . htmlspecialchars($inicio_fondo_perfil_url) . '\',
                        \'' . htmlspecialchars($inicio_efecto_perfil_url) . '\'
                    )">
                    <div class="userperfileindex" style="border:none;">
                    <img src="' . htmlspecialchars($avatar) . '" alt="">
                    </div>
                    <div class="nameuserperfil">' . htmlspecialchars($username) . '</div>
                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<style>
    .panel.panel-default.placas {
        width: 80%;
    }

    .letter-box {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        font-size: 18px;
        font-weight: bold;
        color: white;
        text-align: center;
        margin: 2px;
        border-radius: 5px;
    }

    .letter-box.green {
        background-color: #28a745;
    }

    .letter-box.yellow {
        background-color: #ffc107;
    }

    .letter-box.grey {
        background-color: #6c757d;
    }

    #attempts-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Centra todos los intentos horizontalmente */
    }

    #wordle-input {
        display: inline-block;
        margin: 10px 0;
    }
</style>


<script>
    const wordOfTheDay = 'MAGIA'; // Palabra que el jugador tiene que adivinar
    const maxAttempts = 6; // Número máximo de intentos

    // Variables que almacenan el estado actual
    let attempts = 0;
    let hasGuessedCorrectly = false;

    // Recupera el estado del juego desde localStorage
    function loadGameState() {
        const savedState = JSON.parse(localStorage.getItem('wordle-state'));

        if (savedState) {
            attempts = savedState.attempts;
            hasGuessedCorrectly = savedState.hasGuessedCorrectly;

            // Cargar intentos previos
            const attemptsContainer = document.getElementById('attempts-container');
            savedState.attemptsData.forEach((entry) => {
                const attemptRow = document.createElement('div');
                entry.forEach((letterData) => {
                    const letterBox = document.createElement('span');
                    letterBox.classList.add('letter-box', letterData.color);
                    letterBox.textContent = letterData.letter;
                    attemptRow.appendChild(letterBox);
                });
                attemptsContainer.appendChild(attemptRow);
            });

            // Si ya adivinó la palabra, mostrar mensaje y deshabilitar el input
            if (hasGuessedCorrectly) {
                document.getElementById('wordle-feedback').innerHTML = '¡Felicidades! Adivinaste la palabra.';
                document.getElementById('wordle-input').disabled = true;
                document.getElementById('submit-button').disabled = true;
            }
        }
    }

    // Guarda el estado del juego en localStorage
    function saveGameState() {
        const attemptsData = {
            attempts: attempts,
            hasGuessedCorrectly: hasGuessedCorrectly,
            attemptsData: [] // Array para guardar los intentos con sus colores
        };

        const attemptRows = document.querySelectorAll('#attempts-container > div');
        attemptRows.forEach((row) => {
            const wordData = [];
            row.querySelectorAll('.letter-box').forEach((box) => {
                wordData.push({
                    letter: box.textContent,
                    color: box.classList.contains('green') ? 'green' :
                        box.classList.contains('yellow') ? 'yellow' : 'grey'
                });
            });
            attemptsData.attemptsData.push(wordData);
        });

        // Guardar en localStorage
        localStorage.setItem('wordle-state', JSON.stringify(attemptsData));
    }

    // Función que comprueba si la palabra es correcta
    function checkWordle() {
        const input = document.getElementById('wordle-input').value.toUpperCase();
        const feedback = document.getElementById('wordle-feedback');
        const attemptsContainer = document.getElementById('attempts-container');

        // No se permiten intentos si ya se adivinó la palabra o si alcanzamos el límite de intentos
        if (attempts >= maxAttempts || hasGuessedCorrectly) {
            feedback.innerHTML = '<center>Juego terminado. La palabra era: ' + wordOfTheDay + '</center>';
            return;
        }

        // Validar que el input tenga 5 letras
        if (input.length !== 5) {
            feedback.innerHTML = '<center>La palabra debe tener 5 letras.</center>';
            return;
        }

        attempts++; // Incrementamos el intento
        const attemptRow = document.createElement('div');

        // Evaluar cada letra e identificar el color (verde, amarillo, gris)
        const letterData = [];
        for (let i = 0; i < 5; i++) {
            const letterBox = document.createElement('span');
            letterBox.classList.add('letter-box');

            let color = '';
            if (input[i] === wordOfTheDay[i]) {
                color = 'green';
            } else if (wordOfTheDay.includes(input[i])) {
                color = 'yellow';
            } else {
                color = 'grey';
            }

            letterBox.classList.add(color);
            letterBox.textContent = input[i];
            letterData.push({ letter: input[i], color: color });
            attemptRow.appendChild(letterBox);
        }

        // Agregar el intento al contenedor de intentos
        attemptsContainer.appendChild(attemptRow);

        // Guardar el estado del juego
        saveGameState();

        // Limpiar el campo de entrada
        document.getElementById('wordle-input').value = '';

        // Verificar si el jugador adivinó la palabra
        if (input === wordOfTheDay) {
            feedback.innerHTML = '¡Felicidades! Adivinaste la palabra.';
            hasGuessedCorrectly = true;
            document.getElementById('wordle-input').disabled = true;
            document.getElementById('submit-button').disabled = true;
        } else if (attempts === maxAttempts) {
            feedback.innerHTML = 'Juego terminado. La palabra era: ' + wordOfTheDay;
        } else {
            feedback.innerHTML = '';
        }
    }

    // Cargar el estado del juego cuando la página se recarga o al abrir la página
    window.onload = loadGameState;

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