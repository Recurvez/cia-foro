<?php 

include ('kernel/config.php');


$resultado = $link->query("SELECT * FROM config WHERE id = 1");
  while($row = mysqli_fetch_array($resultado))
  {
$nameweb = $row['nameweb'];
$url = $row['url'];
$facebook = $row['facebook'];
$discord = $row['discord'];
$facebookimg = $row['facebookimg'];
$descripcion = $row['descripcion'];
$pclaves = $row['pclaves'];
$logo = $row['logo'];
$publicidac_cartel = $row['publicidad'];
$publicidad_code = $row['codigo'];
$iniciar_sesion_op = $row['iniciar_sesion'];
$registro_op = $row['registro'];
$mantenimiento = $row['mantenimiento'];
$radio_coder = $row['radio'];
$nombre_radio = $row['nombre_radio'];
$radio_op = $row['radio_op'];
}

if (isset($_GET['lang'])) {
  setcookie("idioma", $_GET['lang'], time()+3600); 
    include ('kernel/langs/'.$_GET['lang'].'.php');
}

if (empty($_GET['lang'])) {
  if (isset($_COOKIE["idioma"])) {
    include ('kernel/langs/'.$_COOKIE["idioma"].'.php');
  } else {
    include ('kernel/langs/'.$language.'.php');
  }
}


$meta = "<meta name='viewport' content='width=device-width, initial-scale=1'>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet' type='text/css'>
<meta property='og:locale' content='es_ES'/>
<meta property='og:type' content='website'/>
<meta property='og:title' content='$nameweb'/>
<meta property='og:description' content='$descripcion'/>
<meta property='og:url' content='$url'/>
<meta property='og:site_name' content='$nameweb'/>
<meta property='og:image' content='$facebookimg'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv='Content-Language' content='es'/>
<meta name='Keywords' content='$pclaves'/>
<meta name='Description' content='$descripcion'/>
<meta name='Distribution' content='global'/>
<meta name='Robots' content='all'/>";


// Consulta para obtener el usuario con week_worker activado
$result = $link->query("SELECT username, motto, avatar FROM usuarios WHERE week_worker = 1 LIMIT 1");

if ($result && $row = mysqli_fetch_assoc($result)) {
  // Generar el HTML del cartel si hay un usuario con week_worker activado
  $week_worker_cartel = "
    <style>
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }

        .flotar-imagen {
            animation: float 4s ease-in-out infinite;
            margin-bottom: 10%;
            margin-left: 30%;
        }
    </style>
    <div class='panel panel-default' style='height:auto;'>
        <div class='panel-heading blue'>
            <h3 class='panel-title' style='display: flex; align-items: center;'>
                <div class='contedor-badge' style='background-image:url(\"https://www.habbo.es/habbo-imaging/badge/b08134t14011s89115s79114s931132bf1d4e51a2bbfa7ea9462bdcaabd935.gif\"); background-size:cover;background-repeat:no-repeat; width: 40px; height: 40px;'></div>
                <span style='margin-left: 10px;'>Trabajador de la Semana</span>
            </h3>
        </div>
        <div style='overflow: hidden; height:auto;' class='panel-body'>
            <div style='display: flex; flex-direction: column; align-items: center;'>
                <img src='{$row['avatar']}' alt='Avatar de {$row['username']}' width='100' height='150' class='flotar-imagen' style='border-radius: 5px;'>
                <div style='text-align: center;'>
                    <strong>Usuario:</strong> {$row['username']}<br>
                    <strong>Misión:</strong> {$row['motto']}
                </div>
            </div>
        </div>
    </div><br>";

    
    // Mostrar el cartel en la página solo si hay un usuario con week_worker
    // echo $week_worker_cartel;
}

if("$publicidac_cartel"=="1"){
  $cartel_publicidad = "<div class='panel panel-default'>
            <div class='panel-heading red'>
              <h3 class='panel-title'><div class='contedor-badge' style='background-image:url(\"https://www.habbo.es/habbo-imaging/badge/b08134t14011s89115s79114s931132bf1d4e51a2bbfa7ea9462bdcaabd935.gif\"); background-size:cover;background-repeat:no-repeat;'><div class='icon-publicidad'></div></div> $lang[37]</h3>
            </div>
            <div style='overflow: hidden;' class='panel-body'>
            <div><div><div><div><div>
           <CENTER>$publicidad_code</CENTER>
           </div></div></div></div></div>
			  </div>
          </div><br>";
}else{
  $cartel_publicidad = " ";
}

