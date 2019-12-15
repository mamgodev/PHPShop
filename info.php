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

if (isset($_GET['idProducto'])) {
  $idProducto = $_GET['idProducto'];
} else {
  header('Location: ./index.php');
}

$infoProducto = $tiendaDB->query("SELECT * FROM productos WHERE idProducto='$idProducto'");

$infoProductoObj = $infoProducto->fetchObject();

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

  <div class="container is-fluid"></div>

  <section class="section">
    <div class="container">
      <div class="columns is-desktop is-vcentered">
        <div class="column is-6-desktop">
          <h2 class="title"><?= $infoProductoObj->nombreProducto ?></h2>
          <p class="subtitle"><?= $infoProductoObj->precioProducto ?> €</p>
          <p class="subtitle"><?= $infoProductoObj->descripcionProducto ?></p>
          <form action="" method="POST">
            <div class="buttons">
              <input style="width:150px;" class="input is-small is-rounded" type="number" name="cantidadProducto" value="1" step="1">
              <button class="button is-light is-rounded" name="addCart">Añadir a la cesta</button>
              <input type="hidden" name="idProducto" value="<?= $infoProductoObj->idProducto ?>">
            </div>
          </form>
        </div>
        <div class="column is-6-desktop"><img src="./img/<?php ($infoProductoObj->imgDirProducto != null ? print $infoProductoObj->imgDirProducto : print 'default.jpg') ?>" alt="">
        </div>
      </div>
    </div>
  </section>
  </div>

</body>

</html>