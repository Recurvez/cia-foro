<?php

// Servidor host
$dbhost 		= "sql112.infinityfree.com"; 

// Usuario user
$dbusername 	= "if0_37488126";		 

// Contraseña , password	
$dbuserpass 	= "makeciagreat"; 	

// Nombre de base de datos db
$dbname 		= "if0_37488126_foro"; 

// Codigo de contador de usuarios
$contador = 'rg0uvc6goful';

$language = 'es'; // es -> español | en -> english | br -> Portugues


// ---------------------------------------------

// Aqui se establece la zona horaria del sitio web

date_default_timezone_set("Europe/Madrid");

//-------------------------------------------------


// Aqui haremos la conexion mysqli hacia la base de datos para poder guardas y mostrar los datos de la web.

    $link = mysqli_connect($dbhost, $dbusername, $dbuserpass, $dbname);
    if(!$link){
        die("imposible conectarse: ".mysqli_error($link));
    }
    if (mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
        $link = mysqli_connect($dbhost, $dbusername, $dbuserpass, $dbname);
    }

    $link->set_charset("utf8");

    session_start();

    error_reporting(E_ALL ^ E_NOTICE);

// ----------------------------------------------------------------------------------------------------------

// Comprobamos si hay cookie, si está bien y le asignamos una sesión
// Esto quiere decir que si recordamos la contraseña nos auto loguee.

if(isset($_COOKIE['id_extreme']))
{
	$cookie = htmlentities($_COOKIE['id_extreme']);
	$cookie = explode("%",$cookie);
	$user = $cookie[0];
	$id = $cookie[1];
	$ip = $cookie[2];

	if ($_SERVER["REMOTE_ADDR"] == "")
	{
		$ip2 = getenv(REMOTE_ADDR);
	}
	else
	{
		$ip2 = getenv(HTTP_X_FORWARDED_FOR);
	}
	if($ip == $ip2)
	{
		$query = $link->query("SELECT * FROM usuarios WHERE id_extreme='".$id."' and username='".$user."'") or die(mysqli_error());
   		$row = mysqli_fetch_array($query);
   		if(isset($row['username']))
		{
		$_SESSION["username"] = $row['username'];
		$_SESSION["logeado"] = "SI";
		$username = $_SESSION['username'];
        $usuario_activo = $_SESSION['username'];
   		}
		mysqli_close($link);
	}
}

		$username = $_SESSION['username'];
        $usuario_activo = $_SESSION['username'];

// ---------------------------------------------------------------------------

// Esto tomara la ip del visitante con esto se haran funciones que sea necesaria la ip

$ip_actual = $_SERVER["REMOTE_ADDR"];

// ---------------------------------------------------------------------------

$ban_user_online = '';

 $resultado = $link->query("SELECT * FROM config WHERE id = 1");
  while($row = mysqli_fetch_array($resultado))
  {
$mantenimiento = $row['mantenimiento'];
$url_config = $row['url'];
  }

  if("$mantenimiento" == "1"){
header ("Location: $url_config/mantenimiento.php");
  }

$resultado = $link->query("SELECT * FROM usuarios WHERE username = '$username'");
 while($row = mysqli_fetch_array($resultado))
{
	$ban_user_online = $row['ban'];
	$ban_fecha_final = $row['ban_f'];
	$ban_fecha_inicio = $row['ban_i'];
}

$resultado = $link->query("SELECT * FROM baneo WHERE usuario = '$username'");
 while($row = mysqli_fetch_array($resultado))
{
	$ban_fecha_final_baneo = $row['ban_f'];
	$ban_fecha_inicio_baneo = $row['ban_i'];
	$ban_razon_baneo = $row['razon'];
}

$fecha_hoy = date("Y-m-d");

if($ban_user_online == "1"){
	
		if("$fecha_hoy" >= "$ban_fecha_final_baneo") {
$enviar_baneo_desbloqueado = "UPDATE usuarios SET ban='0', ban_i='0', ban_f='0' WHERE username='$username'";
$link->query($enviar_baneo_desbloqueado);

$consulta_baneo_desbloqueado = "DELETE FROM baneo WHERE usuario='$username' LIMIT 1";
$link->query($consulta_baneo_desbloqueado);
	}
	
	if("$fecha_hoy" != "$ban_fecha_final_baneo") {
session_start();
session_unset();
session_destroy(); 
setcookie("id_extreme","x",time()-3600,"/");
echo "<div style='font-family: sans-serif;padding:20px;margin-left:-10px;margin-top:-10px;position:absolute;background:red;color:#fff;text-aling:center;heigth:700px;width:100%;'><h2>$username has sido Baneado</h2><br><h4>Si piensas que este baneo a sido injusto o un error porfavor contacta con los respectivos dueños de $nameweb<br> de lo contrario tendras que esperar hasta la fecha planteada como desbloqueo de tu cuenta.</h4><h5>¡Advertencia!<br> una vez llegada la fecha de desbloqueo de cuenta tendras que iniciar por lo menos 2 veces tu cuenta para confirmar desbloqueo.</h5><br><h4>Has sido baneado desde $ban_fecha_inicio_baneo hasta $ban_fecha_final_baneo <br>razon: $ban_razon_baneo</h4></div>";
exit();
}}


