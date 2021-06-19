<?php

function estaAutenticado() : bool {
    
    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;

}

function esAdmin($db) : int {
    $email = $_SESSION['usuario'];
    $query = "SELECT adminSI FROM clientes WHERE email = '${email}'";
    $resultado = mysqli_query($db, $query);
    
    $productos = mysqli_fetch_assoc($resultado);
    $droga = $productos['adminSI'];
    
    if($droga === "SI"){
        
        return 1;
    }
    return 0;
    
}

?>