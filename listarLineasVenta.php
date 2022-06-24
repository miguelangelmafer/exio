<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>

<?php $id_venta=$_POST["id"];?>

<h2>Detalle pedido <?php echo $id_venta?></h2>

<br>


<a class='btn-dlt' href='listarVentas.php'>Volver</a>


<div>
	<table>
		<tr>
			<th>Producto pedido</th>
			<th>Cantidad</th>
		</tr>

<?php

require("config.php");

$sql="SELECT * FROM articulos_ventas AV, articulos A WHERE A.id = AV.id_articulo AND id_venta=$id_venta";


//result set , record set

$consulta = mysqli_query(conectarDB(),$sql);
//fetch accede a la primera linea del result set con el while accedemos a todos
//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
while($mostrar = $consulta->fetch_assoc()){
	?>
<tr>
	<td><?php echo $mostrar["nombre"]?></td>
	<td><?php echo $mostrar["cantidad"]?></td>
</tr>
<?php
}

mysqli_close(conectarDB());

?>

</table>
</div>

 </body>
</html>