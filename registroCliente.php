<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>



<?php 


$accion=$_POST["action"];


switch ($accion) {

	case 'registroCliente':
		nuevoClienteBD($_POST["razon"],$_POST["email"],$_POST["cif"],$_POST["direccion"],$_POST["codigo_postal"],$_POST["poblacion"],$_POST["provincia"],$_POST["telefono"],$_POST["contrasena"]);
		break;

	case 'editar':
			edicionCliente();
			break;
	case 'editarCliente':
			edicionClienteBD($_POST["id_cliente"], $_POST["razon"],$_POST["email"],$_POST["cif"],$_POST["direccion"],$_POST["codigo_postal"],$_POST["poblacion"],$_POST["provincia"],$_POST["telefono"],$_POST["contrasena"]);
			break;
}

function nuevoClienteBD($razon,$email,$cif,$direccion,$codigo_postal,$poblacion,$provincia,$telefono,$contrasena){

	if($_POST["contrasena"] == $_POST["contrasena1"]){

	include("config.php");

	$con = conectarDB();

	$sql="INSERT INTO clientes (razon_social,email,cif,direccion,codigo_postal,poblacion,provincia,telefono,contrasena) VALUES ('$razon','$email','$cif','$direccion','$codigo_postal','$poblacion','$provincia','$telefono','$contrasena')";
	$consulta = mysqli_query($con,$sql);

	
	if($consulta==false){
		$error = mysqli_error($con);
		if(str_contains($error,'razon_social')){
			echo "<h4>La razon social " . $razon . " ya está registrada</h4>"?>;
			<a class="btn-dlt" href="registro_cliente.html">Volver</a><br><?php
		} 
		elseif(str_contains($error,'email')){
			echo "<h4>El email " . $email . " ya está registrado</h4>";?>
			<a class="btn-dlt" href="registro_cliente.html">Volver</a><br><?php
		} 
		elseif(str_contains($error,'cif')){
			echo "<h4>El cif " . $cif . " ya está registrado</h4>";?>
			<a class="btn-dlt" href="registro_cliente.html">Volver</a><br><?php
		} 
	
		else{
			echo "Error al introducir datos";?>
			<a class="btn-dlt" href="registro_cliente.html">Volver</a><br><?php
			
		}
	
    }

	else{

        session_start();

		$_SESSION["usuario_cliente"] = $email;

		echo "Bienvenido". $_SESSION["usuario_cliente"] = $email;


		header("Location: interfaz_cliente.php");
		exit;
	}

	conectarDB()->close();
}

//cuando las contraseñas no coinciden.
else{

	?>
	  <div class="form-ini">


        <form action="registroCliente.php" method="POST">
			<h3>Registro Cliente</h3>
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
            <input type="text"name="poblacion"><br>
            <label>Provincia</label><br>
            <input type="text" name="provincia"><br>
            <label>Teléfono</label><br>
            <input type="text" name="telefono"><br>
			<p style=color:red>Las contraseñas introducidas no coinciden</p>
            <label>Contraseña</label><br>
            <input type="password" name="contrasena"><br>
            <label>Repetir contraseña</label><br>
            <input type="password" name="contrasena1"><br><br>
            <input class="btn-ini" type="submit" value="Crear usuario">
            <input type="hidden" name="action" value="registroCliente">
			<button class="btn-ini">
            <a href="index.html">Ya soy cliente</a>
			</button>
        </form>
    </div>

	<?php
}

}

