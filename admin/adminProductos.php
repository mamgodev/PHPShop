<?php

use function PHPSTORM_META\type;

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

$nombreProducto = "";
$descripcionProducto = "";
$stockProducto = "";
$precioProducto = "";

if (isset($_POST['anadirProducto'])) {
    $errores = [];
    if (!empty($_POST['nombreProducto'])) {
        $nombreProducto = $_POST['nombreProducto'];
    } else {
        $errores['nombreVacio'] = 'Nombre vacio!';
    }

    $descripcionProducto = $_POST['descripcionProducto'];

    if (!empty($_POST['precioProducto'])) {
        $precioProducto = $_POST['precioProducto'];
    } else {
        $errores['precioVacio'] = 'Precio vacio!';
    }

    if (!empty($_POST['stockProducto'])) {
        $stockProducto = $_POST['stockProducto'];
    } else {
        $errores['stockVacio'] = 'Stock vacio!';
    }

    $categoriaProducto = $_POST['categoriaProducto'];

    $rutaImagen = $_POST['imagenProducto'];

    if (empty($errores)) {
        $tiendaDB->query("INSERT INTO productos VALUES (NULL,'$nombreProducto','$descripcionProducto','$precioProducto','$stockProducto','$categoriaProducto','$rutaImagen')");
        $nombreProducto = "";
        $descripcionProducto = "";
        $stockProducto = "";
        $precioProducto = "";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php

$existeCategorias = true;
$resultadoCategoria = $tiendaDB->query("SELECT id FROM categoriaproductos LIMIT 1");
if ($resultadoCategoria->rowCount() != 1) {
    $existeCategorias = false;
}

?>

<div class="container ">
    <div class="section">


        <!--RESTO DE CONTENIDO-->
        <?php if ($existeCategorias) {
            print '<div class="card">
                    <div class="card-header">
                        <p class="card-header-title">Añadir productos</p>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <form method="POST" action="">
                                <div class="field">
                                    <label class="label">Nombre producto</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Nombre producto" name="nombreProducto" value="' . $nombreProducto . '">';
            (isset($errores['nombreVacio']) ? print '<p class="help is-danger">' . $errores['nombreVacio'] . '</p>' : print '');
            print '</div>
                                </div>
                                <div class="field">
                                    <label class="label">Descripción producto</label>
                                    <div class="control">
                                        <textarea class="input" placeholder="Descripcion producto" name="descripcionProducto" value="' . $descripcionProducto . '"></textarea>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Precio producto</label>
                                    <div class="control">
                                        <input class="input" type="number" placeholder="Precio producto" name="precioProducto" step=".01" value="' . $precioProducto . '">';
            (isset($errores['precioVacio']) ? print '<p class="help is-danger">' . $errores['precioVacio'] . '</p>' : print '');
            print '</div>
                                </div>
                                <div class="field">
                                    <label class="label">Stock producto</label>
                                    <div class="control">
                                        <input class="input" type="number" placeholder="Stock producto" name="stockProducto" value="' . $stockProducto . '">';
            (isset($errores['stockVacio']) ? print '<p class="help is-danger">' . $errores['stockVacio'] . '</p>' : print '');
            print '</div>
                                </div>
                                <div class="field">
                                    <label class="label">Ruta Imagen</label>
                                    <div class="control">
                                    <div class="file">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="imagenProducto">
                                        <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Elige una imagen...
                                        </span>
                                        </span>
                                    </label>
                                    </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Categoria producto</label>
                                    <div class="control">
                                        <div class="select">
                                            <select name="categoriaProducto">';
            $contenidoCategorias = $tiendaDB->query("SELECT categoria FROM categoriaproductos");

            while ($contenidoCategoriasObj = $contenidoCategorias->fetchObject()) {
                print "<option value='$contenidoCategoriasObj->categoria'>$contenidoCategoriasObj->categoria</option>";
            }
            print '</select>
                    </div>
                </div>
            </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-success" name="anadirProducto">Añadir</button>
            </div>
        </div>
        </form>
        </div>
        </div>
        </div>

        <br></br>

        <div class="card">
            <div class="card-header">
                <p class="card-header-title">Productos</p>
            </div>
            <div class="card-content">
                <div class="content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nombre producto</th>
                                <th>Descripcion producto</th>
                                <th>Precio producto</th>
                                <th>Stock producto</th>
                                <th>Categoria producto</th>
                                <th>Dirección imagen producto</th>
                            </tr>
                        </thead>
                        <tbody>';

            $contenidoProductos = $tiendaDB->query("SELECT * FROM productos");

            while ($contenidoProductosObj = $contenidoProductos->fetchObject()) {
                print "<tr>";
                print "<td>$contenidoProductosObj->idProducto</td>";
                print "<td>$contenidoProductosObj->nombreProducto</td>";
                print "<td>$contenidoProductosObj->descripcionProducto</td>";
                print "<td>$contenidoProductosObj->precioProducto</td>";
                print "<td>$contenidoProductosObj->stockProducto</td>";
                print "<td>$contenidoProductosObj->categoriaProducto</td>";
                print "<td>$contenidoProductosObj->imgDirProducto</td>";
                print "</tr>";
            }

            print '</tbody>
                    </table>
                    </div>
                    </div>';
        } else {
            print '<div class="card">
            <div class="card-header">
                <p class="card-header-title">Productos</p>
            </div>
            <div class="card-content">
                <div class="content">
                <div class="notification is-danger">
                    Necesitas categorias para poder añadir productos 🤔
                </div>
            </div>
            </div>';
        }
        ?>
    </div>
</div>

<script src="js/menu.js"></script>

</html>