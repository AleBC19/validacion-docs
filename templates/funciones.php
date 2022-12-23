<?php
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function sendMail( $correoFrom, $foliodoc ) {

    //EMAIL
    $emailDestino = "";
    $asunto = "";
    $mensaje = "";
    $remitente = "Alejandra Celestino Bautista <bautistacelestinoalejandra@gmail.com>";

    $emailDestino = $correoFrom;
    $asunto = "Validación de sus documentos";
    $mensaje = " Un documento suyo con folio: " . $foliodoc . " ha sido validado";
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    mail($emailDestino, $asunto, $mensaje, $cabeceras, $remitente);

    echo $correoFrom;
}