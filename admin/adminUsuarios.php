<?php
@session_start();


if (isset($_SESSION['usuario'])) {
    if ($_SESSION['rol'] != "admin") {
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}

try {
    @$tiendaDB = new PDO('mysql:host=localhost;dbname=tiendadb', 'dwes', 'abc123');
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
}

if (isset($_POST['anadirCategoria'])) {
    $errores = [];
    if (isset($_POST['nombreCategoria'])) {
        echo "<script>console.log('Entro')</script>";
        $nombreCategoria = $_POST['nombreCategoria'];
        //if ($nombreCategoria != ''){
        $tiendaDB->query("INSERT INTO categoriaproductos VALUES (NULL,'$nombreCategoria')");
        print_r($tiendaDB->errorInfo());
        /*} else {
            $errores['textoVacio'] = 'Categoria vacia!';
        }*/
    } else {
        $errores['nombreVacio'] = 'Categoria vacia!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">



<!--RESTO DE CONTENIDO-->

<div class="container">
    <div class="section">

        <div class="card">
            <div class="card-header">
                <p class="card-header-title">Lista de Usuarios</p>
            </div>
            <div class="card-content">
                <div class="content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Username</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Nacimiento</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $contenidoUsuarios = $tiendaDB->query("SELECT * FROM usuarios WHERE rol='usuario'");

                            while ($contenidoUsuariosObj = $contenidoUsuarios->fetchObject()) {
                                print "<tr>";
                                print "<td>$contenidoUsuariosObj->idUsuario</td>";
                                print "<td>$contenidoUsuariosObj->username</td>";
                                print "<td>$contenidoUsuariosObj->nombre</td>";
                                print "<td>$contenidoUsuariosObj->email</td>";
                                print "<td>$contenidoUsuariosObj->nacimiento</td>";
                                print "</tr>";
                            }


                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>



    <script src="js/menu.js"></script>

</html>