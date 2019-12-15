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


if (isset($_POST['deleteProducto'])) {
  //recorre el array de carrito y busca el id array[0] id del Producto
  foreach ($_SESSION['carrito'] as $clave => $array) {
    if (in_array($_POST['idProducto'], $array)) unset($_SESSION['carrito'][$clave]);
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

  <section class="section">
    <div class="container">
      <?php
      $total = 0;
      if (isset($_SESSION['carrito'])) {
        if (sizeof($_SESSION['carrito']) != 0) {
          print '<table class="table is-hoverable is-fullwidth is-full is-striped">
            <thead>
              <tr>
                <th>#Id</th>
                <th>Imagen producto</th>
                <th>Nombre producto</th>
                <th>Precio producto</th>
                <th>Cantidad producto</th>
                <th>Eliminar producto</th>
              </tr>
            </thead>
            <tbody>';

          print '<tr>';
          foreach ($_SESSION['carrito'] as $producto) {
            $datosProducto = $tiendaDB->query("SELECT nombreProducto, precioProducto, imgDirProducto FROM productos WHERE idProducto='$producto[0]'");
            while ($datosProductoObj = $datosProducto->fetchObject()) {
              print "<td> $producto[0] </td>";
              print '<td> <figure class="image is-96x96 is-5by3 ">';
              if ($datosProductoObj->imgDirProducto != null) {
                print '<img src="./img/' . $datosProductoObj->imgDirProducto . '" alt="Placeholder image">';
              } else {
                print '<img src="./img/default.jpg" alt="Placeholder image">';
              }
              print '</figure> </td>';
              print "<td> $datosProductoObj->nombreProducto </td>";
              print "<td> $datosProductoObj->precioProducto € </td>";
              $total += $datosProductoObj->precioProducto;

              print "<td> <form action='' method='POST'><input name='cantidadesProductos[]' type='number' step='1' value='$producto[1]'> </td>";
              print "<input type='hidden' name='idProducto' value='$producto[0]'>";
              print "<td><button name='deleteProducto' class='button is-rounded is-danger'>Eliminar</button></form> </td>";
            }
            print '</tr>';
          }
          print '</tbody>
            </table>
            
            </div>
            <form action="terminarCompra.php" method="POST">
            <table class="table is-hoverable is-fullwidth is-full is-striped">
            <thead>
              <tr>
                <th>Precio Total</th>
                <th>Finalizar compra</th>
              </tr>
            </thead>
            <tbody>
            <tr>
            <td><span>Total: ' . $total . ' €</span></td>
            <td>';

          if (!empty($_SESSION["usuario"])) {
            print '<button class="button is-rounded is-success" name="compraFinalizada">Terminar Compra</button>';
          } else {
            print "<span>Es necesario iniciar sesión para finalizar la compra.</span>";
          }

          print '</td>
                </tr>
                </tbody>
                </table>
                </form>';
        } else {
          print '<article class="message is-danger">
            <div class="message-header">
              <p>La cesta esta vacia</p>
            </div>
            <div class="message-body">
              Su cesta esta vacia 😢
            </div>
          </article>';
        }
      } else {
        header('Location: ./index.php');
      }
      ?>

    </div>
  </section>
  <script src="./js/menu.js"></script>
</body>

</html>