<?php
    require 'includes/funciones.php';

    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guía para la decoración de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
                <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen destacada">
        </picture>
        <p class="informacion-meta">Escrito el: <span> 02/02/2023</span> por: <span> Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint consectetur odio nesciunt perspiciatis vel aliquam facere laudantium rerum velit temporibus vitae nam, nulla illo animi modi optio sequi architecto accusamus.</p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos quam numquam reiciendis autem itaque, assumenda est! Harum officia qui blanditiis nam, cumque nemo similique molestias temporibus provident eveniet magnam earum.</p>
        </div>
    </main>
    
    <?php
        incluirTemplate('footer');
    ?>