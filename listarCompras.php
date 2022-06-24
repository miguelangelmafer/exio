<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>

<?php
session_start();

if (!isset($_SESSION["usuario_empleado"])){
	echo "No autenticado";

	header("Location: Validacion.php");
	exit;
}

else{
	//echo "Usuario: " . $_SESSION["usuario_empleado"];
}

?>

<h2>Listado de pedidos realizados</h2>

<a class="btn-dlt" href="interfaz_empleado.php">Volver</a>

<br><br>

<div>
	<table>
		<tr>
			<th>ID</th>
			<th>Fecha Pedido</th>
            <th>Empleado</th>
			<th>Acciones</th>
		</tr>

<?php




require("config.php");


$sql="SELECT c.id,c.fecha,e.nombre FROM compras C , empleados E WHERE C.id_empleado= E.id ";


//result set , record set

$consulta = mysqli_query(conectarDB(),$sql);
//fetch accede a la primera linea del result set con el while accedemos a todos
//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
while($mostrar = $consulta->fetch_assoc()){
	?>
<tr>
	<td><?php echo $mostrar["id"]?></td>
	<td><?php echo $mostrar["fecha"]?></td>
    <td><?php echo $mostrar["nombre"]?></td>
	<td>
		<!--En la primera linea obtenemos el id que queremos editar, en la segunda definimos la accion del boton para el switch-->
		<form action="listarLineasCompra.php" method="post">
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