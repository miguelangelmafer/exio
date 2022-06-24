<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<h2>   <?php echo "Proveedores importados correctamente"?> </h2>


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
</tr>

<?php

require("config.php");

$sql="SELECT * FROM proveedores";

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
</tr>
<?php
}

mysqli_close(conectarDB());

?>

</table>


<a class="btn-dlt" href="listarProveedores.php">Volver</a>

    
</body>
</html>
