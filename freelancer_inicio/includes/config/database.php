<?php

function conectarDB()
{
    $server = "localhost";
    $uid = "root";
    $pwd = "root";
    $bd = "apppeluqueria";
    $db = mysqli_connect($server, $uid, $pwd, $bd);

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $db;
}
