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


?>

<!DOCTYPE html>
<html lang="en">



<!--RESTO DE CONTENIDO-->

<div class="container">
    <div class="section">

        <div class="card">
            <div class="card-header">
                <p class="card-header-title">Compras finalizadas</p>
            </div>
            <div class="card-content">
                <div class="content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Numero pedido</th>
                                <th>Username</th>
                                <th>Fecha - Hora pedido</th>
                                <th>Pedido</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $listaCompra = $tiendaDB->query("SELECT * FROM comprasfinalizadas");

                            while ($listaCompraObj = $listaCompra->fetchObject()) {
                                print "<tr>";
                                print "<td>$listaCompraObj->numeroPedido</td>";
                                print "<td>$listaCompraObj->nombreUsuario</td>";
                                print "<td>$listaCompraObj->fechaPedido</td>";
                                //sale serialize añadir dropdown?
                                print "<td>$listaCompraObj->cestaPedido</td>";
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