<?php
require './config/db.php';
require './templates/funciones.php';
$db = conectarDB();

$isAdmin = $_GET['admin'];
if( $isAdmin !=="1" ) {
   header('Location: /admin.php');
}


?>

<?php include_once('./templates/head.php') ?>
<main class="contenedor">

</main>

<?php include_once('./templates/footer.php') ?>