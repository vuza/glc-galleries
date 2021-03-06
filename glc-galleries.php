<?php
/**
 * Plugin Name: GLC Galleries
 * Description: Event galleries for GLC
 * Version: 1.2.1
 * Author: Marlon Alagoda, Niki Themmer
 * License: All private
 */

include "glc_cpt.php";
include "templates/filter.php";
include "ajax/load_galleries.php";

// Register shortcode
function gallery_handler($atts)
{
    $galleries = (int)$atts['count'];

    ob_start();
    //run code from template
    include 'templates/newGalleries.php';
    $content = ob_get_clean();
    return $content;
}

add_shortcode('newgalleries', 'gallery_handler');