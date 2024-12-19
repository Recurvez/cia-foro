<?php
include "../Templates/Hk_Head.php";

$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 12) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

include "../Templates/Hk_Nav.php";
?>
	  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
     <div class="row">

          <div class="panel panel-default">
                  <div class="panel-heading blue">
              <h3 class="panel-title"><?php echo $lang[6]; ?></h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                          <thead>
                            <tr>
                              <th><?php echo $lang[312]; ?></th>
                              <th><?php echo $lang[27]; ?></th>
                              <th><?php echo $lang[50]; ?></th>
                              <th><?php echo $lang[369]; ?></th>
                              <th><?php echo $lang[122]; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                      
                      $resultado = $link->query("SELECT * FROM usuarios WHERE rank > 2 ORDER BY rank DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                            <tr>
                              <td><?php echo "$row[ID]"; ?></td>
                              <td><?php echo "$row[username]"; ?></td>
                              <td><?php echo "$row[email]"; ?></td>
                              <td><?php echo "$row[ip]"; ?></td>
                              <td><?php echo "$row[rank]"; ?></td>
                            </tr>
                            <?php
                          }
                            ?>
                          </tbody>
                        </table>

			</div>
          </div>
         
         <div style="width: 400px" class="panel panel-default">
                  <div class="panel-heading green">
              <h3 class="panel-title"><?php echo $lang[370]; ?></h3>
            </div>
            <div class="panel-body">

<div style="float:left;margin:10px;height: 110px;display: block;">
<form action="" method="post" enctype="multipart/form-data">
    <div style="float:left;margin-left:10px;">
              <label><?php echo $lang[27]; ?></label>
        <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control" name="user" placeholder="<?php echo $lang[175]; ?>" value="" /></div>

    <div style="float:left;margin-left:10px;">
                    <label><?php echo $lang[122]; ?></label><br>
                    <select required="" name="rango">
                      <?php
                      
                        if("$rangouser" >= "$rango7"){
                      $resultado = $link->query("SELECT * FROM rangos ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[id]"; ?>"><?php echo "$row[nombre]"; ?></option>
					<?php
                      }}
                    ?>
                        
                      <?php
                      
                        if("$rangouser" == "6"){
                      $resultado = $link->query("SELECT * FROM rangos WHERE id < 6 ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[id]"; ?>"><?php echo "$row[nombre]"; ?></option>
					<?php
                      }}
                    ?>
                      <?php
                      
                        if("$rangouser" == "5"){
                      $resultado = $link->query("SELECT * FROM rangos WHERE id < 5 ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[id]"; ?>"><?php echo "$row[nombre]"; ?></option>
					<?php
                      }}
                    ?>
                      <?php
                      
                        if("$rangouser" == "4"){
                      $resultado = $link->query("SELECT * FROM rangos WHERE id < 4 ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[id]"; ?>"><?php echo "$row[nombre]"; ?></option>
					<?php
                      }}
                    ?>
                      <?php
                      
                        if("$rangouser" == "3"){
                      $resultado = $link->query("SELECT * FROM rangos WHERE id < 3 ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[id]"; ?>"><?php echo "$row[nombre]"; ?></option>
					<?php
                      }}
                    ?>
                        
    </select></div><br>
<div style="margin-right: 10%;margin-left: 10px;">
<input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
    </div></form>
    
    					  <?php
if ($_POST['guardar'] && $_POST['user']) {
$user = $_POST['user'];
$rango = nl2br($_POST['rango']);
$enviar = "UPDATE usuarios SET rank='$rango' WHERE username='$user'";

if (@$link->query($enviar)) { header ("Location: equipo.php?guardado"); }
}
?>
                
			</div>
          </div>

		</div>
      </div><!-- /container -->
</div>

<?php 

include "../Templates/Footer.php";

?>