// seguridad ante owneo o robo de cuenta

$ip_actual = $_SERVER["REMOTE_ADDR"];

$resultado = $link->query("SELECT * FROM usuarios WHERE username = '$usuario_activo'");
 while($row = mysqli_fetch_array($resultado))
{
$seguridad_ip = $row['seguridad_ip'];
}

if($_SESSION["logeado"] == "SI"){

	if ($seguridad_ip == 'Si') {

$resultado = $link->query("SELECT * FROM usuarios WHERE username = '$usuario_activo'");
 while($row = mysqli_fetch_array($resultado))
{
$ip_original = $row['ip'];
}

if ($ip_actual == $ip_original) {
echo '';
} else {

	$resultado = $link->query("SELECT * FROM usuarios WHERE username = '$usuario_activo'");
 while($row = mysqli_fetch_array($resultado))
{
$email_user = $row['email'];
}

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		$mail = $email_user;
		$queEmp = "SELECT * FROM usuarios WHERE email='$mail'";
		$resEmp = $link->query($queEmp, $conexion) or die(mysqli_error());
		$totEmp = mysqli_num_rows($resEmp);
		
		$row = mysqli_fetch_assoc($resEmp);
		$hash = md5(md5($row['username']).md5(sha1(md5(sha1(md5(md5($row['password'])))))));

		$headers .= "From:Desbloqueo de cuenta - $nameweb <info@".$nameweb.">\r\n";  
		$message = "$nameweb<br><br>Hola $usernmae para desbloquear tu cuenta es necesario cambiar de contraseña por motivos de seguridad aquí abajo tienes la url para acceder al cambio de contraseña.<br><br><a href='
		".$url."/pass.php?id=".$hash."&mail=".$mail."'>Recuperar cuenta</a><br><br>¿Has sido tú el que ha intentado iniciar sesión?<br><a href='".$url."/index.php?seguridad-anti-robo-de-cuenta'>No</a>";

		if (mail($mail,"Recuperar Contraseña",$message,$headers)){
		$msg = "Se te envio un link a tu mail para cambiar la password";
		}

echo "<div style='font-family:sans-serif;padding:20px;margin-left:-10px;margin-top:-10px;position:absolute;background:red;color:#fff;text-aling:center;heigth:700px;width:100%;'>
<h2>$username Tu cuenta a sido bloqueada</h2>
<br>
<h4>Por tema de seguridad y prevención hemos bloqueado tu cuenta y aconsejamos un cambio de contraseña en cualquier caso de robo de cuenta.<br><br>
¡Advertencia!<br> De cualquier modo todos estos movimientos estan siendo guardados como sospechosos por la seguridad a nuestros usuarios y nuestro sitio web</h4>
<h4>Tu cuenta no sera desbloqueada hasta que se confirme el correo electronico o se inicie sesión con la ip registrada la cuenta<br>(Esto es una opción de seguridad puedes desactivarla en ajustes de perfil)</h4><br>
<h3>Tu ip: $_SERVER[REMOTE_ADDR]</h3></div>";

// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date("Y-m-d");
$accion = "Ha iniciado sesión con otra ip (La cuenta a sido bloqueada)";
$enviar_log = "INSERT INTO logs_sospechosos (user_logeado,ip,accion,fecha) values ('".$username."','".$ip_actual."','".$accion."','".$fecha_log."')";
$resultado_log = $link->query($enviar_log);
// Log guardado en Base de datos
session_unset();
session_destroy(); 
setcookie("id_extreme","x",time()-3600,"/");

exit();
}
}
}


// Aqui guardaremos al visitante en la base de datos

// Guardar acción en logs de visitantes
$fecha_log = date("Y-m-d");
$hora = date("H:i:s");
	$resultado = $link->query("SELECT * FROM logs_visitantes WHERE ip = '$ip_actual'");
 while($row = mysqli_fetch_array($resultado))
{
$fecha_i = $row['fecha_i'];
}

if($fecha_log != $fecha_i){
$enviar_log_visitante = "INSERT INTO logs_visitantes (ip,fecha_i,hora) values ('".$ip_actual."','".$fecha_log."','".$hora."')";
$link->query($enviar_log_visitante);
}
// Log guardado en Base de datos

?>