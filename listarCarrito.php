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

    <h3>Lista carrito</h3>
<?php 



$accion=$_POST["action"];

switch($accion){
    case "listarCarritoCompra":
        listaCarritoCompra();
            break;

    case "listarCarritoVenta":
        listaCarritoVenta();
            break;
}


function listaCarritoVenta(){
session_start();

if(!empty($_SESSION["carrito"])){
    echo "<a class='btn-dlt' href='interfaz_cliente.php'> Volver</a></div>"; 

    ?>
<table>
    <tr>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio Ud.</th>
        <th>Subtotal</th>
        <th></th>
    </tr>
    <?php $total=0;?>
    <?php foreach($_SESSION["carrito"] as  $indice => $producto){?>
    <tr>
        <td><?php echo $producto['NOMBRE']?></td>
        <td><?php echo $producto['CANTIDAD']?></td>
        <td><?php echo $producto['PRECIO']?></td>
        <td><?php echo $subtotal= $producto['CANTIDAD'] * $producto['PRECIO']?></td>
        
        <td>
            <form action="accionesCarrito.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $producto["ID"]?>">
            <button class="btn-dlt" type="submit" name="action" value="eliminarProducto">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php $total=$total + ($producto['PRECIO']*$producto['CANTIDAD']);?>
    <?php } ?>
    <tr>
        <td colspan="3" align="right"><h2>Total</h2></td>
        <td align="right"><h2><?php echo number_format($total,2);?>€</h2</td>
        <td></td>
    </tr>
    
    <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>

            <form style= float:right action="recogerPedidos.php" method="POST">
        <input class="btn-emp-2" type="submit" name="pedido" value="Realizar Pedido">
        <input type="hidden" name="action" value="crearventa">
            </form>

            </td>
        </tr>

</table>


<?php }else{
    echo "<div class='empty-cart'><h5>No hay productos en el carrito</h5>";
    echo "<a class='btn-dlt' href='interfaz_cliente.php'> Volver</a></div>";
}
}

function listaCarritoCompra(){
    session_start();
    
    if(!empty($_SESSION["carrito"])){
        echo "<a class='btn-dlt' href='interfaz_cliente.php'> Volver</a></div>";
        ?>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Precio Ud.</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
        <?php $total=0;?>
        <?php foreach($_SESSION["carrito"] as  $indice => $producto){?>
        <tr>
            <td><?php echo $producto['NOMBRE']?></td>
            <td><?php echo $producto['CANTIDAD']?></td>
            <td><?php echo $producto['PRECIO']?></td>
            <td><?php echo $subtotal= $producto['CANTIDAD'] * $producto['PRECIO']?></td>
            
            <td>
                <form action="accionesCarrito.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $producto["ID"]?>">
                <button class="btn-dlt" type="submit" name="action" value="eliminarProducto">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php $total=$total + ($producto['PRECIO']*$producto['CANTIDAD']);?>
        <?php } ?>
        <tr>
            <td colspan="3" align="right"><h2>Total</h2></td>
            <td align="right"><h2><?php echo number_format($total,2);?>€</h2</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>

            <form style= float:right action="recogerPedidos.php" method="POST">
        <input class="btn-emp-2" type="submit" name="pedido" value="Realizar Pedido">
        <input type="hidden" name="action" value="crearcompra">
            </form>

            </td>
        </tr>
        
    </table>
    <br>

    
    <br>
    
    <?php }else{
        echo "<div class='empty-cart'><h5>No hay productos en el carrito</h5>";
        echo "<a class='btn-dlt' href='interfaz_cliente.php'> Volver</a></div>";
    }
    
    
    }

?>

  
</body>
</html>
