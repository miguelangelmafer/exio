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

<h2>Listado de clientes</h2>

<a class="btn-dlt" href="interfaz_empleado.php">Volver</a>
<br><br>
<a class="btn-emp-2" href="descarga.php?file=modelo_creacion_clientes.csv">Descargar modelo creación clientes</a>
<br><br>
<form action="importar.php" enctype="multipart/form-data" method="POST">
		<input type="file" name="file" accept=".csv">
		<br><br>
		<input type="hidden" name="action" value="crearClientes">
		<input type="submit" name="import" value="Subir fichero">
	</form>
<br>
	<form action="accionesClientes.php" method="post">
			<input type="hidden" name="action" value="crear">
			<input class="btn-emp-2" type="submit" value="Crear Cliente">
	</form>
	<br>
<div>
	<table>
		<tr>
			<th>ID</th>
			<th>Razón Social</th>
			<th>Email</th>
			<th>CIF</th>
			<th>Dirección</th>
			<th>Código Postal</th>
			<th>Población</th>
			<th>Provincia</th>
			<th>Teléfono</th>
			<th></th>
			<th></th>
		</tr>

<?php

require("config.php");

$sql="SELECT * FROM clientes";

//result set , record set

$consulta = mysqli_query(conectarDB(),$sql);
//fetch accede a la primera linea del result set con el while accedemos a todos
//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
while($mostrar = $consulta->fetch_assoc()){
	?>
<tr>
	<td><?php echo $mostrar["id"]?></td>
	<td><?php echo $mostrar["razon_social"]?></td>
	<td><?php echo $mostrar["email"]?></td>
	<td><?php echo $mostrar["cif"]?></td>
	<td><?php echo $mostrar["direccion"]?></td>
	<td><?php echo $mostrar["codigo_postal"]?></td>
	<td><?php echo $mostrar["poblacion"]?></td>
	<td><?php echo $mostrar["provincia"]?></td>
	<td><?php echo $mostrar["telefono"]?></td>
	<td>
		<!--En la primera linea obtenemos el id que queremos editar, en la segunda definimos la accion del boton para el switch-->
		<form action="accionesClientes.php" method="post">
			<input type="hidden" name="id" value="<?php echo $mostrar ["id"]?>">
			<input type="hidden" name="action" value="editar">
			<input class="btn-list" type="submit" value="Editar">
		</form>
	
	</td>

	<td>
		<form action="accionesClientes.php" method="post">
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