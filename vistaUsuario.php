
<?php 

include('config/db.php');
$db = conectarDB();

$correo = "";
$password = "";

$alertas = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $folio = mysqli_real_escape_string($db, $_POST["folio"]);
    $documento = mysqli_real_escape_string($db, $_POST["documento"]);
    
    $primeraValidación = "NO";
    $segundaValidacion = "NO";
    $validado = "NO";
    $estatus = "NO VALIDADO";

    if(!$folio){
        $alertas[] = "Es necesario que ingrese el folio del documento";
    }
    if(!$documento){
        $alertas[] = "Es necesario que ingrese el nombre del documento";
    }

    if(empty($alertas)){
        $query = "INSERT INTO registros(rfc, nombre, email, tipoBoleto, confirmado, cantidad)";
            $query .= "VALUES ('$rfc','$nombre','$correo','$costoBoletos','$confirmado','$noBoletos')";

            $resultado = mysqli_query( $db, $query);

            if( $resultado ) {
                header('Location: /boletos/registros.php');
            }
    }
}

$usuario = $_GET['id_usuario'];

        $query = "SELECT * FROM registros WHERE id_usuario = '${usuario}'";
        $result = mysqli_query($db, $query);    

?>

<?php include_once('templates/head.php') ?>

<main>
    <form action="" method="POST">
        <label for="">
            Documento:
        </label>
        <input 
            type="text"
            name="documento"
            id="documento"
            placeholder="Ingrese el documento"
        />
        <label for="">
            Folio del documento:
        </label>
        <input 
            type="text"
            name="folio"
            id="folio"
            placeholder="Ingrese el folio del documento"
        />
        <input type="submit" value="Registrar">
    </form>

    <table>
        <thead>
            <tr>
                <th>folio</th>
                <th>documento</th>
                <th>primeraValidacion</th>
                <th>segundaValidacion</th>
                <th>Validado</th>
                <th>Esatus</th>
                <th>id_usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($registros = mysqli_fetch_array($result)) :?>
                <tr>
                    <td><?php echo $registros['id_usuario'];?></td>
                    <td><?php echo $registros['folio'];?></td>
                    <td><?php echo $registros['documento'];?></td>
                    <td><?php echo $registros['primeraValidacion'];?></td>
                    <td><?php echo $registros['segundaValidacion'];?></td>
                    <td><?php echo $registros['validado'];?></td>
                    <td><?php echo $registros['status'];?></td>
                </tr>
            <?php endwhile;?>
        </tbody>
    </table>
    
</main>