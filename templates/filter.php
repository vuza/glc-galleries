<?php

add_filter( 'archive_template', 'loadArchiveTemplate' );
function loadArchiveTemplate($archive_template){
    if(get_post_type() == 'glc_gallery'){
        $template = MYPLUGIN_FOLDER . 'templates/archive-glc_gallery.php';
        return $template;
    }

    return $archive_template;
}

add_filter( 'single_template', 'loadGalleryTemplate');
function loadGalleryTemplate($single_template){
    if(get_post_type() == 'glc_gallery'){
        $template = MYPLUGIN_FOLDER . 'templates/post-glc_gallery.php';
        return $template;
    }

    return $single_template;
}