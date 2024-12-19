<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo"$meta"; ?>

<title><?php echo"$nameweb"; ?></title>

<!-- Favicon -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../images/favicon.ico">
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="shortcut icon" href="../images/favicon.ico">
<!-- Cierre de Favicon -->

    <!-- // Stylesheets // -->
    <!--<link href="styles/css/styles.css" rel="stylesheet" type="text/css">--> 
    <link href="styles/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/css/sweetalert.css">

<?php 
if($utilidad_fonts == 1){
?>
<script type="text/javascript">
function Toggle(div_id){
    var div = document.getElementById(div_id);
    if(div.style.display == "block")
    {
        div.style.display = 'none';
    } else {
        div.style.display = 'block';
    }
  if(div == "overlay") {
    scroll(0,0);
  }
}

function Show(div_id){
    var div = document.getElementById(div_id);
    if(div.style.display == "none")
    {
        div.style.display = 'block';
    }
}

function Hide(div_id){
    var div = document.getElementById(div_id);
    if(div.style.display == "block")
    {
        div.style.display = 'none';
    }
}
</script>
<style type="text/css">
a {
  color:#FFF;
  cursor:pointer;
  text-decoration:none;
}

a:hover {
  text-decoration:underline;
}

#top {
  width:100%; 
  position:fixed; 
  top:0; 
  left:0; 
  height:78px; 
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

#header {
  width:100%;
  height:250px;
  background:url(http://hsource.fr/font//images/bg_skyline_of_london.gif) center -290px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
  box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

#header_lay_01 {
  width:100%;
  height:250px;
  background:url(http://hsource.fr/font//images/topfloor.png) center bottom repeat-x;
}

#header_lay_02 {
  width:100%;
  height:250px;
  background:url(http://hsource.fr/font//images/header_layer.gif) center bottom repeat-x;
}

#header_lay_04 {
  background:url(http://hsource.fr/font//images/black_60.png);
  border:hidden;
  border-radius: 4px; 
  -webkit-border-radius: 4px; 
  -moz-border-radius: 4px;
  color:#FFF;
  margin:10px;
  padding:5px;
  max-width:455px;
  float:left;
}

textarea {
  background:#F7F7F7;
  color:#666;
  font-family:Verdana, Geneva, sans-serif;
  padding:5px;
  border: 1px #999 solid;
  border-radius: 4px; 
  -webkit-border-radius: 4px; 
  -moz-border-radius: 4px;
}

textarea:focus {
  color:#000;
}

input[type="text"] {
  background:#F7F7F7;
  color:#666;
  font-family:Verdana, Geneva, sans-serif;
  padding:5px; 
  padding-top:4px;
  padding-bottom:4px;
  border: 1px #CCC solid;
  border-radius: 4px; 
  -webkit-border-radius: 4px; 
  -moz-border-radius: 4px;
}

input[type="text"]:focus {
  color:#000;
}

textarea {
  background:#F7F7F7;
  color:#666;
  font-family:Verdana, Geneva, sans-serif;
  padding:5px; 
  padding-top:4px;
  padding-bottom:4px;
  border: 1px #CCC solid;
  border-radius: 4px; 
  -webkit-border-radius: 4px; 
  -moz-border-radius: 4px;
}

textarea:focus {
  color:#000;
}

.box_top {
  float:left;
  margin-top:5px;
  height:5px;
}

.box_top_918 {
  background-image:url(http://hsource.fr/font//images/box_top_918.png);
  width:918px;
}

.box_top_148 {
  background-image:url(http://hsource.fr/font//images/box_top_148.png);
  width:148px;
}
  
.box_center {
  float:left;
  background-image:url(http://hsource.fr/font//images/box_center.png);
  background-position:right;
  background-repeat:repeat-y;
  padding-left:5px;
  padding-right:7px;
}

.box_center_918 {
  width:918px;
}

.box_center_148 {
  width:148px;
}

.box_bottom {
  float:left;
  height:7px;
}

.box_bottom_918 {
  background-image:url(http://hsource.fr/font//images/box_bottom_918.png);
  width:918px;
}

.box_bottom_148 {
  background-image:url(http://hsource.fr/font//images/box_bottom_148.png);
  width:148px;
}
/* TOP - BACKGROUNDS */
.top_bg_10 {
  background-image:url(http://hsource.fr/font//boxes_background_R001.png);
  background-position:right -235px;
  color:#FFF;
}
/* TOP - WIDTH */
.top_918 {
  border:1px hidden; 
  border-radius: 4px; 
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;  
  width:906px; 
  padding:5px; 
  max-height:25px; 
  overflow:hidden;
    font-weight:bold;
}
.top_148 {
  border:1px hidden; 
  border-radius: 4px; 
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;  
  width:136px; 
  padding:5px; 
  max-height:25px; 
  overflow:hidden;
    font-weight:bold;
}

#show_div {
   width:500px; 
   position:absolute; 
   z-index:99999999999; 

   left:50%; 
   top:50%; 
   margin-left:-250px; 
   margin-top:-175px; 
   border:5px #0e84ab solid; 
   border-radius: 4px; 
   -webkit-border-radius: 4px; 
   -moz-border-radius: 4px; 
   background-color:#F5F5F5;
   display:none;
}

#show_img {
  width:100%;
  height: 100%;
  position: absolute;
  background-color:none;
  display:none;
  z-index:99999999999;
  float:left;
  left:0;
  top:0;
  margin:auto;
  text-align:center;
  vertical-align:middle;
}
</style>
<?php } ?>

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {"message":"Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web","dismiss":"Acepto los terminos","learnMore":"Más información","link":"","theme":"light-floating"};
</script>
<!-- End Cookie Consent plugin -->

  </head>
  <body class="body-xmas">

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.8&appId=849796585153602";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

  <div style='position: relative;margin-left: 20px'>

  <div class="idioma"><a href='<?php echo $url; ?>/?lang=es'><center><img data-toggle="tooltip" title='Español' src='<?php echo $url; ?>/images/es.png'></a></center></div>

 <div class="idioma"><a href='<?php echo $url; ?>/?lang=en'><center><img data-toggle="tooltip" title='English' src='<?php echo $url; ?>/images/en.png'></a></center></div>

 </div>

<style>
    /* Animación de cambio de color Halloween */
    @keyframes colorTransitionHalloween {
        0%, 100% {
            background-color: #6a0dad; /* Color inicial y final */
        }
        50% {
            background-color: #1a1a1a;
        }
    }

    @keyframes colorTransitionFall {
        0%, 100% {
            background-color: orange; /* Color inicial y final */
        }
        50% {
            background-color: #1a1a1a;
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
      background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../images/halloween_bg.png');
      background-size:cover;
      background-position:center;
      animation: colorTransitionHalloween 4s ease-in-out infinite; /* Cambia cada 4 segundos */
      transition: background-color 2s ease; /* Transición */
    }

    .body-fall{
      background-color:black; 
      background-image:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('../images/fall_bg.png');
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