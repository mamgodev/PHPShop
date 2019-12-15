<?php

session_start();

try {
  @$tiendaDB = new PDO('mysql:host=localhost;dbname=tiendadb', 'dwes', 'abc123');
} catch (PDOException $e) {
  print "Error: " . $e->getMessage();
}

if (isset($_POST['logout'])) {
  //BORRO EL USUARIO Y EL ROL YA QUE HAGO SESSION DESTROY SE ELIMINA LA CESTA TAMBIEN
  $_SESSION['usuario'] = null;
  $_SESSION['rol'] = null;
}

$usuario = "";

if (isset($_POST['iniciarSesion'])) {

  $errores = [];

  if (!empty($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
  } else {
    $errores['usuario'] = 'Usuario vacio';
  }

  if (!empty($_POST['password1'])) {
    $password = $_POST['password1'];
  } else {
    $errores['password1'] = 'Contraseña vacia';
  }

  if (empty($errores)) {
    $resultadoInicio = $tiendaDB->query("SELECT username, password, rol FROM usuarios WHERE username='$usuario'");
    if ($resultadoInicio) {
      $inicioObjectos = $resultadoInicio->fetchObject();
      if (password_verify($password, $inicioObjectos->password)) {
        if ($usuario == $inicioObjectos->username) {
          $_SESSION['usuario'] = $inicioObjectos->username;
          $_SESSION['rol'] = $inicioObjectos->rol;
          header('Location: index.php');
        } else {
          $errores['usuariopassword2'] = 'Usuario y/o contraseña incorrecta';
        }
      } else {
        $errores['usuariopassword1'] = 'Usuario y/o contraseña incorrecta';
      }
    } else {
      $errores['noExiste'] = 'Usuario y/o contraseña incorrecta';
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
  <title>💻 VegaComponentes |Inicio</title>
  <link rel="stylesheet" type="text/css" href="css/bulma.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
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

  <section class="hero is-white is-fullheight">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h3 class="title has-text-black">Iniciar sesión</h3>
          <hr class="login-hr">
          <p class="subtitle has-text-black">Inicie sesión para poder comprar.</p>
          <div class="box">
            <form action="" method="POST">
              <div class="field">
                <div class="control">
                  <input class="input is-medium" type="text" placeholder="Tu usuario" autofocus="" name="usuario" value=<?= $usuario ?>>
                  <?php (isset($errores['usuario']) ? print '<p class="help is-danger">' . $errores['usuario'] . '</p>' : print '') ?>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <input class="input is-medium" type="password" placeholder="Tu contraseña" name="password1">
                  <?php (isset($errores['password1']) ? print '<p class="help is-danger">' . $errores['password1'] . '</p>' : print '') ?>
                  <?php (isset($errores['usuariopassword2']) ? print '<p class="help is-danger">' . $errores['usuariopassword2'] . '</p>' : print '') ?>
                  <?php (isset($errores['usuariopassword1']) ? print '<p class="help is-danger">' . $errores['usuariopassword1'] . '</p>' : print '') ?>
                </div>
              </div>

              <button class="button is-block is-info is-large is-fullwidth" name="iniciarSesion"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
            </form>
          </div>
          <p class="has-text-grey">
            <a href="register.php">Registrarse</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <script src="js/menu.js"></script>
</body>

</html>