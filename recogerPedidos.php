<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style2.css">
  <title>Document</title>
</head>
<body>


<?php

$accion=$_POST["action"];

switch ($accion) {

	case 'crearventa':
		creacionVenta();
		break;

	case 'crearcompra':
		creacionCompra();
		break;
    }

    function creacionVenta(){
      require("config.php");
      session_start();
      //posiblemente se puede quitar
      //echo "Usuario: " . $_SESSION["usuario_cliente"];
      $usuario = $_SESSION["usuario_cliente"];
      $sql="SELECT * FROM clientes WHERE email= '$usuario'";
  
  //result set , record set
  
  $consulta = mysqli_query(conectarDB(),$sql);
  //fetch accede a la primera linea del result set con el while accedemos a todos
  //while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
  while($mostrar = $consulta->fetch_assoc()){
  
      $id_usuario = $mostrar ["id"];
      
  }

 
  $id_sesion=session_id();
  //echo session_id();
  
  if(isset($_POST["pedido"])){
      
      
      
          $sql2="INSERT INTO ventas (id_cliente,sesion_venta) VALUES ('$id_usuario','$id_sesion')";
        
          $consulta = mysqli_query(conectarDB(),$sql2);
  
          
          if($consulta==false){
              echo "Error al introducir datos";
              echo $sql2;

          }
      
          else{
              echo "<div class='success-msg'><h5>Pedido realizado</div></h5>";
          }
      
          conectarDB()->close();
      }

      $sql3="SELECT id FROM `ventas` WHERE sesion_venta = '$id_sesion'";
      $consulta = mysqli_query(conectarDB(),$sql3);
  
  while($mostrar = $consulta->fetch_assoc()){
    echo "<br>";
    $id_venta=$mostrar["id"];
    echo "<br><div class='success-msg'><h5>Número de pedido: " . $mostrar["id"] . "</div></h5><br>";
  }

//ADAPTAR DESDE AQUI
  //comenzamos a realizar todos los insert
foreach($_SESSION["carrito"] as  $indice => $producto){
  $product=$producto['ID'];
  $product_quantity=$producto['CANTIDAD'];
  $sql4="INSERT INTO articulos_ventas (id_venta,id_articulo,cantidad) VALUES ($id_venta,$product,$product_quantity)";


  $sql5="SELECT stock FROM articulos WHERE id=$product";
  $consulta = mysqli_query(conectarDB(),$sql5);
  while($mostrar = $consulta->fetch_assoc()){
    $stock_previo=$mostrar["stock"];
    $stock_actual= $stock_previo - $product_quantity;
  }
  // luego cogemos el actual y le restamos el stock compra y hacemos un upodate en la tabla articulos

  $sql6="UPDATE articulos SET stock =$stock_actual WHERE id=$product";
  $consulta = mysqli_query(conectarDB(),$sql6);
 
    $consulta = mysqli_query(conectarDB(),$sql4);


        if($consulta==false){
          echo "Error al realizar pedido";
          exit;

        }

        else{
          unset($_SESSION["carrito"]);
          session_regenerate_id();
  
      }
}

    ?>
    <br>
    <a class="btn-dlt" href="interfaz_cliente.php">Volver</a>
    <?php 
    }

    function creacionCompra(){
      require("config.php");
      session_start();
      //posiblemente se puede quitar
      //echo "Usuario: " . $_SESSION["usuario_cliente"];
      $usuario = $_SESSION["usuario_empleado"];
      $sql="SELECT * FROM empleados WHERE email= '$usuario'";
  
  //result set , record set
  
  $consulta = mysqli_query(conectarDB(),$sql);
  //fetch accede a la primera linea del result set con el while accedemos a todos
  //while($mostrar = mysqli_fetch_row($consulta)) con valores [0] o [1]
  while($mostrar = $consulta->fetch_assoc()){
  
      $id_usuario = $mostrar ["id"];
      
  }

 
  $id_sesion=session_id();
  //echo session_id();
  
  if(isset($_POST["pedido"])){
      
      
      
          $sql2="INSERT INTO compras (id_empleado,sesion_compra) VALUES ('$id_usuario','$id_sesion')";
        
          $consulta = mysqli_query(conectarDB(),$sql2);
  
          
          if($consulta==false){
              echo "Error al introducir datos";
              echo $sql2;

          }
      
          else{
            echo "<div class='success-msg'><h5>Pedido realizado</div></h5>";
          }
      
          conectarDB()->close();
      }

      $sql3="SELECT id FROM `compras` WHERE sesion_compra = '$id_sesion'";
      $consulta = mysqli_query(conectarDB(),$sql3);
  
  while($mostrar = $consulta->fetch_assoc()){
    echo "<br>";
    $id_compra=$mostrar["id"];
    echo "<br><div class='success-msg'><h5>Número de pedido: " . $mostrar["id"] . "</div></h5><br>";
  }

//ADAPTAR DESDE AQUI
  //comenzamos a realizar todos los insert
foreach($_SESSION["carrito"] as  $indice => $producto){
  $product=$producto['ID'];
  $product_quantity=$producto['CANTIDAD'];
  $sql4="INSERT INTO articulos_compras (id_compra,id_articulo,cantidad) VALUES ($id_compra,$product,$product_quantity)";


  $sql5="SELECT stock FROM articulos WHERE id=$product";
  $consulta = mysqli_query(conectarDB(),$sql5);
  while($mostrar = $consulta->fetch_assoc()){
    $stock_previo=$mostrar["stock"];
    $stock_actual= $stock_previo + $product_quantity;
  }
  // luego cogemos el actual y le restamos el stock compra y hacemos un upodate en la tabla articulos

  $sql6="UPDATE articulos SET stock =$stock_actual WHERE id=$product";
  $consulta = mysqli_query(conectarDB(),$sql6);
 
    $consulta = mysqli_query(conectarDB(),$sql4);


        if($consulta==false){
          echo "Error al realizar pedido";
          exit;

        }

        else{
          unset($_SESSION["carrito"]);
          session_regenerate_id();
      }
}

    ?>
    <br>
    <a class="btn-dlt" href="interfaz_compras.php">Volver</a>
    <?php 
    }



?>




  
</body>
</html>



