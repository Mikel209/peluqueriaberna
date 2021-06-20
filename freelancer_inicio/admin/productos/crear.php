<?php

include '../../includes/config/database.php';
include '../../includes/templates/header.php';
include '../../includes/templates/funciones.php';

//guardamos nuestra conexion en una variable
$db = conectarDB();

$auth = estaAutenticado();
$esAdmin = esAdmin($db);
echo $esAdmin;
if (!$auth || $esAdmin === 0) {
    header('Location: /calendario.php');
}

date_default_timezone_set('America/Argentina/Buenos_Aires');

// Mensajes de errores
$errores = [];

$nombre = '';
$precio = '';
$descripcion = '';
$imagen = '';

// Evaluamos si viene data por post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $imagen = $_FILES['imagen'];

    //validamos esa informacion de arriba
    if (!$nombre) {
        $errores['nombre'] = 'Debes agregar un nombre';
    }
    if (!$precio) {
        $errores['precio'] = 'Debes agregar un precio';
    }
    if (!$descripcion) {
        $errores['descripcion'] = 'Debes agregar una descripcion';
    }
    if (!$imagen) {
        $errores['imagen'] = 'Debes ingresar una imagen';
    }

    // Si hay errores realizo y ejecuto la instrucción SQL.
    if (empty($errores)) {
        //crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }
        //generar nombre unico
        $nombreImagen = date('d-m-Y_H-i-s') . '.jpg';
        //subir imagen
        move_uploaded_file($imagen['tmp_name'], "{$carpetaImagenes}{$nombreImagen}");

        //insertar en la bbdd
        $query = " INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$nombreImagen') ";

        //echo query

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('Location: /admin/index.php?resultado=1');
        }
    }
}
?>
<main class="contenedor sombra ">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta alerta-erronea">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="post" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="nombre" value="<?php echo $nombre; ?>">

            <br><br>

            <label for="precio">Precio</label>
            <input type="decimal" id="precio" name="precio" placeholder="precio" value="<?php echo $precio; ?>">


            <br><br>

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion">
        <?php echo $descripcion; ?>
                </textarea>

            <br><br>

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, imager/png">

        </fieldset>
        <input type="submit" value="Crear producto" class="boton boton-verde">
    </form>
</main>
<?php include '../../includes/templates/footer.php'; ?>