<div class="tienda-container">
  <h2 class="tienda-titulo">Tienda</h2>
  
  <!-- Carrusel de secciones (Fondos y Efectos) -->
  <div class="tienda">
    <div class="tienda-carrusel-container">
      
      <!-- Botones de navegación del carrusel -->
      <div class="tienda-navegacion">
        <button class="btn-navegacion" onclick="navegarCarrusel(0)">Fondos</button>
        <button class="btn-navegacion" onclick="navegarCarrusel(1)">Efectos</button>
      </div>

      <!-- Carrusel -->
      <div class="tienda-carrusel">
        <!-- Fondos -->
        <div class="tienda-carrusel-item fondos" style="display: block;">
          <div class="fondos-container">
            <?php
            $userQuery = $link->query("SELECT ID, fondo_perfil, lupas FROM usuarios WHERE username = '$username'");
            $userData = mysqli_fetch_array($userQuery);

            $userId = $userData['ID'];
            $lupasDisponibles = $userData['lupas'];

            $query = $link->query("SELECT * FROM tienda WHERE tipo = 'bg' ORDER BY id DESC LIMIT 16");
            while ($row = mysqli_fetch_array($query)) {
              $code_placa = $row['code_placa'];
              $placa_code = $link->query("SELECT * FROM placas WHERE code = '$code_placa'");
              $placa = mysqli_fetch_array($placa_code);
              $placa_img = $row['imagen'];
              $icono = 'https://images.habbo.com/c_images/album1584/DE149.png';
              $precio = $row['precio'];

              $inventarioQuery = $link->query("SELECT fondo_id FROM inventario_fondos WHERE user_id = '$userId'");
              $fondosComprados = [];
              while ($fondoComprado = mysqli_fetch_array($inventarioQuery)) {
                $fondosComprados[] = $fondoComprado['fondo_id'];
              }

              $yaPoseeFondo = in_array($row['id'], $fondosComprados);
            ?>
              <div class="fondo-card">
                <div class="fondo-header">
                  <?php echo $row['code_placa']; ?>
                </div>
                <img src="<?php echo $placa_img; ?>" alt="Fondo" class="fondo-img">
                <div class="fondo-info">
                  <div class="fondo-precio">
                    <img src="<?php echo $icono; ?>" alt="Icono" class="icono-precio">
                    <?php echo $precio; ?>
                  </div>
                  <?php if ($yaPoseeFondo): ?>
                    <button class="btn-usar" onclick="usarFondo('<?php echo $row['id']; ?>')">Usar</button>
                  <?php elseif ($lupasDisponibles >= $precio): ?>
                    <button class="btn-comprar" onclick="comprarFondo('<?php echo $row['id']; ?>')">Comprar</button>
                  <?php else: ?>
                    <button class="btn-sin-lupas" disabled>Insuficiente</button>
                  <?php endif; ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <!-- Efectos -->
        <div class="tienda-carrusel-item efectos" style="display: none;">
          <div class="fondos-container">
            <?php
            $query = $link->query("SELECT * FROM tienda WHERE tipo = 'ef' ORDER BY id DESC LIMIT 16");
            while ($row = mysqli_fetch_array($query)) {
              $code_placa = $row['code_placa'];
              $placa_code = $link->query("SELECT * FROM placas WHERE code = '$code_placa'");
              $placa = mysqli_fetch_array($placa_code);
              $placa_img = $row['imagen'];
              $icono = 'https://images.habbo.com/c_images/album1584/DE149.png';
              $precio = $row['precio'];

              $inventarioQuery = $link->query("SELECT fondo_id FROM inventario_fondos WHERE user_id = '$userId'");
              $fondosComprados = [];
              while ($fondoComprado = mysqli_fetch_array($inventarioQuery)) {
                $fondosComprados[] = $fondoComprado['fondo_id'];
              }

              $yaPoseeFondo = in_array($row['id'], $fondosComprados);
            ?>
              <div class="fondo-card">
                <div class="fondo-header">
                  <?php echo $row['code_placa']; ?>
                </div>
                <img src="<?php echo $placa_img; ?>" alt="Fondo" class="efecto-img">
                <div class="fondo-info">
                  <div class="fondo-precio">
                    <img src="<?php echo $icono; ?>" alt="Icono" class="icono-precio">
                    <?php echo $precio; ?>
                  </div>
                  <?php if ($yaPoseeFondo): ?>
                    <button class="btn-usar" onclick="usarEfecto('<?php echo $row['id']; ?>')">Usar</button>
                  <?php elseif ($lupasDisponibles >= $precio): ?>
                    <button class="btn-comprar" onclick="comprarEfecto('<?php echo $row['id']; ?>')">Comprar</button>
                  <?php else: ?>
                    <button class="btn-sin-lupas" disabled>Insuficiente</button>
                  <?php endif; ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  let currentSection = 0; // 0: Fondos, 1: Efectos

  // Función para navegar entre Fondos y Efectos
  function navegarCarrusel(seccion) {
    const sections = document.querySelectorAll('.tienda-carrusel-item');
    
    // Ocultar la sección actual
    sections[currentSection].style.display = 'none';
    
    // Cambiar a la nueva sección
    currentSection = seccion;
    
    // Mostrar la nueva sección
    sections[currentSection].style.display = 'block';
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Lógica para comprar un fondo
  function comprarFondo(id) {
    fetch(`../kernel/ajax/comprar_fondo.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        Swal.fire({
          title: 'Resultado de la compra',
          text: data,
          icon: data.includes("éxito") ? 'success' : 'error',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload(); // Recargar la página después de la confirmación
        });
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Error al comprar fondo. Inténtalo de nuevo.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        console.error('Error al comprar fondo:', error);
      });
  }


  function usarFondo(id) {
    fetch(`../kernel/ajax/usar_fondo.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        Swal.fire({
          title: 'Resultado',
          text: data,
          icon: data.includes("éxito") ? 'success' : 'error',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload(); // Recargar la página después de la confirmación
        });
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Error al aplicar fondo. Inténtalo de nuevo.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        console.error('Error al aplicar fondo:', error);
      });
  }

    // Lógica para comprar un efecto
    function comprarEfecto(id) {
    fetch(`../kernel/ajax/comprar_efecto.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        Swal.fire({
          title: 'Resultado de la compra',
          text: data,
          icon: data.includes("éxito") ? 'success' : 'error',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload(); // Recargar la página después de la confirmación
        });
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Error al comprar fondo. Inténtalo de nuevo.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        console.error('Error al comprar fondo:', error);
      });
  }


  function usarEfecto(id) {
    fetch(`../kernel/ajax/usar_efecto.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        Swal.fire({
          title: 'Resultado',
          text: data,
          icon: data.includes("éxito") ? 'success' : 'error',
          confirmButtonText: 'OK'
        }).then(() => {
          location.reload(); // Recargar la página después de la confirmación
        });
      })
      .catch(error => {
        Swal.fire({
          title: 'Error',
          text: 'Error al aplicar fondo. Inténtalo de nuevo.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        console.error('Error al aplicar fondo:', error);
      });
  }
</script>

<style>
  /* Contenedor principal */
  .tienda-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 20px auto;
  }

  /* Título de la tienda */
  .tienda-titulo {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
    text-align: center;
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  /* Contenedor de carrusel */
  .tienda {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 850px;
  }

  /* Contenedor de navegación */
  .tienda-navegacion {
    margin-bottom: 20px;
  }

  .btn-navegacion {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 0 10px;
    cursor: pointer;
    border-radius: 5px;
  }

  .btn-navegacion:hover {
    background-color: #0056b3;
  }

  /* Carrusel */
  .tienda-carrusel {
    margin-top: 20px;
  }

  .tienda-carrusel-item {
    display: none;
  }

  .fondos-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    justify-content: center;
  }

  .fondo-card {
    background-color: #fff;
    border: 2px solid #007bff;
    border-radius: 8px;
    overflow: hidden;
    width: 180px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .fondo-header {
    background-color: #007bff;
    color: #fff;
    padding: 8px 5px;
    font-size: 14px;
    font-weight: bold;
  }

  .fondo-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
  }

  .efecto-img {
    height: 150px;
    width: auto;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
  }

  .fondo-info {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .fondo-precio {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    color: #333;
  }

  .icono-precio {
    width: 20px;
    height: 20px;
    margin-right: 5px;
  }

  .btn-comprar {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  .btn-comprar:hover {
    background-color: #218838;
  }

  .btn-usar {
    background-color: #17a2b8;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
  }

  .btn-sin-lupas {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: not-allowed;
  }
</style>
