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
<h2>   <?php echo "Productos importados correctamente"?> </h2>


<table>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>EAN</th>
    <th>Coste</th>
    <th>Venta</th>
    <th>Proveedor</th>
    <th>Stock</th>
</tr>

<?php

require("config.php");

$sql="SELECT * FROM articulos";

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
<td><?php echo $mostrar["id_proveedor"]?></td>
<td><?php echo $mostrar["stock"]?></td>
</tr>
<?php
}

mysqli_close(conectarDB());

?>

</table>


<a class="btn-dlt" href="listarArticulos.php">Volver</a>

    
</body>
</html>
