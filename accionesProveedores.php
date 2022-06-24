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



//$id_nombre=$_POST["id"];
$accion=$_POST["action"];

//echo "Acción POST: " . $accion; ?> <br><?php
//echo "Id a " . $accion . " " . $id_nombre;



switch ($accion) {

	case 'crear':
		creacionProveedor();
		break;

	case 'editar':
		edicionProveedor();
		break;
	
	case 'eliminar':
		eliminacionProveedor();
		break;

	case 'editarProveedor':
		editarProveedorBD($_POST["id_proveedor"],$_POST["razon"],$_POST["email"],$_POST["cif"],$_POST["direccion"],$_POST["codigo_postal"],$_POST["poblacion"],$_POST["provincia"],$_POST["telefono"]);
		break;


	case 'eliminarProveedor':
		eliminarProveedorBD($_POST["id_proveedor"]);
		break;


	case 'crearProveedor':
		crearProveedorBD($_POST["razon"],$_POST["email"],$_POST["cif"],$_POST["direccion"],$_POST["codigo_postal"],$_POST["poblacion"],$_POST["provincia"],$_POST["telefono"]);
		break;


}

function creacionProveedor(){

	?>

<a class="btn-dlt" href="listarProveedores.php"> Volver </a>

<div class="form-emp">
	<form action="accionesProveedores.php" method="POST">
		<h2>Crea un proveedor</h2>
		<input type="hidden" name="action" value="crearProveedor">
		<label>Razón Social</label><br>
		<input type="text" name="razon"><br>
		<label>Email</label><br>
		<input type="text" name="email"><br>
		<label>CIF</label><br>
		<input type="text" name="cif"><br>
		<label>Dirección</label><br>
		<input type="text" name="direccion"><br>
		<label>Código Postal</label><br>
		<input type="text" name="codigo_postal"><br>
		<label>Población</label><br>
		<input type="text" name="poblacion"><br>
		<label>Provincia</label><br>
		<input type="text" name="provincia"><br>
		<label>Teléfono</label><br>
		<input type="text" name="telefono"><br><br>
		<input class="btn-emp-2" type="submit" value = "Crear">
	</form>
</div>
<?php

}


function edicionProveedor(){

	//por parametro le pasamos el valor del formulario/tabla inicial

	$proveedor = getProveedores($_POST["id"]);
?>
	<div class="form-emp">
        <form action="accionesProveedores.php" method="post">
			<h2>Edita el proveedor</h2>
    		<input type="hidden" name="action" value="editarProveedor">
    	
    		<input type="hidden" name="id_proveedor" value="<?php echo $proveedor["id"]?>">

    		<label for="nombre">Razón Social</label><br>
    		<input type="text" name="razon" value="<?php echo $proveedor ["razon_social"]?>" >
    		<br>
			<label for="nombre">Email</label><br>
    		<input type="text" name="email" value="<?php echo $proveedor ["email"]?>" >
    		<br>
			<label for="nombre">CIF</label><br>
    		<input type="text" name="cif" value="<?php echo $proveedor ["cif"]?>" >
    		<br>
			<label for="nombre">Dirección</label><br>
    		<input type="text" name="direccion" value="<?php echo $proveedor ["direccion"]?>" >
    		<br>
			<label for="nombre">Código Postal</label><br>
    		<input type="text" name="codigo_postal" value="<?php echo $proveedor ["codigo_postal"]?>" >
    		<br>
			<label for="nombre">Población</label><br>
    		<input type="text" name="poblacion" value="<?php echo $proveedor ["poblacion"]?>" >
			<br>
			<label for="nombre">Provincia</label><br>
    		<input type="text" name="provincia" value="<?php echo $proveedor ["provincia"]?>" >
			<br>
			<label for="nombre">Teléfono</label><br>
    		<input type="text" name="telefono" value="<?php echo $proveedor ["telefono"]?>" >
    		<br>

    		<br><br>
			
    		<input class="btn-emp-2" type="submit" value = "Guardar">
    	</form> 
		<br>
    	<form action="listarProveedores.php" method="post">
    		<input class="btn-dlt" type="submit" value = "Cancelar">   		
    	</form>   
	</div>
        <?php
    }


