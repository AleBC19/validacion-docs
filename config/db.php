<?php

function conectarDB(): mysqli {
    //$db = mysqli_connect('mysql-alebc.alwaysdata.net', 'alebc', 'Alejandra12_', 'alebc_boletos');
    $db = mysqli_connect('localhost', 'root', 'sqlale30', 'validacion_documentos');

    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}
