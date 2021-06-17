<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $auth = $_SESSION['login'] ?? false;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Berna Díaz</title>
    <link rel="preload" href="../../css/normalize.css" as="style">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="pleload" href="../../css/style.css" as="style">
    <link href="../../css/style.css" rel="stylesheet">
    <!-- Prefetch -->
    <link rel="prefetch" href="calendario.php" as="document">
</head>

<body>
    <header class="encabezado">
        <h1 class="encabezado__nombre">Peluquería/Barbería <span class="encabezado__spam">Berna Díaz</span></h1>
    </header>

    <div class="bg-nav">
        <nav class="navegacion contenedor">
            <a href="index.php">Inicio</a>
            <a href="calendario.php">Calendario</a>
            <a href="fotos.php">Fotos</a>
            <a href="productos.php">Productos</a>
            <a href="contacto.php">Contacto</a>
            <?php if($auth): ?>
                <a href="perfil.php" class="botonperfil" style="background-color: #39a275;">Perfil</a>
                <a href="cerrar-sesion.php" style="background-color: #194a8d;">Cerrar Sesión</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="hero">
        <div class="contenido-hero">
            <div class="ubicacion">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="68"
                    height="68" viewBox="0 0 24 24" stroke-width="2" stroke="#ff2825" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="11" r="3" />
                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                </svg>
                <h2>La Palma del Condado</h2>
            </div>
            <a class="boton" href="calendario.php">Accede al calendario</a>
        </div>
    </div>