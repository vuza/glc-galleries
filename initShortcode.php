<?php

define( 'MYPLUGIN_FOLDER', dirname( __FILE__ ) . '/' );

add_shortcode('newgalleries', 'gallery_handler');
function gallery_handler(){
    //run code from template
    echo include 'templates/newGalleries.php';
}

