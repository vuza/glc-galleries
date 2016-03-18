<?php
/**
 * Plugin Name: GLC Galleries
 * Description: Event galleries for GLC
 * Version: 0.0.1
 * Author: Marlon Alagoda, Niki Themmer
 * License: All private
 */

include "glc_cpt.php";
include "templates/filter.php";

// Register shortcode
function gallery_handler(){
    ob_start();
    //run code from template
    include 'templates/newGalleries.php';
    $content = ob_get_clean();
    return $content;
}

add_shortcode('newgalleries', 'gallery_handler');

/**
 * TODO
 * Galleries Overview: http://themenectar.com/demo/salient-ascend/portfolio-fullwidth-default/
 * Gallery overview (showing images): http://themenectar.com/demo/salient-ascend/portfolio-4-columns/
 */
