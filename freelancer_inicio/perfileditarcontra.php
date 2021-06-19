<?php

require 'includes/templates/funciones.php';
include 'includes/config/database.php';
$db = conectarDB();


if (!isset($_SESSION)) {
    session_start();
}
$auth = $_SESSION['login'] ?? false;
$auth = estaAutenticado();
if ($auth) {
    echo "hola";
} else {
    echo "adios";
}
if (!$auth) {
    header('Location: /index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    /*
    if (!$pass1 || !$pass2 || !$pass3) {
        $errores[] = "El password es obligatorio";
    }

    $query = "SELECT * FROM clientes WHERE id = ${id}";
    $resultado2 = mysqli_query($db, $query);
    if ($resultado2->num_rows) {
        $usuario = mysqli_fetch_assoc($resultado2);
        //Verificar password
        $autho =  password_verify($pass1, $usuario['password']);

        if (!$autho) {
            $errores[] = "El password no coincide";
        }
    }
    $longitud = strlen($pass2);
    $size = 8;
    if ($pass2 != $pass3) {
        $errores[] = "Las contraseñas no coinciden";
    } else if ($longitud <= $size) {
        $errores[] = "La longitud de la contraseña debe ser mayor a 8";
    }
    if (empty($errores)) {*/

    $query = "UPDATE clientes SET password = '${pass1}' WHERE id = ${id}";
    //echo query

    $resultado3 = mysqli_query($db, $query);

    if ($resultado3) {
        header('Location: /perfil.php?resultado=3');
    }
}
