<?php

session_start();

if (isset($_SESSION['usuario'])) {
  if ($_SESSION['rol'] != "admin") {
    header('Location: ./index.php');
  }
} else {
  header('Location: ./index.php');
}

if (isset($_POST['logout'])) {
  //BORRO EL USUARIO Y EL ROL YA QUE HAGO SESSION DESTROY SE ELIMINA LA CESTA TAMBIEN
  $_SESSION['usuario'] = null;
  $_SESSION['rol'] = null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>💻 VegaComponentes | Administracion</title>
  <link rel="stylesheet" type="text/css" href="css/bulma.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body class="has-navbar-fixed-top">
  <nav class="navbar is-fixed-top is-black" role="navigation" aria-label="main navigation">
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

  <section class="main-content columns is-fullheight">

    <!--PANEL LATERAL-->
    <div class="section">
      <aside class="menu column is-2">
        <form method="POST" action="">
          <p class="menu-label">
            Principal
          </p>
          <ul class="menu-list">
            <li><button class="button is-outlined is-danger is-rounded" name="adminHome">Inicio</button></li>

          </ul>
          <p class="menu-label">
            Administracion
          </p>
          <ul class="menu-list">
            <li>
              <a>Usuarios</a>
              <ul>
                <li><button class="button is-outlined is-rounded" name="usuarios">Usuarios</button></li>
                <li><button class="button is-outlined is-rounded" name="empleados">Empleados</button></li>
              </ul>
            </li>
            <li>
              <a>Productos</a>
              <ul>
                <li><button class="button is-outlined is-rounded" name="productos">Productos</button></li>
                <li><button class="button is-outlined is-rounded" name="categorias">Categorias</button></li>
              </ul>
            </li>
            <li>
              <a>Cesta</a>
              <ul>
                <li><button class="button is-outlined is-rounded" name="comprasFinalizadas">Compras finalizadas</button></li>
                <li><button class="button is-outlined is-danger is-rounded">En cesta</button></li>
              </ul>
            </li>
          </ul>

        </form>
      </aside>
    </div>

    <!--RESTO DE CONTENIDO-->

    <?php

    //No es la mejor forma pero para poder meter productos he tenido que crear sessiones para que guarde la informacion
    //ya que cuando le daba al boton para insertar se refrescaba y nunca se añadia a la db

    if (!isset($_SESSION['mostrar'])) {
      $_SESSION['mostrar'] =  'admin/adminHome.php';
    } else if (isset($_POST['productos'])) {
      $_SESSION['mostrar'] = 'admin/adminProductos.php';
    } else if (isset($_POST['categorias'])) {
      $_SESSION['mostrar'] =  'admin/adminCategorias.php';
    } else if (isset($_POST['usuarios'])) {
      $_SESSION['mostrar'] =  'admin/adminUsuarios.php';
    } else if (isset($_POST['empleados'])) {
      $_SESSION['mostrar'] =  'admin/adminEmpleados.php';
    } else if (isset($_POST['comprasFinalizadas'])) {
      $_SESSION['mostrar'] =  'admin/adminPedidos.php';
    } else if (isset($_POST['adminHome'])) {
      $_SESSION['mostrar'] =  'admin/adminHome.php';
    }

    include $_SESSION['mostrar'];

    ?>

    <script src="js/menu.js"></script>
</body>

</html>