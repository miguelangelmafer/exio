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
		//posibilidad de hacer una pagina de aviso de no tener permisos.
		header("Location: Validacion.php");
		exit;
	}
	
	else{

		require("config.php");
		$usuario = $_SESSION["usuario_empleado"];
		$sql="SELECT * FROM empleados WHERE email= '$usuario'";
	
	//result set , record set
	
	$consulta = mysqli_query(conectarDB(),$sql);
	//fetch accede a la primera linea del result set con el while accedemos a todos
	//while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
	while($mostrar = $consulta->fetch_assoc()){
	?>
		<h2>Bienvenido <?php echo $mostrar ["nombre"]; }?> </h2>

	<?php
	}
	
	?>


	<div class="contenedor">

	<button class="btn-emp">
		<h2><a href="listarArticulos.php">Artículos</a></h2>
	</button>

	<button class="btn-emp">
		<h2><a href="listarClientes.php">Clientes</a></h2>
	</button>

	<button class="btn-emp">
	<h2><a href="listarProveedores.php">Proveedores</a></h2>
	</button>

	<button class="btn-emp">
	<h2><a href="listarCompras.php">Compras</a></h2>
	</button>

	<button class="btn-emp">
	<h2><a href="listarVentas.php">Ventas</a></h2>
	</button>

	<button class="btn-emp">
	<h2><a href="interfaz_compras.php">Realizar Compra</a></h2>
	</button>

	<button class="btn-emp">
	<h2><a href="cerrarsesion.php">Salir</a></h2>
	</button>

	</div>

</body>
</html>