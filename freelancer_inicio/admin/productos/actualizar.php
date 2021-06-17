<?php
include '../../includes/config/database.php';
include '../../includes/templates/header.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
include '../../includes/templates/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('Location: /login.php');
}


//VALIDAR Q SEA ID
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin/index.php');
}


//guardamos nuestra conexion en una variable
$db = conectarDB();

//obtener los datos
$consulta = "SELECT * FROM productos WHERE id = ${id}";
$resul = mysqli_query($db, $consulta);
$productos = mysqli_fetch_assoc($resul);


// Mensajes de errores
$errores = [];

$nombre = $productos['nombre'];
$precio = $productos['precio'];
$descripcion = $productos['descripcion'];
$imagen = $productos['imagen'];

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
        $errores['imagen'] = 'Debes agregar una imagen';
    }


    // Si no hay errores realizo y ejecuto la instrucción SQL.
    if (empty($errores)) {

        //crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }



        if (!$imagen) {
            //eliminar la imagen previa
            unlink($carpetaImagenes . $productos['imagen']);
            //generar nombre unico
            $nombreImagen = date('d-m-Y_H-i-s') . '.jpg';
            //subir imagen
            move_uploaded_file($imagen['tmp_name'], "{$carpetaImagenes}{$nombreImagen}");
        } else {
            $nombreImagen = $productos['imagen'];
        }

        //insertar en la bbdd
        $query = "UPDATE productos SET nombre = '${nombre}', precio = ${precio}, descripcion = '${descripcion}', imagen = '${nombreImagen}' WHERE id = ${id}";

        //echo query

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
}
?>
<main class="contenedor sombra ">
    <?php foreach ($errores as $error) : ?>
        <div class="alerta alerta-erronea">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <h1>Actualizar producto</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <form method="post" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="nombre" value="<?php echo $nombre; ?>">
            </div>

            <div class="campo">
                <label for="precio">Precio</label>
                <input type="decimal" id="precio" name="precio" placeholder="precio" value="<?php echo $precio; ?>">
            </div>

            <div class="campo">
                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </div>

            <div class="campo">
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, imager/png">
            </div>
            <img src="/imagenes/<?php echo $imagen; ?>" class="imgformat" alt="asdasd">
        </fieldset>
        <input type="submit" value="Actualizar producto" class="boton boton-verde">
    </form>
</main>
<?php include '../../includes/templates/footer.php'; ?>