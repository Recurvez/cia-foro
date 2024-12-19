<?php
if($_SESSION["logeado"] == "SI"){
header ("Location: ../index?sessionerror");
exit;
}
 $resultado = $link->query("SELECT * FROM config WHERE id = 1");
  while($row=mysqli_fetch_array($resultado))
  {
$iniciar_sesion_op = $row['iniciar_sesion'];
  }
  if("$iniciar_sesion_op" == "0"){
header ("Location: $url/index.php?loginbloqueado");
  }
?>
	 <div class="container">
	<div class="row">
		<div class="col-md-8">
			<center>
			<div class="login">
				<div class="panel panel-default">
					<div class="panel-heading red">
						<h3 class="panel-title" style="text-align: left;"><div class='contedor-badge' style="background-image:url('https://images.habbo.com/c_images/album1584/PTB32.png'); background-repeat: no-repeat;"><div class='icon-login'></div></div> <?php echo $lang[24]; ?></h3>
					</div>
					<div class="panel-body">
						<div class="eventotext">
							<form class="form form-signup" role="form" method="post" action="kernel/login/entrar.php">
								<h5 class="colr bold mp" style="text-align: left;"><?php echo $lang[27]; ?></h5>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input type="text" class="form-control" required="true" name="username" id="username" placeholder="<?php echo $lang[27]; ?>"/>
									</div>
								</div>
								<h5 class="colr bold mp" style="text-align: left;"><?php echo $lang[28]; ?></h5>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
										<input type="password" id="password" required="true" name="password" class="form-control" placeholder="<?php echo $lang[28]; ?>"/>
									</div>
								</div>
								<a href="<?php echo $url; ?>/recuperar.php" class="forgot"><?php echo $lang[29]; ?></a>
								<input type="submit" name="Submit" value="<?php echo $lang[24]; ?>" class="btn btn-sm btn-primary btn-block loginbuttom">
							</div>
						</div>
					</div>
				</div>
				</center>
			</div>
			<div class="col-md-4">
			<?php echo $cartel_radio; ?>
				<?php echo $redes_sociales; ?>
				<?php echo $cartel_publicidad; ?>
			</div>
		</div>
	</div>
	<!-- /container -->