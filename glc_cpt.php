<?php

define( 'MYPLUGIN_FOLDER', dirname( __FILE__ ) . '/' );

/**
 * Init taxonomy "Photographer"
 */
add_action( 'init', 'create_photographer_taxonomy' );
function create_photographer_taxonomy() {
    register_taxonomy(
        'photographer',
        'glc_gallery',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => 'Fotograf' //TODO nicer labels, like "Add new Tag" to "Neuen Fotograph hinzufügen", ...
            ),
            'rewrite' => array( 'slug' => 'fotograf' )
        )
    );
}

/**
 * Init taxonomy "Location"
 */
add_action( 'init', 'create_location_taxonomy' );
function create_location_taxonomy() {
    register_taxonomy(
        'location',
        'glc_gallery',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => 'Ort'
            ),
            'rewrite' => array( 'slug' => 'ort' )
        )
    );
}

/**
 * Init article type GLC Gallery
 */
add_action('init', 'create_post_type');
function create_post_type() {
    register_post_type( 'glc_gallery',
        array(
            'labels' => array(
                'name' => 'Galerien',
                'singular_name' => 'Galerie',
                'add_new' => 'Neue Galerie hinzufügen'
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'rewrite' => array( 'slug' => 'fotos' )
        )
    );
}

// Include: Add date in metabox to custom post type
include "date_metabox.php";

/**
 * Make date a mandatory field
 */
function add_date_notice($location) {
    remove_filter('redirect_post_location', __FILTER__, '99');
    return add_query_arg('my_message', 1, $location);
}

function no_date_notice() {
    if (!isset($_GET['my_message']) ||
        (isset($_GET['post_type']) && $_GET['post_type'] != 'glc_gallery') ||
        (get_post_type($_GET['post']) && get_post_type($_GET['post']) != 'glc_gallery')) return;

    switch (absint($_GET['my_message'])) {
        case 1:
            $message = 'Invalid post data';
            break;
        default:
            $message = 'Unexpected error';
    }
    echo '<div id="notice" class="error"><p>ACHTUNG! Es muss ein Datum gew&auml;hlt werden</p></div>';
}

add_action('admin_notices', 'no_date_notice');