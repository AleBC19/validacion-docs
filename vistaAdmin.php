<?php
require './config/db.php';
require './templates/funciones.php';
$db = conectarDB();

$isAdmin = $_GET['admin'];
if ($isAdmin !== "1") {
    header('Location: /admin.php');
}

$querySelectUsers = "SELECT * FROM registros";
$resultadoSelect = mysqli_query($db, $querySelectUsers);

$folio = "";
$alertas = [];
$resultadoMensaje = $_GET["mensaje"] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folio = $_POST['folio'];

    if (!$folio) {
        $alertas[] = "Ingrese el número de folio a buscar";
    }

    if (empty($alertas)) {
        $validarFolio = "SELECT folio from registros WHERE folio = '${folio}'";
        $validarFolioResult = mysqli_query($db, $validarFolio);
        if ( $validarFolioResult->num_rows === 0) {
            $alertas[] = "No. de Folio incorrecto o no existe";
            
        } else {
            $queryBuscar = "SELECT * FROM registros WHERE folio = '${folio}'";
            $resultadoBuscarDoc = mysqli_query($db, $queryBuscar);
            if( $resultadoBuscarDoc->num_rows > 0 ) {
                $resultadoSelect = $resultadoBuscarDoc;
            }
        }

    }
}
?>
<?php include_once('./templates/head.php') ?>
<main class="contenedor">
    <?php foreach ($alertas as $alerta) : ?>
        <div class="alerta">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST">
        <label class="campo__label" for="folio">No. de Folio</label>
        <input 
            type="number" 
            name="folio" 
            placeholder="Ingrese el No. de Folio del documento" 
            class="campo__input">
        <input type="submit" value="Buscar">
    </form>

    <?php  if (intval($resultadoMensaje) === 2) :  ?>
        <div class="alerta">
            <p>Se realizo una revisión correctamente</p>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Documento</th>
                <th>Primera Validacion</th>
                <th>Segunda Validacion</th>
                <th>Validado</th>
                <th>Estatus</th>
                <th>No. Usuario</th>
                <th>Validar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($registros = mysqli_fetch_array($resultadoSelect)) : ?>
                <tr>
                    <td><?php echo $registros['folio']; ?></td>
                    <td><?php echo $registros['documento']; ?></td>
                    <td><?php echo $registros['primeraValidacion']; ?></td>
                    <td><?php echo $registros['segundaValidacion']; ?></td>
                    <td><?php echo $registros['validado']; ?></td>
                    <td><?php echo $registros['estatus']; ?></td>
                    <td><?php echo $registros['id_usuario']; ?></td>
                    <td>
                        <a href="revisar-documento.php?folio=<?php echo $registros['folio'];?>">Revisar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php include_once('./templates/footer.php') ?>