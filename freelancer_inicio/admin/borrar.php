<?php 
include '../includes/config/database.php';
require '../includes/templates/funciones.php';
date_default_timezone_set('CET');
//Importar conexion
$db = conectarDB();
$fecha = date("Y-m-d"); 
$hora = date("H:i:s");

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;
$auth = estaAutenticado();

if(!$auth){
    header('Location: /login.php');
}

//Escribir query
$query = "DELETE FROM citas WHERE fecha < '${fecha}' AND hora < '${hora}'";
$resultado = mysqli_query($db, $query);
if ($resultado) {
    header('location: /admin?resultado=4');
}
?>
