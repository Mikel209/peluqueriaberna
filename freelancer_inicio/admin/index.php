<?php include '../includes/templates/header.php';
include '../includes/config/database.php';
require '../includes/templates/funciones.php';
date_default_timezone_set('CET');
$fechi = date("Y-m-d"); 
$hori = date("H:i:s");

//Importar conexion
$db = conectarDB();

$auth = estaAutenticado();
$esAdmin = esAdmin($db);
echo $esAdmin;
if(!$auth || $esAdmin === 0){
    header('Location: /calendario.php');
}



//Escribir query
$query = "SELECT * FROM productos";
//Consultar DB
$res = mysqli_query($db, $query);

//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

//Boton delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $query = "SELECT imagen FROM productos WHERE id = ${id} ";
        $resultado = mysqli_query($db, $query);
        $producto = mysqli_fetch_assoc($resultado);

        unlink('../imagenes/' . $producto['imagen']);


        $query = "DELETE FROM productos where id = ${id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /admin?resultado=3');
        }
    }
}
?>



<main class="contenedor sombra ">
    <?php if (intval($resultado) === 1) : ?>
        <p class="alerta alerta-exitosa">Producto creado correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
        <p class="alerta alerta-exitosa">Producto actualizado correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
        <p class="alerta alerta-exitosa">Producto eliminado correctamente</p>
    <?php elseif (intval($resultado) === 4) : ?>
        <p class="alerta alerta-exitosa">Limpieza ejecutada correctamente</p>
    <?php endif; ?>
    <h1>Productos</h1>

    <a href="/admin/productos/crear.php" class="boton boton-verde">Nuevo producto</a>
    <br>
    <table class="tablaProductos" description="tabla del administrador">
        <caption>Listado de productos</caption>
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Imagen</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar resultados de la query -->
            <?php while ($productos = mysqli_fetch_assoc($res)) : ?>
                <tr>
                    <td><?php echo $productos['nombre'] ?></td>
                    <td> <img src="../../imagenes/<?php echo $productos['imagen'] ?>" class="tablaProducto__imagen" alt="hola"> </td>
                    <td><?php echo $productos['precio'] ?> €</td>
                    <td><?php echo $productos['descripcion'] ?></td>
                    <td>
                        <a href="/admin/productos/actualizar.php?id=<?php echo $productos['id'] ?>" class="botonActualizar">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $productos['id']; ?>">
                            <input type="submit" class="botonEliminar" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
          
    <h1>Citas</h1>
    <a href="/admin/borrar.php" class="boton boton-verde">Limpiar registros antiguos</a>
    <table class="tablaProductos" description="tabla del administrador">
        <caption>Listado de citas</caption>
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Nombre</th>
                <th scope="col">Servicio</th>
                <th scope="col">Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <!-- Mostrar resultados de la query -->
            <?php 
            $consulta = "SELECT fecha, hora, nombre, apellido_P, apellido_M, servicio, tlfn
            FROM citas INNER JOIN clientes ON citas.clienteID=clientes.id ORDER BY fecha, hora";
            //Consultar DB
            $result = mysqli_query($db, $consulta);
            while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php if($row['fecha'] < $fechi && $row['hora']<$hori){ ?>
                    <tr class="atrasadas">
                <?php } else { ?>
                    <tr>
                <?php } ?>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['hora']; ?></td>
                    <td><?php echo $row['nombre']," ",$row['apellido_P']," ",$row['apellido_M']; ?></td>
                    <td><?php echo $row['servicio']; ?></td>
                    <td><?php echo $row['tlfn']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php

mysqli_close($db);

include '../includes/templates/footer.php';

?>