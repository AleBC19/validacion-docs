<?php 
include('config/db.php');
include('templates/funciones.php');
$db = conectarDB();

$folio = $_GET["folio"];
if( !$folio ) {
    header('Location: /admin.php');
}

$alertas = [];

$query = "SELECT * FROM registros WHERE folio = '${folio}'";
$result = mysqli_query($db, $query);  
$usuario = mysqli_fetch_assoc($result);

$folio = $usuario['folio'];
$documento = $usuario['documento'];
$primeraValidacion = $usuario['primeraValidacion'];
$segundaValidacion = $usuario['segundaValidacion'];
$validado = $usuario['validado'];
$estatus = $usuario['estatus'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $primeraValidacion = mysqli_real_escape_string($db, strtoupper($_POST["primeraValidacion"]));
    $segundaValidacion = mysqli_real_escape_string($db, strtoupper($_POST["segundaValidacion"]));

    if(!$primeraValidacion){
        $alertas[] = "Es necesario que indique la primera revision del documento";
    }
    if(!$primeraValidacion){
        $alertas[] = "Es necesario que indique la segunda revision del documento";
    }

    if(empty($alertas)){
        $query = "UPDATE registros SET primeraValidacion = '$primeraValidacion', segundaValidacion = '$segundaValidacion' ";
        $query .= "WHERE folio = '${folio}'";
        $resultado = mysqli_query( $db, $query);

        $queryUpdateRevisiones = "SELECT primeraValidacion, segundaValidacion from registros ";
        $queryUpdateRevisiones .= "WHERE folio = '${folio}'";
        $result = mysqli_query($db, $queryUpdateRevisiones);
        $validate = mysqli_fetch_array($result);
        if( $validate["primeraValidacion"] == "SI" && $validate["segundaValidacion"] == "SI") {
            $actualizarRevision = "UPDATE registros SET validado = 'SI', estatus = 'VALIDADO' "; 
            $actualizarRevision .= "WHERE folio = '${folio}'";
            $resultadoUpdateRevision = mysqli_query($db, $actualizarRevision);
        }

        if( $resultado ) {
            header('Location: /vistaAdmin.php?admin=1&mensaje=2');
        }
    }
}  
?>
<?php include_once('templates/head.php') ?>
<main>
    <?php foreach ($alertas as $alerta) : ?>
        <div class="error">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST">
        <div class="campo">
            <label class="campo__label">ID Usuario:</label>
            <input 
                type="text" 
                name="id_usuario" 
                value = "<?php echo $usuario['id_usuario'];?>"
                disabled/>
        </div>

        <div class="campo">
            <label class="campo__label">Documento: </label>
            <input 
                type="text"
                name="documento"
                id="documento"
                value = "<?php echo $documento;?>"
                disabled/>
        </div>

        <div class="campo">
            <label class="campo__label">Folio del documento:</label>
            <input 
                type="text"
                name="folio"
                id="folio"
                placeholder="Ingrese el folio del documento"
                value = "<?php echo $folio;?>"
                disabled/>
        </div>

        <div class="campo">
            <label class="campo__label">primera Validacion:</label>
            <input 
                type="text"
                name="primeraValidacion"
                id="primeraValidacion"
                value = "<?php echo $primeraValidacion;?>"/>
        </div>

        <div class="campo">
            <label class="campo__label">segunda Validacion:</label>
            <input 
                type="text"
                name="segundaValidacion"
                id="segundaValidacion"
                value = "<?php echo $segundaValidacion;?>"/>
        </div>

        <div class="campo">            
            <label class="campo__label">Validacion:</label>
            <input 
                type="text"
                name="validado"
                id="validado"
                value = "<?php echo $validado;?>"
                disabled/>
        </div>

        <div class="campo">
            <label class="campo__label">Estatus:</label>
            <input 
                type="text"
                name="estado"
                id="estado"
                value = "<?php echo $estatus;?>"
                disabled/>
        </div>
        <input type="submit" value="Validar">
    </form>
</main>