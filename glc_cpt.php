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
            'labels' => array(
                'name' => 'Fotograph' //TODO nicer labels, like "Add new Tag" to "Neuen Fotograph hinzufügen", ...
            ),
            'rewrite' => array( 'slug' => 'photographer' )
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
            'labels' => array(
                'name' => 'Ort'
            ),
            'rewrite' => array( 'slug' => 'location' )
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
                'name' => 'Galleries',
                'singular_name' => 'Gallery',
                'add_new' => 'Neue Gallerie hinzufügen'
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'rewrite' => array( 'slug' => 'gallery' )
        )
    );
}

// Include: Add date in metabox to custom post type
include "date_metabox.php";
