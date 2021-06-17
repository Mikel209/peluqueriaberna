<?php

include 'includes/config/database.php';
$db = conectarDB();


//autenticar usuario

$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST' ){
    $email = mysqli_real_escape_string($db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ));
    $password = mysqli_real_escape_string($db, $_POST['password']);


    if(!$email){
        $errores[] = "El email es obligatorio o no es valido";
    }
    if(!$password){
        $errores[] = "El password es obligatorio";
    }
    if(empty($errores)){

        $query = "SELECT * FROM clientes WHERE email = '${email}'";
        $resultado = mysqli_query($db, $query);

        if($resultado->num_rows){
            $usuario = mysqli_fetch_assoc($resultado);
            //Verificar password
            $auth =  password_verify($password, $usuario['password']);

            if($auth){
                //usuario verificado
                session_start();

                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true; 

                header('Location: /admin');
            }else{
                $errores[] = "El password es incorrecto";
            }

        }else{
            $errores[] = "El email no existe";
        }

    }

}


include 'includes/templates/login.php'; ?>

<main class="contenedor sombra">

    <?php foreach($errores as $error): ?>
        <div class="alerta alerta-erronea">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>


    <form method="POST" class="formulariologin" novalidate>
        <fieldset>
        <legend>Inicia sesion</legend>
            <br>
            <label for="email">E-mail</label>
            <br>
            <input type="email" name="email" placeholder="Tu e-mail" id="email" required>
            <br>
            <label for="password">Password</label>
            <br>
            <input type="password" name="password" placeholder="Tu password" id="password" required>
            <br>
            <input type="submit" value="Login" class="boton boton-verde">
        </fieldset>
    </form>
</main>

<?php include 'includes/templates/footer.php'; ?>