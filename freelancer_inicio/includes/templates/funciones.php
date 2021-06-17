<?php

function estaAutenticado() : bool {

    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;

}