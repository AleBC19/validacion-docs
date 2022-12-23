<?php
session_start();
include('config/db.php');
include('templates/funciones.php');
$db = conectarDB();

$id_usuario = $_GET["id_usuario"];
$queryIsAdmin = "SELECT admin from usuarios";
$resultadoIsAdmin = mysqli_query($db, $queryIsAdmin);

//debuguear($resultadoIsAdmin);

$correo = "";
$password = "";

$alertas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = mysqli_real_escape_string($db, strtoupper($_POST["documento"]));
    $primeraValidacion = "NO";
    $segundaValidacion = "NO";
    $validado = "NO";
    $estatus = "NO VALIDADO";
    $folio = random_int(1000, 100000);
    if (!$documento) {
        $alertas[] = "Es necesario que ingrese el nombre del documento";
    }

    if (empty($alertas)) {
        $query = "INSERT INTO registros(folio, documento, primeraValidacion, segundaValidacion, validado, estatus, id_usuario)";
        $query .= "VALUES ('$folio','$documento','$primeraValidacion','$segundaValidacion','$validado','$estatus', '$id_usuario')";
        $resultado = mysqli_query($db, $query);
        if( $resultado ) {
            header('Location: /validacion-docs2/vistaUsuario.php?id_usuario='.$id_usuario);
        }
    }
}

$query = "SELECT * FROM registros WHERE id_usuario = '${id_usuario}'";
$result = mysqli_query($db, $query);
?>
<?php include_once('templates/head.php') ?>

<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="/css/normalize.css">

<main class="contenedor">
    <?php foreach ($alertas as $alerta) : ?>
        <div class="alerta">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>

    <form action="" method="POST">
        <label class="campo__label" for="documento">Documento:</label>
        <input 
            type="text" 
            name="documento" 
            id="documento" 
            placeholder="Ingrese el documento" 
            class="campo__input"/>
        <input class="boton" type="submit" value="Registrar">
    </form>

    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Documento</th>
                <th>Primera Validacion</th>
                <th>Segunda Validacion</th>
                <th>Validado</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($registros = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><?php echo $registros['folio']; ?></td>
                    <td><?php echo $registros['documento']; ?></td>
                    <td><?php echo $registros['primeraValidacion']; ?></td>
                    <td><?php echo $registros['segundaValidacion']; ?></td>
                    <td><?php echo $registros['validado']; ?></td>
                    <td><?php echo $registros['estatus']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include_once('./templates/footer.php')?>