<?php

//CONEXION BASE DE DATOS
try {
  @$tiendaDB = new PDO('mysql:host=localhost;dbname=tiendadb', 'dwes', 'abc123');
} catch (PDOException $e) {
  print "Error: " . $e->getMessage();
}

$creacionUsuario = $tiendaDB->prepare("INSERT INTO usuarios(username,password,nombre,email,nacimiento,rol) VALUES (:username,:password,:nombre,:correoElectronico,:fechaNacimiento,'usuario')");

/*SE CREA VAR PARA QUE NO DE ERROR EN EL VALUE DEL INPUT*/
$usuario = "";
$password1 = "";
$nombre = "";
$fechaNacimiento = "";
$correoElectronico = "";

//REGISTRO
if (isset($_POST['registrarse'])) {
  $errores = [];

  //COMPROBACION QUE NO ES NULL
  if (!empty($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
  } else {
    $errores['usuario'] = 'Usuario vacio!';
  }

  if (!empty($_POST['password1'])) {
    $password1 = $_POST['password1'];
    if (!empty($_POST['password2'])) {
      $password2 = $_POST['password2'];
      if ($password1 == $password2) {
        $passwordFinal = password_hash($password1, PASSWORD_DEFAULT);
      } else {
        $errores['password3'] = 'Contraseña no coincide!';
      }
    } else {
      $errores['password2'] = 'Contraseña vacia!';
    }
  } else {
    $errores['password1'] = 'Contraseña vacia!';
  }


  if (!empty($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
  } else {
    $nombre = '';
  }

  if (!empty($_POST['correoElectronico'])) {
    $correoElectronico = $_POST['correoElectronico'];
  } else {
    $errores['correoElectronico'] = 'Correo electronico vacio!';
  }

  if (!empty($_POST['fechaNacimiento'])) {
    $fechaNacimiento = $_POST['fechaNacimiento'];
  } else {
    $errores['fechaNacimiento'] = 'Fecha nacimiento vacio!';
  }

  if (empty($errores)) {
    $creacionUsuario->bindParam(':username', $usuario);
    $creacionUsuario->bindParam(':password', $passwordFinal);
    $creacionUsuario->bindParam(':nombre', $nombre);
    $creacionUsuario->bindParam(':correoElectronico', $correoElectronico);
    $creacionUsuario->bindParam(':fechaNacimiento', $fechaNacimiento);
    $creacionUsuario->execute();
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
          <!--LOS BOTONES DEL NAV-->
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
          <h3 class="title has-text-black">Registro</h3>
          <hr class="login-hr">
          <p class="subtitle has-text-black">Registrese para poder comprar.</p>
          <div class="box">
            <form action="" method="POST">
              <div class="field">
                <div class="control">
                  <label class="label">Usuario</label>
                  <input class="input is-medium" type="text" placeholder="Tu usuario" autofocus="" name="usuario" value="<?= $usuario ?>">
                  <?php (isset($errores['usuario']) ? print '<p class="help is-danger">' . $errores['usuario'] . '</p>' : print '') ?>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <label class="label">Contraseña</label>
                  <input class="input is-medium" type="password" placeholder="Tu contraseña" name="password1" value="<?= $password1 ?>">
                  <?php (isset($errores['password1']) ? print '<p class="help is-danger">' . $errores['password1'] . '</p>' : print '') ?>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <label class="label">Repita contraseña</label>
                  <input class="input is-medium" type="password" placeholder="Tu contraseña de nuevo" name="password2">
                  <?php (isset($errores['password2']) ? print '<p class="help is-danger">' . $errores['password2'] . '</p>' : print '') ?>
                  <?php (isset($errores['password3']) ? print '<p class="help is-danger">' . $errores['password3'] . '</p>' : print '') ?>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <label class="label">Nombre</label>
                  <input class="input is-medium" type="text" placeholder="Tu nombre" name="nombre" value="<?= $nombre ?>">
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <label class="label">Correo electronico</label>
                  <input class="input is-medium" type="email" placeholder="Tu correo electronico" name="correoElectronico" value="<?= $correoElectronico ?>">
                  <?php (isset($errores['correoElectronico']) ? print '<p class="help is-danger">' . $errores['correoElectronico'] . '</p>' : print '') ?>
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <label class="label">Fehca nacimiento</label>
                  <input class="input is-medium" type="date" name="fechaNacimiento" value="<?= $fechaNacimiento ?>">
                  <?php (isset($errores['fechaNacimiento']) ? print '<p class="help is-danger">' . $errores['fechaNacimiento'] . '</p>' : print '') ?>
                </div>
              </div>

              <button class="button is-block is-info is-large is-fullwidth" name="registrarse"><i class="fas fa-sign-in-alt"></i> Registrarse</button>
            </form>
          </div>
          <p class="has-text-grey">
            <a href="login.php">Iniciar sesión</a>
          </p>
        </div>
      </div>
    </div>
  </section>
  <script src="js/menu.js"></script>
</body>

</html>