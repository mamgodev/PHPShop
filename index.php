<?php

@session_start();

if (isset($_POST['logout'])) {
  //BORRO EL USUARIO Y EL ROL YA QUE HAGO SESSION DESTROY SE ELIMINA LA CESTA TAMBIEN
  $_SESSION['usuario'] = null;
  $_SESSION['rol'] = null;
}

try {
  @$tiendaDB = new PDO('mysql:host=localhost;dbname=tiendadb', 'dwes', 'abc123');
} catch (PDOException $e) {
  print "Error: " . $e->getMessage();
}

$productosTienda = $tiendaDB->query("SELECT * FROM productos");

if (isset($_POST['addCart'])) {
  if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
  }

  $idProducto = $_POST['idProducto'];
  $cantidadProducto = $_POST['cantidadProducto'];

  $existe = false;
  $valorIndiceArray;

  if (sizeof($_SESSION['carrito']) == 0) {
    array_push($_SESSION['carrito'], [$idProducto, $cantidadProducto]);
  } else {

    foreach ($_SESSION['carrito'] as $indiceArray => $array) {
      if ($array[0] == $idProducto) {
        $existe = true;
        $valorIndiceArray = $indiceArray;
      }
    }

    if ($existe) {
      $cantidad = $_SESSION['carrito'][$valorIndiceArray][1];
      $cantidad += $cantidadProducto;
      $_SESSION['carrito'][$valorIndiceArray][1] = $cantidad;
    } else {
      array_push($_SESSION['carrito'], [$idProducto, $cantidadProducto]);
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>💻 VegaComponentes | Inicio</title>
  <link rel="stylesheet" type="text/css" href="css/tienda.css">
  <link rel="stylesheet" type="text/css" href="css/bulma.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="js/menu.js"></script>
</head>

<body class="has-navbar-fixed-top">
  <nav class="navbar is-black is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="index.php">
        <h1 class="title has-text-white">💻 VegaComponentes</h1>
      </a>

      <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <?php
            if (isset($_SESSION['usuario'])) {
              print '<div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                  <button class="button is-primary is-rounded" aria-haspopup="true" aria-controls="dropdown-menu">
                  <span class="icon is-small">
                  <i class="fas fa-user"></i>
                  </span>
                    <span>' . $_SESSION['usuario'] . '</span>
                    <span class="icon is-small">
                      <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                  </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                  <div class="dropdown-content">
                  <form action="" method="POST">
                    <button name="logout" href="#" class="button is-danger dropdown-item">
                      Cerrar sesión
                    </button></form>';
              if ($_SESSION['rol'] == 'admin') {
                print '<a class="dropdown-item" href="admin.php">
                        Panel de control
                      </a>';
              }
              print '</div>
                </div>
              </div>';
            } else {
              print '<a class="button is-primary is-rounded" href="login.php">';
              print '<strong><i class="fas fa-user-plus"></i> Iniciar sesión </strong></a>';
            }
            ?>
            &nbsp;
            <form action="cesta.php" method="POST">
              <button class="button is-light is-rounded  has-badge-rounded has-badge-info has-badge-medium" <?php if (isset($_SESSION['carrito'])) print "data-badge=" . sizeof($_SESSION['carrito']) . ""; ?>>
                <span><i class="fas fa-shopping-basket"></i> Cesta</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <section class="section">
    <div class="container">
      <?php
      while ($productosObj = $productosTienda->fetchObject()) {

        print '
    <div class="card">
			<div class="card-image">
				<figure class="image is-4by3">';
        if ($productosObj->imgDirProducto != null) {
          print '<img src="./img/' . $productosObj->imgDirProducto . '" alt="Placeholder image">';
        } else {
          print '<img src="./img/default.jpg" alt="Placeholder image">';
        }
        print '</figure>
			</div>
			<div class="card-content">
				<div class="media">
					<div class="media-content">
						<p class="title is-4">' . $productosObj->nombreProducto . '</p>
						<p class="subtitle is-6">' . $productosObj->precioProducto . ' €</p>
					</div>
				</div>
        <div class="content">
        <div class="buttons">
        <form action="info.php" method="GET">
        <button class="button is-info is-rounded">Más información</button>
        <input type="hidden" name="idProducto" value="' . $productosObj->idProducto . '">
                  </form>

          <form action="" method="POST">
            <button class="button is-light is-rounded" name="addCart">Añadir a la cesta</button>
            <input class="input is-small is-rounded" type="number" name="cantidadProducto" value="1" step="1">
            <input type="hidden" name="idProducto" value="' . $productosObj->idProducto . '">
          </form>
          
          </div>
				</div>
			</div>
		</div>';
      }
      ?>
    </div>
  </section>

  <script src="./js/menu.js"></script>
</body>

</html>