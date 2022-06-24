<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="style2.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
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

//$id=$_POST["id"];
$accion=$_POST["action"];

//echo "Acción POST: " . $accion; ?> <br><?php
//echo "Id a " . $accion . " " . $id;



switch ($accion) {

	case 'crear':
		creacionArticulo();
		break;

	case 'editar':
		edicionArticulo();
		break;
	
	case 'eliminar':
		eliminacionArticulo();
		break;

	case 'editarArticulo':
		editarArticuloBD($_POST["id_articulo"],$_POST["nombre"],  $_POST["ean"],$_POST["coste"],$_POST["venta"],$_POST["proveedor"],$_POST["stock"]);
		break;


	case 'eliminarArticulo':
		eliminarArticuloBD($_POST["id_articulo"]);
		break;


	case 'crearArticulo':
		crearArticuloBD($_POST["nombre"],$_POST["ean"],$_POST["coste"],$_POST["venta"],$_POST["proveedor"],$_POST["stock"]);
		break;


}

function creacionArticulo(){

	?>

<a class="btn-dlt" href="listarArticulos.php"> Volver </a>

<div class="form-emp">

	<form action="accionesArticulos.php" method="POST">
		<h2>Crea un producto</h2><br>
		<input type="hidden" name="action" value="crearArticulo"><br>
		<label>Nombre</label><br>
		<input type="text" name="nombre"><br>
		<label>EAN</label><br>
		<input type="text" name="ean"><br>
		<label>Coste</label><br>
		<input type="text" name="coste"><br>
		<label>Venta</label><br>
		<input type="text" name="venta"><br>
		<label>Proveedor</label><br>
		<input type="text" name="proveedor"><br>
		<label>Stock</label><br>
		<input type="text" name="stock"><br><br>
		<input class="btn-emp-2" type="submit" value = "Crear"><br>
	</form>
</div>
<?php

}


function edicionArticulo(){

	//por parametro le pasamos el valor del formulario/tabla inicial

	$articulo = getArticulo($_POST["id"]);
?>

<div class="form-emp">

        <form  action="accionesArticulos.php" method="post">

		<h2>Edita el producto</h2>

    		<input type="hidden" name="action" value="editarArticulo">
    	
    		<input type="hidden" name="id_articulo" value="<?php echo $articulo["id"]?>">

    		<label for="nombre">Nombre</label><br>
    		<input type="text" name="nombre" value="<?php echo $articulo ["nombre"]?>" >
    		<br>
			<label for="nombre">EAN</label><br>
    		<input type="text" name="ean" value="<?php echo $articulo ["ean"]?>" >
    		<br>
			<label for="nombre">Coste</label><br>
    		<input type="text" name="coste" value="<?php echo $articulo ["p_coste"]?>" >
    		<br>
			<label for="nombre">Venta</label><br>
    		<input type="text" name="venta" value="<?php echo $articulo ["p_venta"]?>" >
    		<br>
			<label for="nombre">Proveedor</label><br>
    		<input type="text" name="proveedor" value="<?php echo $articulo ["id_proveedor"]?>" >
    		<br>
			<label for="nombre">Stock</label><br>
    		<input type="text" name="stock" value="<?php echo $articulo ["stock"]?>" >
    		<br><br>
			
    		<input class="btn-emp-2" type="submit" value = "Guardar">
    	</form> 
		<br>
    	<form action="listarArticulos.php" method="post">
    		<input class="btn-dlt" type="submit" value = "Cancelar">   		
    	</form>  
</div> 

        <?php
    }


function eliminacionArticulo(){

	$articulo = getArticulo($_POST["id"]);

	?>
		<h2>¿Desea eliminar el registro?</h2>
        <form action="accionesArticulos.php" method="post">

    		<input type="hidden" name="action" value="eliminarArticulo">
    		
    		<input type="hidden" name="id_articulo" value="<?php echo $articulo["id"]?>">
			<h2><?php echo $articulo ["nombre"]?></h2>
    		<input class="btn-emp-2" type="submit" value = "Sí">
    	</form> 
		<br>
    	<form action="listarArticulos.php" method="post">
    		<input class="btn-dlt" type="submit" value = "No">   		
    	</form>   
        <?php
}

// me permite mostrar los datos a editar
function getArticulo($id){
	
	include("config.php");

	conectarDB();


	$query = "SELECT * FROM articulos WHERE id=" . $id;

	$result = mysqli_query(conectarDB(), $query);

	if($result){
		$row = $result->fetch_assoc();
	
	}

	else{
		echo "Error en la consulta" . mysqli_error(conectarDB());

		echo $row;
	}

	//Cerramos la conexion
	conectarDB()->close();

	return $row;
}


function editarArticuloBD($id_articulo,$nombre,$ean,$coste,$venta,$proveedor,$stock){
	include("config.php");
	$con=conectarDB();

    $query = "UPDATE articulos ";
    $query .="SET ";
    $query .=" nombre ='" . $nombre . "',";
    $query .=" ean ='" . $ean . "',";
    $query .=" p_coste ='" . $coste . "',";
	$query .=" p_venta ='" . $venta . "',";
	$query .=" id_proveedor ='" . $proveedor . "',";
    $query .=" stock ='" . $stock . "' ";
    $query .="WHERE id=" . $id_articulo;


    
    $result = mysqli_query($con, $query);
    if ($result==false) {

		$error = mysqli_error($con);
		if(str_contains($error,'ean')){
			echo "<div class='btn-dlt'>El ean " . $ean . " ya está registrado</div><br><br>";
			?><a class="btn-dlt" href="listarArticulos.php">Volver</a><br><?php
		}else{
			echo "Error al modificar datos";
			echo $sql;
			?><a class="btn-dlt" href="listarArticulos.php">Volver</a><br><?php
		}
	
    }
    else {
		echo "<div class='success-msg' <h5>Articulo modificado</h5></div> <br> <br>";?>
        <a class="btn-dlt" href="listarArticulos.php">Volver</a><br>
    <?php 
    }
        
    conectarDB()->close();

}


function eliminarArticuloBD($id_articulo){

	include("config.php");
    

 	 $query = "DELETE FROM articulos ";
    $query .= "WHERE id=" . $id_articulo;

    
    $result = mysqli_query(conectarDB(), $query);
    if ($result) {
        echo "<div class='success-msg'<h5>Articulo Eliminado</h5></div><br> <br>";?>
        <a class="btn-dlt" href="listarArticulos.php">Volver</a><br>
    <?php 
    }
    else {
        echo "Error query:" . mysqli_error(conectarDB());
    }
        
    conectarDB()->close();

}

	function crearArticuloBD($nombre,$ean,$coste,$venta,$proveedor,$stock){
	
	include("config.php");

	$con = conectarDB();

	$sql="INSERT INTO articulos (nombre,ean,p_coste,p_venta,id_proveedor,stock) VALUES ('$nombre','$ean','$coste','$venta','$proveedor','$stock')";
	$consulta = mysqli_query($con,$sql);
	

	if($consulta==false){
			$error = mysqli_error($con);
			if(str_contains($error,'ean')){
				echo "<div class='btn-dlt'>El ean " . $ean . " ya está registrado</div><br><br>";
			} else{
				echo "Error al introducir datos";
				echo $sql;
				?><a class="btn-dlt" href="listarArticulos.php">Volver</a><br><?php
			}
	}

	else{
		echo "<div class='success-msg'><h5>Registro " . $nombre . " guardado correctamente</h5></div><br><br>";
		?>
        <a class="btn-dlt" href="listarArticulos.php">Volver</a><br>
    <?php 
	}

	conectarDB()->close();
}	

?>


</body>
</html>