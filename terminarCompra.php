<?php

if (!isset($_POST['compraFinalizada'])){
    header('Location: index.php');
} else {

    @session_start();

    
    
    try {
        @$tiendaDB = new PDO('mysql:host=localhost;dbname=tiendadb', 'dwes', 'abc123');
      } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
      }

      $usuario = $_SESSION['usuario'];
      $fecha = date("Y-m-d H:i:s");
      print $fecha;
      $carroSerialize = serialize($_SESSION['carrito']);

      $tiendaDB->query("INSERT INTO comprasfinalizadas (nombreUsuario, fechaPedido, cestaPedido)VALUES('$usuario','$fecha','$carroSerialize')");
      print_r($tiendaDB->errorInfo());
      $_SESSION['carrito'] = [];

      header('Location: index.php');

}
