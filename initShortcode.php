<?php

add_shortcode('newgalleries', 'gallery_handler');
function gallery_handler(){
    ob_start();
    //run code from template
    include 'templates/newGalleries.php';
    $content = ob_get_clean();
    return $content;
}

