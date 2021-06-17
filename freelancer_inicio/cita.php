<?php include 'includes/templates/header.php';
require 'includes/templates/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('Location: /index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dia = $_GET['dia'];

    if (!$dia || $dia < date("Y-m-d")) {
        header('Location: /calendario.php?resultado=1');
    }
}

include 'includes/config/database.php';
$db = conectarDB();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dia = ($_GET['dia']);
    $hora = ($_POST['hora']);
    $servicio = ($_POST['servicio']);

    if (!$hora) {
        $errores[] = "La hora es obligatorio";
    }
    if (!$servicio) {
        $errores[] = "El servicio es obligatorio";
    }


    $email = $_SESSION['usuario'];
    $query = "SELECT id FROM clientes WHERE email = '${email}'";
    $resultado = mysqli_query($db, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    $idusuario = $usuario['id'];

    if ($dia && $hora && $servicio && empty($errores)) {
        $query = "INSERT INTO citas (servicio, fecha, hora, clienteID) VALUES ('${servicio}', '${dia}', '${hora}', '${idusuario}');";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /calendario.php?resultado=2');
        }
    }
}

$objeto_DateTime = date_create_from_format('Y-m-d', $dia);
$cadena_nuevo_formato = date_format($objeto_DateTime, "d/m");

?>
<main class="contenedor sombra ">
    <h1>Elige la hora del día <?php echo $cadena_nuevo_formato ?></h1>
    
    <?php foreach ($errores as $error) : ?>
        <div class="alerta alerta-erronea">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <table class="tablaCitaDisponible" description="tabladecitas">
        <caption>Listado de citas</caption>
        <thead>
            <tr>
                <th scope="col">10:00</th>
                <th scope="col">10:30</th>
                <th scope="col">11:00</th>
                <th scope="col">11:30</th>
                <th scope="col">12:00</th>
                <th scope="col">12:30</th>
                <th scope="col">17:00</th>
                <th scope="col">17:30</th>
                <th scope="col">18:00</th>
                <th scope="col">18:30</th>
                <th scope="col">19:00</th>
                <th scope="col">19:30</th>
                <th scope="col">20:00</th>
                <th scope="col">20:30</th>
            </tr>
        </thead>
        <tbody>
            <form method="post" class="formulario" enctype="multipart/form-data">
                <tr>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '10:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="10:00" value="10:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '10:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="10:30" value="10:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '11:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?>
                            <div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="11:00" value="11:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '11:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="11:30" value="11:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '12:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="12:00" value="12:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '12:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="12:30" value="12:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '17:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="17:00" value="17:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '17:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="17:30" value="17:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '18:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="18:00" value="18:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '18:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="18:30" value="18:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '19:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="19:00" value="19:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '19:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="19:30" value="19:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '20:00'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="20:00" value="20:00">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                    <td>
                        <?php $consulta = "SELECT hora FROM citas WHERE fecha = '${dia}' and hora = '20:30'";
                        $resul = mysqli_query($db, $consulta);
                        $productos = mysqli_fetch_all($resul);

                        if (!$productos) {
                        ?><div class="cuadro cuadroverde">
                                <input type="radio" name="hora" id="20:30" value="20:30">
                            </div><?php
                                } else {
                                    ?><div class="cuadro cuadrorojo"></div>
                        <?php
                                } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Elige el tipo de servicio</td>
                    <td colspan="3">
                        <input type="radio" id="corte_caballero" name="servicio" value="corte_caballero">
                        <label for="corte_caballero">Corte caballero</label><br>
                    </td>
                    <td colspan="2">
                        <input type="radio" id="degradado" name="servicio" value="degradado">
                        <label for="degradado">Degradado</label><br>
                    </td>
                    <td colspan="2">
                        <input type="radio" id="barba" name="servicio" value="barba">
                        <label for="barba">Barba</label>
                    </td>
                    <td colspan="2">
                    </td>
                    <td colspan="2">
                        <input type="submit" value="Reservar" class="boton boton-verde sinbordes">
                    </td>
                </tr>
            </form>
        </tbody>
    </table>
    <br><br>
    <a href="calendario.php" class="boton boton-verde">Volver</a>
</main>

<?php include 'includes/templates/footer.php'; ?>