if("$radio_op"=="1"){
  $cartel_radio = "<div class='visible-desktop'>
      <div class='panel panel-default' style='border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
          <div class='panel-heading blue' style='color: white; padding: 15px;'>
              <h3 class='panel-title' style='display: flex; align-items: center;'>
                  <div class='contedor-badge' style='background-image:url(\"https://images.habbotemplarios.com/2017/06/FRC46.gif\"); background-size:cover;background-repeat:no-repeat; width: 40px; height: 40px; border-radius: 50%;'></div>
                  <span style='margin-left: 10px;'>$nombre_radio</span>
              </h3>
          </div>
          <div class='panel-body' style='padding: 20px; background-color: #fff;'>
            <CENTER>
                <audio id='audioPlayer' autoplay style='display:none;'>
                    <source src='$radio_coder' type='audio/mpeg'>
                    Tu navegador no soporta el elemento de audio.
                </audio>
                
                <div class='custom-controls' style='display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 20px;'>
                  <button onclick='togglePlayPause(event)' id='playPauseBtn' style='background-color: #1198D2; border: none; border-radius: 5px; color: white; padding: 10px 15px; cursor: pointer; transition: background 0.3s;'>
                      <i class='fa fa-play'></i>
                  </button>
                    <input type='range' id='volumeControl' min='0' max='1' step='0.1' onchange='setVolume(this.value)' style='width: 100px;'>
                </div>
                
                <div class='cover-album' id='currentCoverArt' style='margin-top: 20px;'>
                    <!-- Aquí puedes agregar una imagen de portada, si lo deseas -->
                </div>
                <p id='currentSong' style='margin-top: 15px; font-weight: bold;'>Canción: </p>
                <p id='currentArtist' style='font-style: italic;'>Artista: </p>
            </CENTER>
          </div>
      </div>
  </div><br>";

  // Agregar el script para manejar la reproducción, la información de la canción y la persistencia del volumen
  $cartel_radio .= "<script>
      const url = 'https://api.zeno.fm/mounts/metadata/subscribe/kgtunl22w1ouv';
      const audio = document.getElementById('audioPlayer');
      const playPauseBtn = document.getElementById('playPauseBtn');
      const volumeControl = document.getElementById('volumeControl');

      // Conectar con la fuente de eventos para la metadata
      connectToEventSource(url);

      function connectToEventSource(url) {
          const eventSource = new EventSource(url);
          eventSource.addEventListener('message', function(event) {
              processData(event.data);
          });
          eventSource.addEventListener('error', function(event) {
              console.error('Error en la conexión de eventos:', event);
          });
      }

      function processData(data) {
          const parsedData = JSON.parse(data);
          if (parsedData.streamTitle) {
              let artist, song;
              const streamTitle = parsedData.streamTitle;

              if (streamTitle.includes('-')) {
                  [artist, song] = streamTitle.split(' - ');
              } else {
                  artist = '';
                  song = streamTitle;
              }

              document.getElementById('currentSong').innerText = 'Canción: ' + song.trim();
              document.getElementById('currentArtist').innerText = 'Artista: ' + artist.trim();
          }
      }

      // Función de reproducción/pausa
      function togglePlayPause(event) {
          event.preventDefault();
          if (audio.paused) {
              audio.play();
              playPauseBtn.innerHTML = '<i class=\"fa fa-pause\"></i>';
          } else {
              audio.pause();
              playPauseBtn.innerHTML = '<i class=\"fa fa-play\"></i>';
          }
      }

      // Función para ajustar el volumen y guardarlo en localStorage
      function setVolume(volume) {
          audio.volume = volume;
          localStorage.setItem('userVolume', volume); // Guardar el volumen en localStorage
      }

      // Cargar el volumen guardado al cargar la página
      window.addEventListener('load', () => {
          const savedVolume = localStorage.getItem('userVolume');
          if (savedVolume !== null) {
              volumeControl.value = savedVolume;
              audio.volume = savedVolume;
          } else {
              volumeControl.value = 0.2; // Valor por defecto si no hay nada guardado
              audio.volume = 0.2;
          }
      });
  </script>";
} else {
  $cartel_radio = " ";
}




$redes_sociales = "<div class='panel panel-default'>
        <div class='panel-heading red'>
          <h3 class='panel-title'>
            <div class='contedor-badge' style='background-image:url(\"https://images.habbo.com/c_images/album1584/FR46B.png\"); background-size:cover;background-repeat:no-repeat;'>
              <div class='icon-redes-sociales'></div>
            </div> 
            $lang[31]
          </h3>
        </div>
        <div class='panel-body'>
          <!-- Widget de Twitter -->
          <a class='twitter-timeline' 
             data-width='400' 
             data-height='600' 
             data-theme='light' 
             data-lang='es'
             href='$facebook'>Tweets by HabboEsCIA</a>
          <script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script>
<br>
          <!-- Enlace a Discord -->


        </div>
      </div>";

