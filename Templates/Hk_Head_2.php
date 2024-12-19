
<?php
require ('../../global.php');
session_start();
if($_SESSION["logeado"] != "SI"){
header ("Location: ../../index");
exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo"$meta"; ?>

<title><?php echo $lang[268]; ?> - <?php echo"$nameweb"; ?></title>

<!-- Favicon -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../../images/favicon.ico">
<link rel="shortcut icon" href="../../images/favicon.ico">
<link rel="shortcut icon" href="../../images/favicon.ico">
<!-- Cierre de Favicon -->

    <!-- // Stylesheets // -->
    <link href="../../styles/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<script src="../../styles/js/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../stylescss/sweetalert.css">
<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body class="body-xmas">


  <div style='position: relative;margin-left: 20px'>

  <div class="idioma"><a href='<?php echo $url; ?>/?lang=es'><center><img data-toggle="tooltip" title='Español' src='<?php echo $url; ?>/images/es.png'></a></center></div>

  <div class="idioma"><a href='<?php echo $url; ?>/?lang=en'><center><img data-toggle="tooltip" title='English' src='<?php echo $url; ?>/images/en.png'></a></center></div>

  <!--  <div class="idioma"><a href='<?php echo $url; ?>/?lang=br'><center><img data-toggle="tooltip" title='Portugues' src='<?php echo $url; ?>/images/br.png'></a></center></div> -->

 </div>

 <style>
    /* Animación de cambio de color Halloween */
    @keyframes colorTransitionHalloween {
        0%, 100% {
            background-color: #6a0dad; /* Color inicial y final */
        }
        50% {
            background-color: #1a1a1a; /* Color oscuro a la mitad */
        }
    }

    @keyframes colorTransitionFall {
        0%, 100% {
            background-color: orange; /* Color inicial y final */
        }
        50% {
            background-color: #1a1a1a; /* Color oscuro a la mitad */
        }
    }

    @keyframes colorTransitionXmas {
        0%, 100% {
            background-color: red; /* Color inicial y final */
        }
        50% {
            background-color: white;
        }
    }

    body{
      user-select:none;
      -webkit-user-select:none; 
      -moz-user-select:none; 
      -ms-user-select:none;
    }
    
    .body-halloween{
      background-color:orange; 
      background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../../images/halloween_bg.png');
      background-size:cover;
      background-position:center;
      animation: colorTransitionHalloween 4s ease-in-out infinite; /* Cambia cada 4 segundos */
      transition: background-color 2s ease; /* Transición */
    }

    .body-fall{
      background-color:black; 
      background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../../images/fall_bg.png');
      background-size:cover;
      background-position:center;
      animation: colorTransitionFall 4s ease-in-out infinite; /* Cambia cada 4 segundos */
      transition: background-color 2s ease; /* Transición */
    }

    .body-xmas{
      background-color:white; 
      background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://i.imgur.com/zRpymft.png');
      background-size:cover;
      background-position:center;
      animation: colorTransitionXmas 4s ease-in-out infinite; /* Cambia cada 4 segundos */
      transition: background-color 2s ease; /* Transición */
    }
</style>