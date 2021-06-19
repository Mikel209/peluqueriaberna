<?php
include 'includes/templates/header.php';
include 'includes/templates/funciones.php';
include 'includes/config/database.php';

//Importar conexion
$db = conectarDB();
//Escribir query
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
        $resultado2 = mysqli_query($db, $query);
        
        $auth = estaAutenticado();
        if($resultado2->num_rows){
            $usuario = mysqli_fetch_assoc($resultado2);
            //Verificar password
            $autho =  password_verify($password, $usuario['password']);
            
            if($autho){
                //usuario verificado
                session_start();

                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                if($_SESSION['usuario'] === 'admin@admin.com'){
                    header('Location: /admin/index.php');
                }else{
                    header('Location: /calendario.php');
                }

                
            }else{
                $errores[] = "El password es incorrecto";
            }

        }else{
            $errores[] = "El email no existe";
        }

    }

}

//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

?>

<?php if ($auth) { ?>

    <main class="contenedor sombra ">
        <?php if (intval($resultado) === 1) : ?>
            <p class="alerta alerta-erronea">Dato erroneo, vuelve a probar</p>
        <?php elseif (intval($resultado) === 2) : ?>
            <p class="alerta alerta-exitosa">Reserva exitosa</p>
        <?php endif; ?>

        <form method="get" class="formulario" enctype="multipart/form-data" action="cita.php">
            <fieldset>
                <legend>Elige la fecha</legend>
                <label for="dia">Fecha</label>
                <input type="date" id="dia" name="dia" value="<?php echo date('d-m-Y'); ?>">
            </fieldset>
            <input type="submit" value="Buscar fechas" class="boton boton-verde">
        </form>

    </main>
<?php } else { ?>
    <main class="contenedor sombra">

        <?php foreach ($errores as $error) : ?>
            <div class="alerta alerta-erronea">
                <?php echo $error; ?>
            </div>

        <?php endforeach; ?>


        <form method="POST" class="formulariologin" enctype="multipart/form-data" novalidate>
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
                <a href="registrate.php">Registrate aquí</a>
            </fieldset>
        </form>
        
    </main>


<?php } ?>

<?php include 'includes/templates/footer.php'; ?>