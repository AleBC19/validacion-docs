<?php
include('config/db.php');
include('templates/funciones.php');
$db = conectarDB();

$correo = "";
$password = "";
$alertas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo =  mysqli_real_escape_string($db, $_POST["correo"]);
    $password =  mysqli_real_escape_string($db, $_POST["password"]);

    if (!$correo) {
        $alertas[] = "El nombre de usuario es necesario";
    }
    if (!$password) {
        $alertas[] = "El password es necesario";
    }

    $queryExisteUser = "SELECT * from usuarios WHERE correo = '${correo}' LIMIT 1";
    $resultadoExiste = mysqli_query($db, $queryExisteUser);
    if ($resultadoExiste->num_rows > 0) {
        $alertas[] = "El correo " . $correo . " ya ha sido registrado";
    }

    if (strlen($password) < 8) {
        $alertas[] = "El password debe tener al menos 8 caracteres";
    }

    if (empty($alertas)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO usuarios(correo, password, admin)";
        $query .= "VALUES ('${correo}', '${passwordHash}', 0)";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /validacion-docs2/index.php?mensaje=2');
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
            <h1>Cree una cuenta</h1>
            <form action="" method="POST">
                <?php foreach ($alertas as $alerta) : ?>
                    <div class="alerta">
                        <?php echo $alerta; ?>
                    </div>
                <?php endforeach; ?>

                <div class="campo">
                    <label class="campo__label" for="correo">Correo:</label>
                    <input type="correo" name="correo" id="correo" class="campo__input">
                </div>
                <div class="campo">
                    <label class="campo__label" for="password">Contrase??a:</label>
                    <input type="password" name="password" id="password" class="campo__input">
                </div>
                <input type="submit" value="Registrarme" class="Iniciar Sesi??n">
                <div class="campo">
                    <a href="index.php">??Ya tienes una cuenta? Inicia Sesi??n</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include_once('templates/footer.php') ?>