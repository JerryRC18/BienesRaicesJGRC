<?php

    //Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header ('Location: /admin');
    }
    //Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Obtener los datos de la propiedad
    $consulta = "SELECT * FROM propiedades WHERE id = $id";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado);



    //Consultar bd
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
    //Arreglo con mensaje de errores
    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc =  $propiedad['wc'];
    $estacionamiento =  $propiedad['estacionamiento'];
    $vendedores_id = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];


    //Ejecutar el código después de que el usuario envía el formulario.
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo']);
        $precio = mysqli_real_escape_string( $db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string( $db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento']);
        $vendedores_id = mysqli_real_escape_string( $db, $_POST['vendedores_id']);
        $creado = date('Y/m/d');

        //Asignar FILES a una variable
        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = "Debes añadir un título";
        }

        if(!$precio){
            $errores[] = "Debes añadir un precio";
        }

        if( strlen($descripcion) < 50 ){
            $errores[] = "La descripción debe ser mayor a 50 caracteres";
        }

        if(!$habitaciones){
            $errores[] = "Numero de habitaciones es obligatorio ";
        }

        if(!$wc){
            $errores[] = "Numero de baños es obligatorio ";
        }

        if(!$estacionamiento){
            $errores[] = "Numero de lugares de estacionamiento es obligatorio ";
        }

        if(!$vendedores_id){
            $errores[] = "Numero de habitaciones es obligatorio ";
        }

        //Validar por tamaño
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida){
            $errores[] = "La imagen es muy pesada";
        }


        // echo "<pre>";
        // var_dump($errores);
        // echo "<pre>";

        //Revisar que el arreglo de errores este vacio.
        if(empty($errores)){

            //Crear una carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                 mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            //Subida de archivos 

            if($imagen['name']){
                //Eliminar la imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);
            
                //Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
                //Subir imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            } else {
                $nombreImagen = $propiedad['imagen'];
            }
            
             //Insertar en la base de datos
            $query = " UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedores_id WHERE id = $id ";
        
            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                //Redireccionar al usuario 
                header('Location: /admin?resultado=2'); //Sólo funciona si no hay nada de HTML previo
            } 
        }
        
       
    }
    require '../../includes/funciones.php';

    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>Actualizar Propiedades</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>
        
        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">
                
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio; ?>">
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <img src="/imagenes/<?php echo $imagenPropiedad; ?>" class="imagen-small">

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>
            
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedores_id">
                    <option value="">--Seleccione--</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado) ):?>
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : '';  ?> value="<?php echo $vendedor['id'] ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?> </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>
    
    <?php
        incluirTemplate('footer');
    ?>