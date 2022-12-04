
<?php 

include('config/db.php');
include('templates/funciones.php');
$db = conectarDB();

$id_usuario = $_GET["id_usuario"];

$correo = "";
$password = "";

$alertas = [];

$query = "SELECT * FROM registros WHERE id_usuario = '${id_usuario}'";
$result = mysqli_query($db, $query);  
$usuario = mysqli_fetch_assoc($result);

$folio = $usuario['folio'];
$documento = $usuario['documento'];
$primeraValidacion = $usuario['primeraValidacion'];
$segundaValidacion = $usuario['segundaValidacion'];
$validado = $usuario['validado'];
$estatus = $usuario['estatus'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $folio = mysqli_real_escape_string($db, $_POST["folio"]);
    $documento = mysqli_real_escape_string($db, $_POST["documento"]);
    
    $primeraValidacion = "SI";
    $segundaValidacion = "SI";
    $validado = "SI";
    $estatus = "VALIDADO";

    if(!$folio){
        $alertas[] = "Es necesario que ingrese el folio del documento";
    }
    if(!$documento){
        $alertas[] = "Es necesario que ingrese el nombre del documento";
    }

    if(empty($alertas)){

        $query = "UPDATE registros SET folio = '$folio', documento = '$documento', primeraValidacion = '$primeraValidacion'";
        $query .= ",segundaValidacion = '$segundaValidacion', validado = '$validado', estatus = '$estatus', id_usuario = '$id_usuario')";
            
        //debuguear($query);

        $resultado = mysqli_query( $db, $query);

        if( $resultado ) {
                //header('Location: /boletos/registros.php');
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

    <form action="" method="POST">
        <label for="">
            ID Usuario:
        </label>
        <input 
            type="text" 
            name="id_usuario" 
            id="id_us"
            value = "<?php echo $id_usuario;?>"
            disabled 
        />
        <label for="">
            Documento:
        </label>
        <input 
            type="text"
            name="documento"
            id="documento"
            value = "<?php echo $documento;?>"
            disabled 
        />
        <label for="">
            Folio del documento:
        </label>
        <input 
            type="text"
            name="folio"
            id="folio"
            placeholder="Ingrese el folio del documento"
            value = "<?php echo $folio;?>"
            disabled 
        />
        <label for="">
            primera Validacion:
        </label>
        <input 
            type="text"
            name="primeraValidacion"
            id="primeraValidacion"
            value = "<?php echo $primeraValidacion;?>"
        />
        <label for="">
            segunda Validacion:
        </label>
        <input 
            type="text"
            name="segundaValidacion"
            id="segundaValidacion"
            value = "<?php echo $segundaValidacion;?>"
        />
        <label for="">
            Validacion:
        </label>
        <input 
            type="text"
            name="validado"
            id="validado"
            value = "<?php echo $validado;?>"
            disabled 
        />
        <label for="">
            Estatus:
        </label>
        <input 
            type="text"
            name="estado"
            id="estado"
            value = "<?php echo $estatus;?>"
            disabled
        />

        <input type="submit" value="Validar">
    </form>
    
</main>