$wordle ="<div class='panel panel-default'>
    <div class='panel-heading red'>
        <h3 class='panel-title'>
            <div class='contedor-badge' style='background-image:url(\"https://images.habbo.com/c_images/album1584/EXE_HHSG.png\"); background-size:cover;background-repeat:no-repeat;'>
              <div class='icon-redes-sociales'></div>
            </div> 
            Wordle Diario
        </h3>
    </div>
    <div class='panel-body'>
        <div id='wordle-container'>
            <input type='text' id='wordle-input' maxlength='5' placeholder='Introduce una palabra de 5 letras' style='width: 100%; padding: 10px; margin-bottom: 10px;' />
            <button onclick='checkWordle()' style='width: 100%; padding: 10px; background-color: #28a745; color: white; border: none;'>Intentar</button>
            <div id='attempts-container' style='margin-top: 20px;'></div>
            <div id='wordle-feedback' style='margin-top: 10px;'></div>
        </div>
    </div>
</div>";

// Configuración Hk
   $resultado = $link->query("SELECT * FROM rangos WHERE id = 12");
  while($row=mysqli_fetch_array($resultado))
{
$rango12 = "12";
$rango_12 = $row['nombre'];
} 
   $resultado = $link->query("SELECT * FROM rangos WHERE id = 11");
  while($row=mysqli_fetch_array($resultado))
{
$rango11 = "11";
$rango_11 = $row['nombre'];
} 
   $resultado = $link->query("SELECT * FROM rangos WHERE id = 10");
  while($row=mysqli_fetch_array($resultado))
{
$rango10 = "10";
$rango_10 = $row['nombre'];
} 
   $resultado = $link->query("SELECT * FROM rangos WHERE id = 9");
  while($row=mysqli_fetch_array($resultado))
  {
$rango9 = "9";
$rango_9 = $row['nombre'];
  } 
  
   $resultado = $link->query("SELECT * FROM rangos WHERE id = 8");
  while($row=mysqli_fetch_array($resultado))
  {
$rango8 = "8";
$rango_8 = $row['nombre'];
  }

   $resultado = $link->query("SELECT * FROM rangos WHERE id = 7");
  while($row=mysqli_fetch_array($resultado))
  {
$rango7 = "7";
$rango_7 = $row['nombre'];
  }

   $resultado = $link->query("SELECT * FROM rangos WHERE id = 6");
  while($row=mysqli_fetch_array($resultado))
  {
$rango6 = "6";
$rango_6 = $row['nombre'];
  }

   $resultado = $link->query("SELECT * FROM rangos WHERE id = 5");
  while($row=mysqli_fetch_array($resultado))
  {
$rango5 = "5";
$rango_5 = $row['nombre'];
  }
  
// Cierre de configuración



    $editor = "
      <!-- Include Font Awesome. -->
  <link href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />

  <!-- Include Editor style. -->
  <link href='$url/hk/froala/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
  <link href='$url/hk/froala/css/froala_style.min.css' rel='stylesheet' type='text/css' />

  <!-- Include Code Mirror style -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css'>

  <!-- Include Editor Plugins style. -->
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/char_counter.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/code_view.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/colors.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/emoticons.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/file.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/fullscreen.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/image.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/image_manager.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/line_breaker.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/quick_insert.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/table.css'>
  <link rel='stylesheet' href='$url/hk/froala/css/plugins/video.css'>";

    $editorjs = "
  <!-- Include jQuery. -->
  <script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>

  <!-- Include JS files. -->
  <script type='text/javascript' src='$url/hk/froala/js/froala_editor.min.js'></script>

  <!-- Include Code Mirror. -->
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js'></script>
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js'></script>

  <!-- Include Plugins. -->
  <script type='text/javascript' src='$url/hk/froala/js/plugins/align.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/char_counter.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/code_beautifier.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/code_view.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/colors.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/emoticons.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/entities.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/file.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/font_family.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/font_size.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/fullscreen.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/image.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/image_manager.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/inline_style.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/line_breaker.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/link.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/lists.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/paragraph_format.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/paragraph_style.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/quick_insert.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/quote.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/table.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/save.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/url.min.js'></script>
  <script type='text/javascript' src='$url/hk/froala/js/plugins/video.min.js'></script>

  <!-- Include Language file if we want to use it. -->
  <script type='text/javascript' src='$url/hk/froala/js/languages/es.js'></script>
    
    <script>
  $(function() {
    $('#edit').froalaEditor({
      language: 'es'
    })
  });
</script>

  <!-- Initialize the editor. -->
  <script>
      $(function() {
          $('#edit').froalaEditor()
      });
  </script>";

  if ($nameweb == 'Habbink') {

    header('Location: https://www.habbink.gq/index?derechos-de-autor');
  
  }
?>

