<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>


<h2>Listado de pedidos realizados</h2>

<?php

session_start();

if(isset($_SESSION["usuario_cliente"])){
	echo "<a class='btn-dlt' href='interfaz_cliente.php'>Volver</a>";
}
else{
	echo "<a class='btn-dlt' href='interfaz_empleado.php'>Volver</a>";
}
?>

<br>

<div>
	<table>
		<tr>
			<th>ID</th>
			<th>Fecha Pedido</th>
            <th>Cliente</th>
			<th>Acciones</th>
		</tr>

<?php

require("config.php");


if(isset($_SESSION["usuario_cliente"])){

	$user_email=$_SESSION["usuario_cliente"];
	
	$sql="SELECT V.id,V.fecha,C.razon_social FROM ventas V , clientes C WHERE V.id_cliente= C.id && C.email = '$user_email'";
	}
	
	else{
	
	$sql="SELECT V.id,V.fecha,C.razon_social FROM ventas V , clientes C WHERE V.id_cliente= C.id ";
	}



//result set , record set

$consulta = mysqli_query(conectarDB(),$sql);
//fetch accede a la primera linea del result set con el while accedemos a todos
//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
while($mostrar = $consulta->fetch_assoc()){
	?>
<tr>
	<td><?php echo $mostrar["id"]?></td>
	<td><?php echo $mostrar["fecha"]?></td>
    <td><?php echo $mostrar["razon_social"]?></td>
	<td>
		<!--En la primera linea obtenemos el id que queremos editar, en la segunda definimos la accion del boton para el switch-->
		<form action="listarLineasVenta.php" method="post">
			<input type="hidden" name="id" value="<?php echo $mostrar ["id"]?>">
			<input type="hidden" name="action" value="editar">
			<input class="btn-list" type="submit" value="Detalle pedido">
		</form>
	
	</td>
</tr>
<?php
}

mysqli_close(conectarDB());

?>

</table>
</div>

 </body>
</html>