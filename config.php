<?php  

const DB_HOST="localhost";
const DB_USER="root";
const DB_NAME="exio2";
const DB_PASS="";

function conectarDB(){
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

 mysqli_set_charset($conn,"utf8");

 return $conn;
 
 mysqli_close($conn);

 }

?>