function edicionCliente(){
	

	$cliente = getCliente($_POST["id"]);
?>
	 <div class="form-ini">
        <form  action="registroCliente.php" method="post">
			<h2>Edita tus datos</h2>

    		<input type="hidden" name="action" value="editarCliente">
    	
    		<input type="hidden" name="id_cliente" value="<?php echo $cliente["id"]?>">

    		<label for="nombre">Razón Social</label><br>
    		<input type="text" name="razon" value="<?php echo $cliente ["razon_social"]?>" >
    		<br>
			<label for="nombre">Email</label><br>
    		<input type="text" name="email" value="<?php echo $cliente ["email"]?>" readonly>
    		<br>
			<label for="nombre">CIF</label><br>
    		<input type="text" name="cif" value="<?php echo $cliente ["cif"]?>" >
    		<br>
			<label for="nombre">Dirección</label><br>
    		<input type="text" name="direccion" value="<?php echo $cliente ["direccion"]?>" >
    		<br>
			<label for="nombre">Código Postal</label><br>
    		<input type="text" name="codigo_postal" value="<?php echo $cliente ["codigo_postal"]?>" >
    		<br>
			<label for="nombre">Población</label><br>
    		<input type="text" name="poblacion" value="<?php echo $cliente ["poblacion"]?>" >
			<br>
			<label for="nombre">Provincia</label><br>
    		<input type="text" name="provincia" value="<?php echo $cliente ["provincia"]?>" >
			<br>
			<label for="nombre">Teléfono</label><br>
    		<input type="text" name="telefono" value="<?php echo $cliente ["telefono"]?>" >
    		<br>
			<label for="nombre">Nueva contraseña</label><br>
    		<input type="password" name="contrasena" value="" >
    		<br>

    		<br>
			
    		<input class="btn-ini" type="submit" value = "Guardar">
			<button class="btn-ini">
			<a href="interfaz_cliente.php">Cancelar</a>
			</button>
    	</form>    
	</div>
        <?php
}

function getCliente($id_del_cliente){
	
	include("config.php");

	conectarDB();


	$query = "SELECT * FROM clientes WHERE id=" . $_POST["id"];;

	$result = mysqli_query(conectarDB(), $query);

	if($result){
		$row = $result->fetch_assoc();
	
	}

	else{
		echo "<h4>Error en la consulta" . mysqli_error(conectarDB()) ."</h4>";

		echo $row;
	}

	//Cerramos la conexion
	conectarDB()->close();

	return $row;
}


function edicionClienteBD($id_cliente,$razon,$email,$cif,$direccion,$codigo_postal,$poblacion,$provincia,$telefono){
	include("config.php");
	$con = conectarDB();
	
    $query = "UPDATE clientes ";
    $query .="SET ";
    $query .=" razon_social ='" . $razon . "',";
    $query .=" email ='" . $email . "',";
    $query .=" CIF ='" . $cif . "',";
	$query .=" direccion ='" . $direccion . "',";
	$query .=" codigo_postal ='" . $codigo_postal . "',";
	$query .=" poblacion ='" . $poblacion . "',";
	$query .=" provincia ='" . $provincia . "',";
    $query .=" telefono ='" . $telefono . "' ";
    $query .="WHERE ID=" . $id_cliente;


    
    $result = mysqli_query($con, $query);
    if($result==false){
		$error = mysqli_error($con);
		if(str_contains($error,'razon_social')){
			echo "<div class='btn-dlt'><h4>La razón social " . $razon . " ya está registrada</h4></div><br><br>";?>
			<a class="btn-dlt" href="interfaz_cliente.php">Volver</a><br><?php
		}elseif(str_contains($error,'email')){
			echo "<div class='btn-dlt'><h4>El email " . $email . " ya está registrado</h4></div><br><br>";?>
			<a class="btn-dlt" href="interfaz_cliente.php">Volver</a><br><?php
		}elseif(str_contains($error,'cif')){
			echo "<div class='btn-dlt'><h4>El cif " . $cif . " ya está registrado</h4></div><br><br>";?>
			<a class="btn-dlt" href="interfaz_cliente.php">Volver</a><br><?php
		}else{
			echo "Error al introducir datos";
			echo $sql;
			?>
			<a class="btn-dlt" href="interfaz_cliente.php">Volver</a><br><?php
		}
	}
    else {
		echo "<h4>Datos modificados <br></h4>";?>
        <a class="btn-dlt" href="interfaz_cliente.php">Volver</a><br>
    <?php 
    }
        
    conectarDB()->close();

}

?>
</body>
</html>