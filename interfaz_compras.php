<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style2.css">
	<title></title>

</head>
<body>

<?php

//con esto evitamos que un usuario no regitrado pueda acceder a la página
session_start();

if (!isset($_SESSION["usuario_empleado"])){
	echo "No autenticado";

	header("Location: Validacion.php");
	exit;
}

else{
	require("config.php");
	//posiblemente se puede quitar
	//echo "Usuario: " . $_SESSION["usuario_cliente"];
	$usuario = $_SESSION["usuario_empleado"];
	$sql="SELECT * FROM empleados WHERE email= '$usuario'";

//result set 

$consulta = mysqli_query(conectarDB(),$sql);

//regodemos el nombre del cliente y su id de BD para utilizarlo
while($mostrar = $consulta->fetch_assoc()){
	$id_del_empleado=$mostrar["id"];
?>
	<h2>Bienvenido <?php echo $mostrar ["nombre"]; }?> </h2>

	
	<a class=" btn-emp-2" href="listarCompras.php">Ver pedidos realizados</a><br>

	<div class="element-top-2">
            <form action="listarCarrito.php" method="POST">
            <button  class="btn-emp-2" type="submit" name="action" value="listarCarritoCompra">Ver carrito</button>
			</form>
	</div>

<br>
	<a class="btn-dlt" href="interfaz_empleado.php">Volver</a><br>

<br>
<br>

<div>
	<table>
		<tr>
			<th>Nombre</th>
			<th>EAN</th>
			<th>Precio</th>
			<th>Stock</th>
			<th>Cantidad</th>
			<th></th>
		</tr>

<?php

}



$sql="SELECT * FROM articulos";

//listamos todos los productos del catálogo y los mostramos en una tabla

$consulta = mysqli_query(conectarDB(),$sql);


while($mostrar = $consulta->fetch_assoc()){
	$id_usuario=$mostrar["id"]; // se puede quitar
	?>
<tr>
	<td style: display hidden><?php echo $mostrar["id"]?></td>
	<td>	
		<form action="interfaz_compras.php" method="post">
		<input type="text" name="nombre" value="<?php echo $mostrar ["nombre"]?>" readonly>
	</td>
	<td>
		<input type="text" name="ean" value="<?php echo $mostrar ["ean"]?>" readonly>
	</td>
	<td>
		<input type="text" name="p_coste" value="<?php echo $mostrar ["p_coste"]?>" readonly>
	</td>
	<td>
		<input type="text" name="stock" value="<?php echo $mostrar ["stock"]?>" readonly>
	</td>
	<td>
	<input type="number" step="1" min="0" max="" name="cantidad" value="0" style="width: 4em;">
	</td>
	<td>
			<input type="hidden" name="id" value="<?php echo $mostrar ["id"]?>">
			<input class="añadir" type="submit" name="btn-add" value="Añadir producto">
		</form>
	
	</td>
</tr>



<?php

}?>

</table>
</div>


<?php

//añadimos los productos a la variable session

if (isset($_POST["id"])){


if(!isset($_SESSION["carrito"])){
	$producto = array(
		'ID'  => $_POST['id'],
		'CANTIDAD' =>$_POST['cantidad'],
		'NOMBRE' =>$_POST['nombre'],
		'PRECIO' =>$_POST['p_coste']
	);
	$_SESSION["carrito"][0]=$producto;
	$mensaje=0;
}else{

	//comprobar que se añada solo 1 vez cada
	$idProductos=array_column($_SESSION["carrito"],"ID");

	if(in_array($_POST["id"],$idProductos)){
		echo "<script>alert('El producto ya ha sido añadido al carrito')</script>";
	}else{

	$NumeroProductos=count($_SESSION["carrito"]);
	$producto = array(
		'ID'  => $_POST['id'],
		'CANTIDAD' =>$_POST['cantidad'],
		'NOMBRE' =>$_POST['nombre'],
		'PRECIO' =>$_POST['p_coste']
	);
	$_SESSION["carrito"][$NumeroProductos]=$producto;
		}
	}
}

if(!isset($_SESSION["carrito"])){
	//echo "carrito vacio";
	$mensaje=0;

}else{
	$mensaje=count($_SESSION["carrito"]);
	
}

echo "<div class='element-top'>
<img onclick='mostrarCarrito()' src='img/carrito.png'>  

($mensaje) </div>";


?>

 </body>
</html>