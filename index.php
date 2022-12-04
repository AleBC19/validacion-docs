<?php
require ('config/db.php');
include('templates/funciones.php');

$db = conectarDB();
$correo = "";
$password = "";
$alertas = [];


if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $correo =  mysqli_real_escape_string( $db, $_POST["correo"]);
    $password =  mysqli_real_escape_string( $db, $_POST["password"]);


    if(!$correo){
        $alertas[] = "El correo es necesario";
    }
    if(!$password){
        $alertas[] = "El password es necesario";
    }

    if( empty($alertas) ) {
        $query = "SELECT * FROM usuarios WHERE correo = '${correo}'";
        $resultado = mysqli_query($db,$query);
        if( $resultado->num_rows ) {
            $usuario = mysqli_fetch_assoc($resultado);
            $auth = password_verify( $password, $usuario['password'] );
           
            if( $auth ) {
                session_start();
                $_SESSION['usuario'] = $usuario['correo'];
                $_SESSION['login'] = true;
                $_SESSION['id'] = $usuario['id_usuario'];
                header('Location: /vistaUsuario.php?id_usuario='.$usuario['id_usuario']);
            } else {
                $alertas[] = "La contraseña es incorrecta";
            }

        } else {
            $alertas[] = "El usuario no existe";
        }
    }
}
?>
<?php include_once('templates/head.php') ?>
<main class="contenedor">

    <div class="login">
        <div>
            <img src="img/login.png" alt="" class="loginIMG">

        </div>
        <div>
            <h1>Inicia Sesión</h1>
            <form action="" method="POST">  
            <?php foreach ($alertas as $alerta) : ?>
                <div class="alerta">
                    <?php echo $alerta; ?>
                </div>
            <?php endforeach; ?>
                <div class="campo">
                    <label class="campo__label" for="correo">Correo:</label>
                    <input 
                        type="correo" 
                        name="correo" 
                        id="correo"
                        class="campo__input">
                </div>
                <div class="campo">
                    <label class="campo__label" for="password">Contraseña:</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="campo__input">
                </div>
                <input 
                    type="submit"
                    value="Iniciar Sesión"
                    class="boton">
                
                 <div class="campo">
                    <a href="crear-cuenta.php">¿No tienes una cuenta? Crea Una</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include_once('templates/footer.php') ?>
