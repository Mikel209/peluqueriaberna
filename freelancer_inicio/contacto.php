<?php include 'includes/templates/header.php'; 
include 'sendEmail.php';
?>

    <main class="contenedor sombra">
        <h1 class="letracontacta">Contacta con nosotros</h1>
        <h2>Queremos escucharte</h2>
        <div class="contacta">
            <div class="contacta__informacion">
                <p>Si quieres información sobre cualquiera de nuestros productos y/o servicios o estás interesado en la
                    creación de la página, rellena nuestro formulario y nos pondremos en contacto contigo lo antes posible.
                </p>
                <p>
                    Muchas gracias
                </p>
                <p>
                    <span class="letranegrita">Nos ubicamos en:</span> C/ Mantua, La Palma del Condado, Huelva
                </p>
                <p>
                    <span class="letranegrita">Creador:</span> miguelperfer98@gmail.com
                </p>
            </div>
            <?php echo $alert; ?>
            <div class="contacta__formulario">
                <form method="POST" action="" class="formulario">
                    <div class="campo">
                        <label class="campo__label" for="nombre">Nombre</label>
                        <input class="campo__field" type="text" placeholder="Tu nombre" name="nombre" id="nombre">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="email">E-mail</label>
                        <input class="campo__field" type="text" placeholder="Tu e-mail" name="email" id="email">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="mensaje">Mensaje</label>
                        <textarea class="campo__field campo__field--textarea" id="mensaje" name="mensaje"></textarea>
                    </div>
                    <div class="campo">
                        <input type="submit" name="submit" value="Enviar" class="boton campo__centrar">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script type="text/javascript">
    if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href);
    }
        
    </script>

<?php include 'includes/templates/footer.php'; ?>