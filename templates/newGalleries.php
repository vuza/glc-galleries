<style>
    #newgalleries {
        margin-left: -10px !important;
        margin-right: -10px !important;
        cursor: default;
    }

    #newgalleries .col {
        /*width: 33.3%;*/
        display: inline-block;
        padding: 10px;
        margin: 0;
    }

    #newgalleries.portfolio-items .col.span_3{
        width: 25%;
    }
</style>

<?php

// This is a little hack, to work with salient theme
wp_enqueue_script('isotope');
wp_enqueue_script('caroufredsel');

$args = array(
    'post_type' => 'glc_gallery',
    'order' => 'DESC',
    'posts_per_page' => $galleries?$galleries:4,
    'orderby' => 'meta_value',
    'meta_key' => 'event_date',
    'meta_query' => array(
        array(
            'key' => 'event_date',
            'type' => 'DATETIME'
        )
    )
);

// The Query
$the_query = new WP_Query($args);

if ($the_query->have_posts()): ?>
    <div id="newgalleries" class="row portfolio-items" data-categories-to-show="0" data-rcp="false" data-ps="2" data-starting-filter="default" data-col-num="cols-4" instance="0">

        <?php while ($the_query->have_posts()): ?>
            <li class="col span_3 element applications illustration one-fourths clear-both">
                <div class="inner-wrap">
                    <div class="work-item">

                        <?php $the_query->the_post();

                        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');

                        echo "<img src='" . $featured_image[0] . "'>";
                        ?>

                        <div class="work-info-bg"></div>
                        <div class="work-info">
                            <div class="vert-center">
                                <?php
                                echo '<a class="default-link" href="' . get_permalink() . '">' . __("Mehr anzeigen", NECTAR_THEME_NAME) . '</a>';
                                ?>
                            </div>
                            <!--/vert-center-->
                        </div>
                    </div>
                    <div class="work-meta">
                        <h4 class="title"><?php echo get_the_title(); ?></h4>
                        <?php //set date of gallery
                        $metaData = array();

                        $location = get_the_term_list(get_the_ID(), 'location');
                        if ($location)
                            array_push($metaData, $location);

                        $photographer = get_the_term_list(get_the_ID(), 'photographer', '', ', ');
                        if($photographer)
                            array_push($metaData, $photographer);

                        $date = new DateTime(get_post_meta(get_the_ID(), 'event_date', true));
                        array_push($metaData, $date->format('d.m.Y'));

                        echo '<p>' . implode(' | ', $metaData) . '</p>';
                        ?>
                    </div>
                </div>
            </li>


        <?php endwhile; ?>

    </div>
<?php endif;
?>

<?php wp_reset_postdata(); ?>
