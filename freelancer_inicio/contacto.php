<?php include 'includes/templates/header.php'; ?>

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
            <div class="contacta__formulario">
                <h4 class="sent-notification"></h4>
                <form id="myForm" class="formulario">
                    <div class="campo">
                        <label class="campo__label" for="nombre">Nombre</label>
                        <input class="campo__field" type="text" placeholder="Tu nombre" id="nombre">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="email">E-mail</label>
                        <input class="campo__field" type="text" placeholder="Tu e-mail" id="email">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="subject">Asunto</label>
                        <input class="campo__field" type="text" placeholder="Asunto" id="subject">
                    </div>
                    <div class="campo">
                        <label class="campo__label" for="mensaje">Mensaje</label>
                        <textarea class="campo__field campo__field--textarea" id="mensaje"></textarea>
                    </div>
                    <div class="campo">
                        <button type="button" onclick="sendEmail()" value="Enviar" class="boton campo__centrar">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="hhtps://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        function sendEmail(){
            var nombre = $("#nombre");
            var email = $("#email");
            var subject = $("#subject");
            var mensaje = $("#mensaje");

            if(isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(subject) && isNotEmpty(mensaje)){
                $.ajax({
                    url: 'sendEmail.php',
                    method: 'POST',
                    dataType:'json',
                    data:{
                        name: name.val(),
                        email: email.val(),
                        subject: subject.val(),
                        mensaje: mensaje.val(),
                    }, success: function(response){
                        $('#myForm')[0].reset();
                        $('.sent-notification').text("Message sent successfully");
                    }

                });
            }
        }
        function isNotEmpty(caller){
            if(caller.val()==""){
                caller.css('border','1px solid red');
                return false;
            }else{
                caller.css('border','');
                return false;
            }
        }
    </script>

<?php include 'includes/templates/footer.php'; ?>