<?php

require 'includes/templates/funciones.php';
include 'includes/config/database.php';
$db = conectarDB();


if (!isset($_SESSION)) {
    session_start();
}
$auth = $_SESSION['login'] ?? false;
$auth = estaAutenticado();

//VALIDAR Q SEA ID
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);


$query = "SELECT * FROM clientes WHERE id = ${id} AND email = '${_SESSION['usuario']}'";
$resultado = mysqli_query($db, $query);
$patata = $resultado->num_rows;
if (!$id || !$auth || !$patata) {
    header('Location: /index.php');
}
//obtener los datos
$consulta = "SELECT * FROM clientes WHERE id = ${id}";
$resul = mysqli_query($db, $consulta);
$row = mysqli_fetch_assoc($resul);


// Mensajes de errores
$errores = [];

$nombre = $row['nombre'];
$apellido_P = $row['apellido_P'];
$apellido_M = $row['apellido_M'];
$tlfn = $row['tlfn'];
$fecha_nac = $row['fecha_nac'];
$email = $row['email'];

// Evaluamos si viene data por post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$_REQUEST['actualizacontra']) {
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido_P = mysqli_real_escape_string($db, $_POST['apellido_P']);
    $apellido_M = mysqli_real_escape_string($db, $_POST['apellido_M']);
    $tlfn = mysqli_real_escape_string($db, $_POST['tlfn']);
    $fecha_nac = mysqli_real_escape_string($db, $_POST['fecha_nac']);
    $email = mysqli_real_escape_string($db, $_POST['email']);

    //validamos esa informacion de arriba
    if (!$nombre) {
        $errores['nombre'] = 'Debes agregar un nombre';
    }
    if (!$apellido_P) {
        $errores['apellido_P'] = 'Debes agregar el primer apellido';
    }
    if (!$apellido_M) {
        $errores['apellido_M'] = 'Debes agregar el segundo apellido';
    }
    if (!$tlfn) {
        $errores['tlfn'] = 'Debes agregar un teléfono';
    }
    if (!$fecha_nac) {
        $errores['fecha_nac'] = 'Debes agregar una fecha de nacimiento';
    } elseif ($fecha_nac > "2015-1-1" || $fecha_nac < "1950-1-1") {
        $errores[] = "La fecha de nacimiento no tiene valores lógicos";
    }
    if (!$email) {
        $errores['email'] = 'Debes agregar un email';
    }

    if (empty($errores)) {

        //insertar en la bbdd

        $query = "UPDATE clientes SET nombre = '${nombre}', apellido_P = '${apellido_P}', 
        apellido_M = '${apellido_M}', tlfn = '${tlfn}', fecha_nac = '${fecha_nac}', 
        email = '${email}' WHERE id = ${id}";
        //echo query

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /perfil.php?resultado=2');
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['actualizacontra']) {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    if (!$pass1 || !$pass2 || !$pass3) {
        $errores[] = "El password es obligatorio";
    }

    $query = "SELECT * FROM clientes WHERE id = $id";
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
    if (empty($errores)) {
        
        $passwordHash = password_hash($pass2, PASSWORD_BCRYPT);
        $query = "UPDATE clientes SET password = '${passwordHash}' WHERE id = ${id}";
        //echo query

        $resultado3 = mysqli_query($db, $query);

        if ($resultado3) {
            header('Location: /perfil.php?resultado=3');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Peluquería Berna Díaz</title>
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet"><!-- texto -->
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet"><!-- titulo -->
    <link rel="pleload" href="css/styleperfil.css" as="style">
    <link href="css/styleperfil.css" rel="stylesheet">
</head>

<body>
    <main class="contenedor">
        <nav class="navegacion">
            <a href="calendario.php">Calendario</a>
            <a href="productos.php">Productos</a>
            <a href="cerrar-sesion.php">Cerrar sesión</a>
        </nav>
        <form method="POST" class="formulariologin" enctype="multipart/form-data">
            <fieldset>
                <legend>Actualiza tus datos</legend>
                <br>
                <label for="email">E-mail</label>
                <br>
                <input type="email" name="email" placeholder="Tu e-mail" id="email" value="<?php echo $email; ?>" required>
                <br>
                <label for="nombre">Nombre</label>
                <br>
                <input type="text" name="nombre" placeholder="Tu nombre" id="nombre" value="<?php echo $nombre; ?>" required>
                <br>
                <label for="apellido_p">Apellido 1</label>
                <br>
                <input type="text" name="apellido_P" placeholder="Tu primer apellido" id="apellido_p" value="<?php echo $apellido_P; ?>" required>
                <br>
                <label for="apellido_m">Apellido 2</label>
                <br>
                <input type="text" name="apellido_M" placeholder="Tu segundo apellido" id="apellido_m" value="<?php echo $apellido_M; ?>" required>
                <br>
                <label for="tlfn">Teléfono</label>
                <br>
                <input type="number" name="tlfn" placeholder="Tu telefono" id="tlfn" value="<?php echo $tlfn; ?>" required>
                <br>
                <label for="fecha_nac">Fecha de nacimiento</label>
                <br>
                <input type="date" name="fecha_nac" placeholder="Tu fecha de nacimiento" id="fecha_nac" value="<?php echo $fecha_nac; ?>" required>
                <br>
                <br>
                <input type="submit" value="Actualizar" class="boton boton-verde">
                <a href="perfil.php">Vuelve a tu perfil</a>
            </fieldset>
        </form>

        <?php foreach ($errores as $error) : ?>
            <div class="alerta alerta-erronea">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form method="POST" class="formulariologin" enctype="multipart/form-data">
            <fieldset>
                <legend>Actualiza tu contraseña</legend>
                <br>
                <label for="password1">Contraseña antigua</label>
                <br>
                <input type="password" name="pass1" placeholder="Tu password" id="password1" required>
                <br>
                <label for="password2">Contraseña nueva</label>
                <br>
                <input type="password" name="pass2" placeholder="Tu password" id="password2" required>
                <br>
                <label for="password3">Repite contraseña nueva</label>
                <br>
                <input type="password" name="pass3" placeholder="Tu password" id="password3" required>
                <br>
                <br>
                <input type="submit" name="actualizacontra" value="Actualiza contraseña" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
</body>