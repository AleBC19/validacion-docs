<?php
include('config/db.php');
include('templates/funciones.php');
$db = conectarDB();

$usuario = "";
$password = "";

$alertas = [];
$query = "SELECT correo, password, admin FROM usuarios";
$resultado = mysqli_query($db, $query);

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

<main class="contenedor">

</main>

<?php include_once('templates/footer.php') ?>
