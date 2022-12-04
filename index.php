<?php
include('config/db.php');
$db = conectarDB();

$usuario = "";
$password = "";

$alertas = [];
$query = "SELECT usuario, password, tipo_usuario FROM usuarios";
$resultado = mysqli_query($db, $query);

//echo "<pre>";
//var_dump($resultado);
//echo "</pre>";
//exit;

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $usuario =  mysqli_real_escape_string( $db, $_POST["usuario"]);
    $password =  mysqli_real_escape_string( $db, $_POST["password"]);

    if(!$usuario){
        $alertas[] = "El nombre de usuario es necesario";
    }
    if(!$password){
        $alertas[] = "El password es necesario";
    }
    
}

?>
<?php include_once('templates/head.php') ?>

<?php foreach($alertas as $alerta): ?>
    <div class="error">
        <?php echo $alerta; ?>
    </div>
<?php endforeach; ?>

<main class="contenedor">
        <div class="login">
            <div class="">
                <img class="loginIMG" src="img/login.png" alt="">
            </div>

            <div class="">
                <form action="" method="POST">
                    <div class="camposLogin">
                        <label class="labelSesion"for="">
                            INICIA SESIÓN
                        </label>
                        <div class="camposLogin">
                            <label class="label__campos" for="user">Nombre Usuario</label>
                            <input 
                                type="text" 
                                name="usuario" 
                                id="user">
                        </div>
                        <div class="camposLogin">
                            <label class="label__campos" for="password">Contraseña del Usuario</label>
                            <input 
                            type="password" 
                            name="password"  
                            id="password">
                        </div>
                        <input type="submit" value="Iniciar Sesión">
                    </div>
                </form>
            </div>
        </div>
</main>

<?php include_once('templates/footer.php') ?>
