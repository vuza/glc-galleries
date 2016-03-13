<?php

add_filter( 'archive_template', 'loadTemplate' );

function loadTemplate(){
    if(get_post_type() == 'glc_gallery'){
        $template = MYPLUGIN_FOLDER . 'templates/archive-glc_gallery.php';
        return $template;
    }
}