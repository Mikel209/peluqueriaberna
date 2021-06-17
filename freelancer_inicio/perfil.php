<?php

require 'includes/templates/funciones.php';
include 'includes/config/database.php';
$db = conectarDB();


if (!isset($_SESSION)) {
    session_start();
}
$auth = $_SESSION['login'] ?? false;
$auth = estaAutenticado();

//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "DELETE FROM citas where id = ${id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /perfil.php?resultado=1');
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
        <?php 
        $email = $_SESSION['usuario'];
        $query = "SELECT * FROM clientes WHERE email = '${email}';";
        $res = $db->query($query);
        while ($row = $res->fetch_assoc()) {
        ?>
        <header>
            <img src="img/avatar.jpg" alt="fotoperfilusuario">
            <h1><?php echo $row['nombre']," ",$row['apellido_P']," ",$row['apellido_M']; ?></h1>
            <a class="boton" href="perfileditar.php?id=<?php echo $row['id']; ?>">Editar perfil</a>
        </header>
        <div class="informacion">
            <h2>Información personal</h2>
            <div class="informacion__dato">
                <h3>Telefono: <span><?php echo $row['tlfn']; ?></span></h3>
                <h3>Fecha de nacimiento: <span><?php echo $row['fecha_nac']; ?></span></h3>
                <h3>E-mail: <span><?php echo $row['email']; ?></span></h3>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="citas">
            <table class="tablaCitaDisponible" description="tabladecitas">
                <caption><h2>Proximas citas</h2></caption>
                <?php if (intval($resultado) === 1) : ?>
                    <p class="alerta alerta-exitosa">Cita anulada correctamente</p>
                <?php elseif (intval($resultado) === 2) : ?>
                    <p class="alerta alerta-exitosa">Perfil actualizado correctamente</p>
                <?php endif; ?>
                <thead>
                    <tr>
                        <th scope="col">Servicio</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $email = $_SESSION['usuario'];
                $query = "SELECT * FROM citas WHERE clienteID = ( 
                    SELECT id FROM clientes 
                    WHERE email = '${email}');";
                $res = $db->query($query);
                while ($row = $res->fetch_assoc()) {
                ?>

                    <tr>
                        <td><?php echo $row['servicio']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" class="botonEliminar" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>