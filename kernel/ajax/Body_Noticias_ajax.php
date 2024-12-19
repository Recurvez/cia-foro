<?php 
function paginate($reload, $page, $tpages, $adjacents) {
	$prevlabel = "&lsaquo; $lang[196]";
	$nextlabel = "$lang[197] &rsaquo;";
	$out = '<ul class="pagination pagination-large">';
	
	// previous label

	if($page==1) {
		$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
	} else if($page==2) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(1)'>$prevlabel</a></span></li>";
	}else {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page-1).")'>$prevlabel</a></span></li>";

	}
	
	// first label
	if($page>($adjacents+1)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load(1)'>1</a></li>";
	}
	// interval
	if($page>($adjacents+2)) {
		$out.= "<li><a>...</a></li>";
	}

	// pages

	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class='active'><a>$i</a></li>";
		}else if($i==1) {
			$out.= "<li><a href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
		}else {
			$out.= "<li><a href='javascript:void(0);' onclick='load(".$i.")'>$i</a></li>";
		}
	}

	// interval

	if($page<($tpages-$adjacents-1)) {
		$out.= "<li><a>...</a></li>";
	}

	// last

	if($page<($tpages-$adjacents)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load($tpages)'>$tpages</a></li>";
	}

	// next

	if($page<$tpages) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page+1).")'>$nextlabel</a></span></li>";
	}else {
		$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
	}
	
	$out.= "</ul>";
	return $out;
}
?>
<?php
	require ('../../global.php');

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		$count_query   = $link->query("SELECT count(*) AS numrows FROM noticias ");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'furni.php';
		//consulta principal para recuperar los datos
		$query = $link->query("SELECT * FROM noticias  order by id DESC LIMIT $offset,$per_page");
		
		if ($numrows>0){
			while($row = mysqli_fetch_array($query)){
?>
<div style="background-image: url(<?php echo $row['imagen']; ?>);background-position: 50%;margin-bottom: 15px;border-radius: 5px" class="articulo">
    <a href="articulo.php?id=<?php echo $row['id']; ?>">
  <div class="contenedor-datos">
        <div class="contenedor-likes">
            <div style="float:left;font-size: 14px;"><i style="font-size: 11px;" class="material-icons">thumb_up</i> <?php echo $row['megusta']; ?></div>
            <div style="margin-left:10px;float:left;font-size: 14px;"><i style="font-size: 11px;" class="material-icons">thumb_down</i> <?php echo $row['no_megusta']; ?></div>
        </div>
        <p><span style="color: rgb(204, 204, 204);"><span class="datos-noticia"><?php echo $lang[34]; ?>: <?php echo "$row[fecha]"; ?> <span style="margin-left:15px;"><?php echo $lang[35]; ?>: <?php echo "$row[categoria]"; ?><span style="margin-left:15px;"><?php echo $lang[36]; ?>: <?php echo "$row[autor]"; ?></span></span>
          </span>
            </span>
    </p></div>
    <div style="height: 55px;position: relative;padding: 10px;float: left;width: 55%;background-color: rgba(0, 0, 0, 0.86);overflow: hidden;">
        <div class="titlesmallarticulo">
            <a href="articulo.php?id=<?php echo $row['id']; ?>">
                <?php echo "$row[titulo]"; ?>           </a>
        </div>
        <div style="color:#ccc;" class="resumen-noticia">
            <?php echo "$row[resumen]"; ?>                <br>
        </div>
        
    </div>
<div class="detalle-titulo"></div>

    </a>
</div>
				<?php
			}
			?>

		<div class="table-pagination pull-right">
			<?php echo paginate($reload, $page, $total_pages, $adjacents);?>
		</div>
		
			<?php
			
		} else {
			?>
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $lang[195]; ?>
            </div>
			<?php
		}
	}
?>