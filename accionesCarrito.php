<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <title>Document</title>
</head>
<body>

<?php

$accion = $_POST["action"];

switch($accion){
    case 'eliminarProducto':
        
        $ID=$_POST["id"];
        session_start();
        foreach($_SESSION["carrito"] as $indice =>$producto){
            if($producto["ID"]==$ID){
                unset($_SESSION["carrito"][$indice]);
                $_SESSION["carrito"]=array_values($_SESSION["carrito"]);
                echo " <div class='fail-msg'><h5>Producto eliminado</h5></div><br><br>";
    if(isset($_SESSION["usuario_empleado"])){?>

                    <form action="listarCarrito.php" method="POST">
                    <button class="btn-dlt" type="submit" name="action" value="listarCarritoCompra">Volver</button>
                    </form><?php


                }else{?>

                    <form action="listarCarrito.php" method="POST">
                    <button class="btn-dlt" type="submit" name="action" value="listarCarritoVenta">Volver</button>
                    </form><?php
                }
            }
        }
          break;
}


?>
    

</body>
</html>