function eliminacionProveedor(){

	$proveedor = getProveedores($_POST["id"]);

	?>
		<h2>¿Desea eliminar el registro?</h2>
        <form action="accionesProveedores.php" method="post">

    		<input type="hidden" name="action" value="eliminarProveedor">
    		
    		<input type="hidden" name="id_proveedor" value="<?php echo $proveedor["id"]?>">
			<h2><?php echo $proveedor ["razon_social"]?></h2>
    		<input class="btn-emp-2" type="submit" value = "Sí">
    	</form> 
	<br>
    	<form action="listarProveedores.php" method="post">
    		<input class="btn-dlt" type="submit" value = "No">   		
    	</form>   
        <?php
}

// me permite mostrar los datos a editar
function getProveedores($id){
	
	include("config.php");

	conectarDB();


	$query = "SELECT * FROM proveedores WHERE id=" . $id;

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


function editarProveedorBD($id_proveedor,$razon,$email,$cif,$direccion,$codigo_postal,$poblacion,$provincia,$telefono){
	include("config.php");
	$con=conectarDB();
	
    $query = "UPDATE proveedores ";
    $query .="SET ";
    $query .=" razon_social ='" . $razon . "',";
    $query .=" email ='" . $email . "',";
    $query .=" cif ='" . $cif . "',";
	$query .=" direccion ='" . $direccion . "',";
	$query .=" codigo_postal ='" . $codigo_postal . "',";
	$query .=" poblacion ='" . $poblacion . "',";
	$query .=" provincia ='" . $provincia . "',";
    $query .=" telefono ='" . $telefono . "' ";
    $query .="WHERE id=" . $id_proveedor;


    
    $result = mysqli_query($con, $query);
    if ($result==false) {
		$error = mysqli_error($con);
		if(str_contains($error,'razon_social')){
			echo "<div class='btn-dlt'>La razón social " . $razon . " ya está registrada</div><br><br>";
			?><a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}elseif(str_contains($error,'email')){
			echo "<div class='btn-dlt'>El email " . $email . " ya está registrado</div><br><br>";
			?><a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}
		elseif(str_contains($error,'cif')){
			echo "<div class='btn-dlt'>El cif " . $cif . " ya está registrado</div><br><br>";
			?><a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}

		else{
		echo "Error query:" . mysqli_error(conectarDB());
		echo $query;
		?><a class="btn-dlt" href="listarClientes.php">Volver</a><br><?php
		}
	}
       
    else {
		echo "<div class='success-msg'><h5>Proveedor modificado</h5></div><br> <br>";?>
        <a class="btn-dlt" href="listarProveedores.php">Volver</a><br>
    <?php 
    }
        
    conectarDB()->close();

}


function eliminarProveedorBD($id_proveedor){

	include("config.php");
    

 	 $query = "DELETE FROM proveedores ";
    $query .= "WHERE ID=" . $id_proveedor;

    
    $result = mysqli_query(conectarDB(), $query);
    if ($result) {
        echo "<div class='success-msg'> <h5>Proveedor eliminado</h5></div><br> <br>";?>
        <a class="btn-dlt" href="listarProveedores.php">Volver</a><br>
    <?php 
    }
    else {
        echo "Error query:" . mysqli_error(conectarDB());
    }
        
    conectarDB()->close();

}



	function crearProveedorBD($razon,$email,$cif,$direccion,$codigo_postal,$poblacion,$provincia,$telefono){
	
	include("config.php");

	$con = conectarDB();

	$sql="INSERT INTO proveedores (razon_social,email,cif,direccion,codigo_postal,poblacion,provincia,telefono) VALUES ('$razon','$email','$cif','$direccion','$codigo_postal','$poblacion','$provincia','$telefono')";
	$consulta = mysqli_query($con,$sql);


	if($consulta==false){
		$error = mysqli_error($con);
		if(str_contains($error,'razon_social')){
			echo "<div class='btn-dlt'>La razón social " . $razon . " ya está registrada</div><br><br>";?>
			<a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}elseif(str_contains($error,'email')){
			echo "<div class='btn-dlt'>El email " . $email . " ya está registrado</div><br><br>";?>
			<a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}elseif(str_contains($error,'cif')){
			echo "<div class='btn-dlt'>El cif " . $cif . " ya está registrado</div><br><br>";?>
			<a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}else{
			echo "Error al introducir datos";
			echo $sql;
			?>
			<a class="btn-dlt" href="listarProveedores.php">Volver</a><br><?php
		}
	
	}

	else{
		echo "<div class='success-msg'><h5>Registro " . $razon . " guardado correctamente </h5></div><br><br>";
		?>
        <a class="btn-dlt" href="listarProveedores.php">Volver</a><br>
    <?php 
	}

	conectarDB()->close();
}	

?>


</body>
</html>