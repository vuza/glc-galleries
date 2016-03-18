<style>
    #newgalleries{
        margin-left: -10px!important;
        margin-right: -10px!important;
        cursor: default;
    }

    #newgalleries .col {
        width: 33.3%;
        display: inline-block;
        padding: 10px;
        margin: 0;
    }
</style>

<?php

// This is a little hack, to work with salient theme
wp_enqueue_script('isotope');
wp_enqueue_script('caroufredsel');

$args = array(
    'post_type'         => 'glc_gallery',
    'order'             => 'ASC',
    'posts_per_page'    => 3,
    'orderby'           => 'meta_value',
    'meta_key'          => 'event_date',
    'meta_query'        => array(
        array(
            'key'           => 'event_date',
            'type'          => 'DATETIME'
        )
    )
);

// The Query
$the_query = new WP_Query($args);

if ( $the_query->have_posts() ): ?>
    <div id="newgalleries" class="row portfolio-items carousel" data-categories-to-show="all" data-easing="">

        <?php while ( $the_query->have_posts() ): ?>
        <li class="col span_4" data-default-color="true" data-title-color="" data-subtitle-color="">
            <div class="inner-wrap">
                <div class="work-item">

                    <?php $the_query->the_post();

                        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

                        echo get_the_post_thumbnail();
                        ?>

                    <div class="work-info-bg"></div>
                    <div class="work-info">
                        <div class="vert-center">
                            <?php
                            echo '<a class="default-link" href="' . get_permalink() . '">' . __("Mehr anzeigen", NECTAR_THEME_NAME) . '</a>';
                            ?>
                        </div><!--/vert-center-->
                    </div>
                </div>
                <div class="work-meta">
                    <h4 class="title"><?php echo get_the_title(); ?></h4>
                    <?php $locations = get_the_term_list(get_the_ID(), 'location');
                    if($locations): ?>
                        <p><?php echo $locations; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </li>


        <?php endwhile; ?>

    </div>
<?php endif;
?>

<?php wp_reset_postdata(); ?>
