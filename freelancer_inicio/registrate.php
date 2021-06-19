<?php
include 'includes/templates/header.php';
include 'includes/config/database.php';

//Importar conexion
$db = conectarDB();

$errores = [];

$email = '';
$nombre = '';
$apellido_p = '';
$apellido_m = '';
$tlfn = '';
$fecha_nac = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $password2 = ($_POST['password2']);
    $nombre = ($_POST['nombre']);
    $apellido_p = ($_POST['apellido_p']);
    $apellido_m = ($_POST['apellido_m']);
    $tlfn = ($_POST['tlfn']);
    $fecha_nac = ($_POST['fecha_nac']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es valido";
    }
    $query = "SELECT * FROM clientes WHERE email = '${email}'";
    $resultado2 = mysqli_query($db, $query);
    if ($resultado2->num_rows) {
        $errores[] = "El email está en uso";
    }
    if (!$password || !$password2) {
        $errores[] = "El password es obligatorio";
    }
    $longitud = strlen($password);
    $size = 8;
    if ($password != $password2) {
        $errores[] = "Las contraseñas no coinciden";
    } else if ( $longitud <= $size ) {
        $errores[] = "La longitud de la contraseña debe ser mayor a 8";
    }
    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }
    if (!$apellido_p) {
        $errores[] = "El primer apellido es obligatorio";
    }
    if (!$apellido_m) {
        $errores[] = "El segundo apellido es obligatorio";
    }
    if (!$tlfn) {
        $errores[] = "El telefono es obligatorio";
    } else if (strlen($tlfn) != 9) {
        $errores[] = "El número de telefono no tiene nueve números";
    }
    if (!$fecha_nac) {
        $errores[] = "La fecha de nacimiento es obligatorio";
    } else if ($fecha_nac > "2015-1-1" || $fecha_nac < "1950-1-1") {
        $errores[] = "La fecha de nacimiento no tiene valores lógicos";
    }

    $nombre = ucfirst($nombre);
    $apellido_p = ucfirst($apellido_p);
    $apellido_m = ucfirst($apellido_m);
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    if (empty($errores)) {
        //insertar en la bbdd
        $query = " INSERT INTO clientes (nombre, apellido_P, apellido_M, tlfn, fecha_nac, email, password) 
        VALUES ('${nombre}', '${apellido_p}', '${apellido_m}', '${tlfn}','${fecha_nac}', '${email}', '${passwordHash}')";
        //echo query
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /calendario.php');
        }
    }
}

?>
<main class="contenedor sombra">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta alerta-erronea">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>
    <form method="POST" class="formulariologin" enctype="multipart/form-data">
        <fieldset>
            <legend>Regristrate</legend>
            <br>
            <label for="email">E-mail</label>
            <br>
            <input type="email" name="email" placeholder="Tu e-mail" id="email" value="<?php echo $email; ?>" required>
            <br>
            <label for="password">Password</label>
            <br>
            <input type="password" name="password" placeholder="Tu password" id="password" required>
            <br>
            <label for="password2">Repeat Password</label>
            <br>
            <input type="password" name="password2" placeholder="Repite password" id="password2" required>
            <br>
            <label for="nombre">Nombre</label>
            <br>
            <input type="text" name="nombre" placeholder="Tu nombre" id="nombre" value="<?php echo $nombre; ?>" required>
            <br>
            <label for="apellido_p">Apellido 1</label>
            <br>
            <input type="text" name="apellido_p" placeholder="Tu primer apellido" id="apellido_p" value="<?php echo $apellido_p; ?>" required>
            <br>
            <label for="apellido_m">Apellido 2</label>
            <br>
            <input type="text" name="apellido_m" placeholder="Tu segundo apellido" id="apellido_m" value="<?php echo $apellido_m; ?>" required>
            <br>
            <label for="tlfn">Teléfono</label>
            <br>
            <input type="number" name="tlfn" placeholder="Tu telefono" id="tlfn" minlength="9" maxlength="9" value="<?php echo $tlfn; ?>" required>
            <br>
            <label for="fecha_nac">Fecha de nacimiento</label>
            <br>
            <input type="date" name="fecha_nac" placeholder="Tu fecha de nacimiento" id="fecha_nac" value="<?php echo $fecha_nac; ?>" required>
            <br>
            <input type="submit" value="Registrate" class="boton boton-verde">
            <a href="calendario.php">Vuelve al login</a>
        </fieldset>
    </form>
</main>
<?php include 'includes/templates/footer.php'; ?>