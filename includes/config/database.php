<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost', 'root', 'root', 'bienesraicesdb');

    if(!$db){
        echo ("No se pudo conectar");
        exit;
    }

    return $db;
}