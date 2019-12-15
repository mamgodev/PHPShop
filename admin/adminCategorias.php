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
    if (!empty($_POST['nombreCategoria'])) {
        echo "<script>console.log('Entro')</script>";
        $nombreCategoria = $_POST['nombreCategoria'];
        //if ($nombreCategoria != ''){
        $tiendaDB->query("INSERT INTO categoriaproductos VALUES (NULL,'$nombreCategoria')");
        //print_r($tiendaDB->errorInfo());
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
                <p class="card-header-title">Añadir categorías</p>
            </div>
            <div class="card-content">
                <div class="content">
                    <form method="POST" action="">
                        <div class="field">
                            <label class="label">Categoria</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Categoria producto" name="nombreCategoria">
                                <?php (isset($errores['nombreVacio']) ? print '<p class="help is-danger">' . $errores['nombreVacio'] . '</p>' : print '') ?>
                            </div>
                        </div>
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-success" name="anadirCategoria">Añadir</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <br></br>

        <div class="card">
            <div class="card-header">
                <p class="card-header-title">Categorías</p>
            </div>
            <div class="card-content">
                <div class="content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nombre categoría</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $contenidoCategorias = $tiendaDB->query("SELECT * FROM categoriaproductos");

                            while ($contenidoCategoriasObj = $contenidoCategorias->fetchObject()) {
                                print "<tr>";
                                print "<td>$contenidoCategoriasObj->id</td>";
                                print "<td>$contenidoCategoriasObj->categoria</td>";
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