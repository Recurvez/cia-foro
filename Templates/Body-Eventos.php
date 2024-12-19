<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div id="loader" style="text-aling:center;margin-left:50%;">
				<img src="hk/loader.gif">
			</div>
			<div class="outer_div">
			</div>
			<!-- Datos ajax Final -->
		</div>
		<div class="col-md-4">
			<?php echo $cartel_radio; ?>
			<?php echo $cartel_publicidad; ?>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		load(1);
	});
	function load(page){
		var parametros = {"action":"ajax","page":page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'kernel/ajax/Body_Eventos_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='hk/loader.gif'>");
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	</script>
</div>
<!-- /container -->