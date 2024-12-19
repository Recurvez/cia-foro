<div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">

          <div class="panel panel-default">
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
              <h3 class="panel-title"><?php echo 'Listado de Firmas'; ?></h3>
              <input type="text" id="search" placeholder="Buscar..." class="form-control" style="width: 200px; z-index: 1; position: relative;">
            </div>
            <div class="panel-body">

            <div id="loader" style="text-aling:center;margin-left:50%;"> <img src="loader.gif"></div>
		<div class="outer_div"></div><!-- Datos ajax Final -->
			</div>
          </div>
     </div>

</div>

<script>
document.getElementById("search").addEventListener("keyup", function() {
    var query = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../kernel/ajax/Body_tagsall_ajax.php?action=ajax&search=" + query, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector(".outer_div").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>

    <script>
  $(document).ready(function(){
    load(1);
  });

  function load(page){
    var search = document.getElementById("search").value; // Captura el valor de búsqueda
    var parametros = {"action":"ajax","page":page, "search": search}; // Incluye el término de búsqueda
    $("#loader").fadeIn('slow');
    $.ajax({
      url:'../kernel/ajax/Body_tagsall_ajax.php',
      data: parametros,
       beforeSend: function(objeto){
      $("#loader").html("<img src='loader.gif'>");
      },
      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $("#loader").html("");
      }
    });
}
  </script>