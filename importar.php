<?php

include("config.php");

conectarDB();

$accion=$_POST["action"];

//para ver que tipo de archivo estan subiendo.?
switch($accion){
    case 'crearProductos':
		creacionArticulos();
		break;
    case 'crearClientes':
         creacionClientes();
         break;
    case 'crearProveedores':
        creacionProveedores();
        break;

}

function creacionArticulos(){

if(isset($_POST["import"])){
    $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0){
        $file = fopen($filename,"r");

        $column = fgetcsv ($file, 10000, ",");

        while(($column = fgetcsv ($file, 10000, ",")) !==FALSE){
            $sqlInsert = "Insert into articulos (nombre,ean,p_coste,p_venta,id_proveedor,stock) values('" . $column[0] . "', '" . $column[1] . "', '" . $column[2]."', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "')";

            $result = mysqli_query(conectarDB(),$sqlInsert);

            if(!empty($result)){
                 
                header("Location: mensaje.php");;
            }else{
                echo "Problemas al subir el fichero";
            }
        }
    }
}
}

function creacionClientes(){

    if(isset($_POST["import"])){
        $filename=$_FILES["file"]["tmp_name"];
    
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename,"r");
    
            $column = fgetcsv ($file, 10000, ",");
    
            while(($column = fgetcsv ($file, 10000, ",")) !==FALSE){
                $sqlInsert = "Insert into clientes (razon_social,email,cif,direccion,codigo_postal,poblacion,provincia,telefono) values('" . $column[0] . "', '" . $column[1] . "', '" . $column[2]."', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "')";
    
                $result = mysqli_query(conectarDB(),$sqlInsert);
    
                if(!empty($result)){
                     
                    header("Location: mensaje2.php");;
                }else{
                    echo "Problemas al subir el fichero";
                }
            }
        }
    }
    }

    function creacionProveedores(){

        if(isset($_POST["import"])){
            $filename=$_FILES["file"]["tmp_name"];
        
            if($_FILES["file"]["size"] > 0){
                $file = fopen($filename,"r");
        
                $column = fgetcsv ($file, 10000, ",");
        
                while(($column = fgetcsv ($file, 10000, ",")) !==FALSE){
                    $sqlInsert = "Insert into proveedores (razon_social,email,cif,direccion,codigo_postal,poblacion,provincia,telefono) values('" . $column[0] . "', '" . $column[1] . "', '" . $column[2]."', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "')";
        
                    $result = mysqli_query(conectarDB(),$sqlInsert);
        
                    if(!empty($result)){
                         
                        header("Location: mensaje3.php");;
                    }else{
                        echo "Problemas al subir el fichero";
                    }
                }
            }
        }
        }

?>