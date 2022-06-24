<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="style2.css">
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
	//echo "Usuario: " . $_SESSION["usuario_empleado"];
}

?>
<h2>Listado de artículos</h2>
	<a class="btn-dlt" href="interfaz_empleado.php">Volver</a>
	
	<br><br>
	<a class= "btn-emp-2" href="descarga.php?file=modelo_creacion_productos.csv">Descargar modelo creación articulos</a>
	<br><br>
	


	<form action="importar.php" enctype="multipart/form-data" method="POST">
		<input type="file" name="file" accept=".csv">
		<br><br>
		<input type="hidden" name="action" value="crearProductos">
		<input type="submit" name="import" value="Subir fichero">
	</form>

<br>




<form action="accionesArticulos.php" method="post">
			<input type="hidden" name="action" value="crear">
			<input class="btn-emp-2" type="submit" value="Crear artículo">
	</form>
	<br>
<div>
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>EAN</th>
			<th>Coste</th>
			<th>Venta</th>
			<th>Proveedor</th>
			<th>Stock</th>
			<th></th>
			<th></th>
		</tr>

<?php

require("config.php");

//$sql="SELECT * FROM articulos ";
$sql="SELECT A.id, A.nombre,A.p_coste,A.p_venta,A.ean,A.stock, P.razon_social FROM articulos A , proveedores P WHERE A.id_proveedor = P.id";


//result set , record set

$consulta = mysqli_query(conectarDB(),$sql);
//fetch accede a la primera linea del result set con el while accedemos a todos
//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
while($mostrar = $consulta->fetch_assoc()){
	?>
<tr>
	<td><?php echo $mostrar["id"]?></td>
	<td><?php echo $mostrar["nombre"]?></td>
	<td><?php echo $mostrar["ean"]?></td>
	<td><?php echo $mostrar["p_coste"]?></td>
	<td><?php echo $mostrar["p_venta"]?></td>
	<td><?php echo $mostrar["razon_social"]?></td>
	<td><?php echo $mostrar["stock"]?></td>
	<td>
		<!--En la primera linea obtenemos el id que queremos editar, en la segunda definimos la accion del boton para el switch-->
		<form action="accionesArticulos.php" method="post">
			<input type="hidden" name="id" value="<?php echo $mostrar ["id"]?>">
			<input type="hidden" name="action" value="editar">
			<input class="btn-list" type="submit" value="Editar">
		</form>
	
	</td>

	<td>
		<form action="accionesArticulos.php" method="post">
			<input type="hidden" name="id" value="<?php echo $mostrar ["id"]?>">
			<input type="hidden" name="action" value="eliminar">
			<input class="btn-list-dlt" type="submit" value="Eliminar">
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