<div class="container">
	<div class="row">
		<div class="col-md-12">
		<div class="panel panel-default">
  <div class="panel-body">
  		<div class="col-md-8">
  		<div class="container-fluid">
  		<section>
  <h3>General</h3>
  <hr><br>
<ul class="list-unstyled">
  <li><a href="<?php echo $url; ?>/help.php?<?php echo $row['title'] ?>">Ultimas Novedades y actualizaciones</a></li>
  <li><a href="<?php echo $url; ?>/equipo.php?<?php echo $row['title'] ?>">Equipo administrativo</a></li>
  <li><a href="#" onclick="mostrarAlertaHistoria()">Historia</a></li>
<script>
function mostrarAlertaHistoria() {
    Swal.fire({
        title: 'Historia de CSI',
        text: 'Estamos trabajando en ello, disculpa las molestias.',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
</ul>

</section>

<section>
<br>
  <h3>Preguntas Frecuentes</h3>
  <hr><br>

  <div class="col-md-6">
    <h4>Principales</h4>
<ul class="list-unstyled">
  <li><a href="#" onclick="mostrarAlerta()">¿Cómo funcionan las pagas en CSI?</a></li>
<script>
function mostrarAlerta() {
    Swal.fire({
        title: 'Información sobre las pagas',
        html: `
            La agencia cuenta con 3 pagas: miércoles, sábados y domingos a las 20h UTC.<br><br>

            <strong>Miércoles:</strong><br>
            Solo por asistir cobras 1c. Para aumentar esa cantidad, se pueden realizar bloques de 360 minutos. Por cada bloque de 360 minutos se cobrará 1c extra. Si tienes al menos un bloque de 360 minutos, ganarás un plus adicional dependiendo del rango (de 2c a 6c respectivamente).<br><br>

            <strong>Sábados:</strong><br>
            Para cobrar la paga de los sábados, se debe completar un tiempo mínimo según el cargo:<br>
            SEG (2c): 120 mins.<br>
            ENT (3c): 180 mins.<br>
            LOG (3c): 180 mins.<br>
            SUP (4c): 300 mins.<br>
            DIR (5c): 360 mins.<br>
            PRE (6c): 420 mins.<br>
            OP (6c): 420 mins.<br>
            JD (6c): 420 mins.<br>
            Una vez completado el tiempo, es obligatorio solicitar el grupo CSI-Nomina y pedir a un administrador que acepte dicho grupo.<br><br>

            <strong>Domingos:</strong><br>
            Para cobrar esta paga, únicamente hay que estar presente a las 20h UTC. El pago será de entre 1 a 5 créditos.<br><br>

            Para más dudas, contactar a un ADM+.
        `,
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>

<li><a href="#" onclick="mostrarAlertaPaga()">¿Cómo puedo reclamar mi paga? ¿Por qué no me aparece en monedero?</a></li>
<script>
function mostrarAlertaPaga() {
    Swal.fire({
        title: 'Reclamación de Paga',
        html: 'Para reclamar la paga mediante tradeos, debes tenerlos desbloqueados (pide ayuda a cualquier JD+ en caso de que estén bloqueados). Mediante este método, podés recibirla en cualquiera de las 3 versiones de Habbo (Flash, Beta, Móvil). Si tu paga no te aparece en el "monedero" de Habbo, es porque alcanzaste el límite de almacenamiento gratuito de créditos en el mismo, por lo que serán almacenados en tu caja fuerte.<br><br><strong>Nota:</strong> Ya no damos pagas mediante la función de donaciones en la versión Unity, salvo excepciones.',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>

<li><a href="#" onclick="mostrarAlertaProcedimientos()">¿Cuáles son los procedimientos de cada rango en CSI?</a></li>
<script>
function mostrarAlertaProcedimientos() {
    Swal.fire({
        title: 'Procedimientos de CSI',
        html: 'Puedes visualizarlos aquí:<br><br><strong>URL:</strong> <a href="https://docs.google.com/document/d/1Iq6D1X7ibzlLHCRcGO8lyGYpGeFHvo3kRC6j0telr0o/edit?usp=sharing" target="_blank">Abrir documento</a>',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
<li><a href="#" onclick="mostrarAlertaInsultos()">¿Qué hago si me han susurrado una grosería o vi actitudes en contra de las reglas?</a></li>
<script>
function mostrarAlertaInsultos() {
    Swal.fire({
        title: 'Actitudes Negativas',
        html: 'En caso de que esto pase, se debe tomar screenshot del historial de chat o al momento (en caso de que la situación no se haya resuelto). Luego de eso, enviar esa captura a algún JD+ para que pueda ayudarlos con la situación.',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
<li><a href="<?php echo $url; ?>/misiones.php?<?php echo $row['title'] ?>">¿Cuáles son las misiones y precios?</a></li>
<li><a href="<?php echo $url; ?>/hk/tags-all.php?<?php echo $row['title'] ?>">¿Dónde se anotan los TAG? (Si eres RA)</a></li>

</ul>
</div>

  <div class="col-md-6">
    <h4>Otros</h4>
<ul class="list-unstyled">
<li><a href="#" onclick="mostrarAlertaDatos()">¿Es necesario colocar mi email real?</a></li>
<script>
function mostrarAlertaDatos() {
    Swal.fire({
        title: 'Datos Personales',
        html: 'No, desde nuestro equipo nunca te pediremos datos personales ni sensibles. ¡Qué no te engañen!',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
<li><a href="#" onclick="mostrarAlertaCookies()">¿Es necesario el uso de cookies en la web?</a></li>
<script>
function mostrarAlertaCookies() {
    Swal.fire({
        title: 'Cookies',
        html: 'El uso de cookies nos permiten recordad información sobre tu visita y hará más sencillo tu uso del Foro Web',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
<li><a href="#" onclick="mostrarAlertaCredenc()">Un usuario me ha pedido que le diga mis datos de ingreso o algún dato sensible, ¿qué debería hacer?</a></li>
<script>
function mostrarAlertaCredenc() {
    Swal.fire({
        title: 'Datos de Ingreso',
        html: 'Desde CSI nunca te pediremos contraseñas, emails o cualquier dato que pueda vulnerar tu seguridad. Si alguien te ha pedido algún dato repórtalo inmediatamente a un administrador.',
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        background: '#f7f7f7',
        customClass: {
            popup: 'swal2-rounded'
        }
    });
}
</script>
</ul>
</div>
</section>
			 </div>
</div>
		<div class="col-md-4">
				<div style="padding:20px;">
				<center>
<img src="http://vignette4.wikia.nocookie.net/habbo/images/4/47/Article_newPurpleHeads2.gif/revision/latest?cb=20130114194316&path-prefix=en" alt="Help <?php echo $nameweb; ?>">
</center>
<br>
<p style="background-color: orange;padding:20px;border-radius:10px;color:#fff;">Nuesto Foro Web (V2) Cuenta con un nuevo sistema de ayuda para aquellos usuarios con dificultad o duda a la hora de usar una de nuestras herramientas de nuestra agencia.<br><br>Dentro de nuestro centro de ayuda podras encontrar tutoriales, explicaciones, novedades a tomar encuenta entre otros que posiblemente te puedan interesar.<br><br>
Es importante para nosotros que nuestros usarios no tengan problemas dentro de nuestra web por ello la razon de nuestro centro de ayuda.</p>
				</div>
			 </div>
			</div>
		</div>
	  </div>
   </div>
</div>
<!-- /container -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>