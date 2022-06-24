<!DOCTYPE html>
<html>
<head>
	<title>Document</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
	
<?php
//realizamos la conexion a base de datos
include("config.php");


$email="";
$password="";

//comprobar si el los campos email y usuarios están rellenos
if(isset($_POST["user"]) && isset($_POST["pass"])  && isset($_POST["empleado"])){
    $email = $_POST["user"];
    $password = $_POST["pass"];
    $usuario="empleados";
}
elseif(isset($_POST["user"]) && isset($_POST["pass"])  && !isset($_POST["empleado"])){
    $email = $_POST["user"];
    $password = $_POST["pass"];
    $usuario="clientes";
}


if ($email==""){?>

<div class="form-ini">
       
        <form action="validacion.php" method= "POST">
        <h3>Inicio sesión</h3>
        <p style=color:red>Debe introducir un usuario</p>
            <label>Usuario</label><br>
            <input type="text" name="user"><br>
            <label>Contraseña</label><br>
            <input type="password" name="pass"><br><br>
            <input class="btn-ini" type="submit" value="Iniciar sesión">
            <button class="btn-ini">
            <a href="registro_cliente.html">Nuevo Usuario</a>
            </button>
            <br>
            <br>
            <label>¿Eres empleado?</label>
            <input type="checkbox" name="empleado"><br>
            
        </form>
    </div>
<?php
	}
	//Cuando el usuario sea valido tras haberlo comprobado en la función isUSuarioValidado, damos acceso a los distinto ficheros

else{
	$isValido = isUSuarioValidado($email,$password,$usuario);
	if($isValido && $usuario == "empleados"){

	session_start();
 
		$_SESSION["usuario_empleado"] = $email;


		header("Location: interfaz_empleado.php");
		exit;
	}

    if($isValido && $usuario == "clientes"){
		

	session_start();

		$_SESSION["usuario_cliente"] = $email;


		header("Location: interfaz_cliente.php");
		exit;
	}

	//si la variable isValido es false, consultar dicha funcion
	
}

function isUsuarioValidado($email,$password,$usuario){


	$conn = conectarDB();
	$query = "SELECT * FROM $usuario ";
	$query .= "WHERE email ='" . $email . "'";

	$result = mysqli_query($conn,$query);

	if($result){
		if($row = $result -> fetch_assoc()){
			if ($row["contrasena"]==$password){
			return true;
			}
			else{
		
                ?>
            
    <div class="form-ini">

        <form action="validacion.php" method= "POST">
        <h3>Inicio sesión</h3>
        <p style=color:red>Contraseña incorrecta</p>
            <label>Usuario</label><br>
            <input type="text" name="user"><br>
            <label>Contraseña</label><br>
            <input type="password" name="pass"><br><br>
            <input class="btn-ini" type="submit" value="Iniciar sesión">
            <button class="btn-ini">
            <a href="registro_cliente.html">Nuevo Usuario</a>
            </button>
            <br>
            <br>
            <label>¿Eres empleado?</label>
            <input type="checkbox" name="empleado"><br>
            
        </form>
    </div>
    <?php
			}
		}
		else{
			// si no da resultado la query, no se encuentra el usuario
            ?>
    <div class="form-ini">
        
        <form action="validacion.php" method= "POST">
        <h3>Inicio sesión</h3>
        <p style=color:red>El usuario introducido no existe</p>
            <label>Usuario</label><br>
            <input type="text" name="user"><br>
            <label>Contraseña</label><br>
            <input type="password" name="pass"><br><br>
            <input class="btn-ini" type="submit" value="Iniciar sesión">
            <button class="btn-ini">
            <a href="registro_cliente.html">Nuevo Usuario</a>
            </button>
            <br>
            <br>
            <label>¿Eres empleado?</label>
            <input type="checkbox" name="empleado"><br>
            
        </form>
    </div>
    <?php
		}
	}
	else{
		echo "Error query:". mysqli_error($conn);
	}
	$conn->close();
	return false;
	}

?>

</body>
</html>


