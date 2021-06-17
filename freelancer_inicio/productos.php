<?php include 'includes/templates/header.php'; ?>

<main class="contenedor sombra">
    <h1 class="letracontacta">Nuestros productos</h1>
    <?php
    include 'includes/config/database.php';
    $db = conectarDB();
    $query = "SELECT * FROM productos";
    $res = $db->query($query);
    while ($row = $res->fetch_assoc()) {
    ?>
        <div class="productos">
            <div class="productos__imagen">
                <img alt="hola" src="imagenes/<?php echo $row['imagen'];  ?>">
            </div>
            <div class="productos__informacion">
                <ul>
                    <li>
                        <h4><?php echo $row['nombre']; ?></h4>
                    </li>
                    <li>
                        <p><?php echo $row['precio']; ?>€</p>
                    </li>
                    <li>
                        <p><?php echo $row['descripcion']; ?></p>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }
    ?>
</main>

<?php include 'includes/templates/footer.php'; ?>