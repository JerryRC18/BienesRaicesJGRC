<?php

    //Conectar db
    require 'includes/config/database.php';
    $db = conectarDB();

    $errores = [];
    //Autenticar el usuario 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      
        $email = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) ;
        $password = mysqli_real_escape_string ($db, $_POST['password']);
        
        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }
        if(!$password){
            $errores[] = "El password es obligatorio";
        }
    }
    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <form method="POST" class="formulario">
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu e-mail" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password">

            </fieldset>

            <input type="submit" value="Iniciar Sesión" class=" boton boton-verde">
        </form>

    </main>
    
<?php
    incluirTemplate('footer');
?>