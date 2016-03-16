<?php

$args = array(
    'post_type' => 'glc_gallery',
    'order' => 'DESC',
    'project-type' => $project_categories,
);


// The Query
$the_query = new WP_Query($args);

?>
<div id="portfolio"
     class="row portfolio-items no-masonry"
     data-categories-to-show="<?php echo $project_categories; ?>"
     data-ps="1" data-starting-filter=""
     data-col-num="elastic">
    <?php
    // The Loop
    if ($the_query->have_posts()) {

        for ($x = 0; $x < 3; $x++) { ?>

            <div class="col elastic-portfolio-item element" data-default-color="true">
                <div class="inner-wrap animated">
                    <div class="work-item style-1">
                        <?php
                        $the_project_link = get_permalink();
                        if ($the_query->have_posts()) {

                            $the_query->the_post();
                            echo get_the_post_thumbnail();
                        } ?>
                        <div class="work-info">
                            <div class="vert-center">
                                <?php
                                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                echo '<a class="default-link" href="' . $the_project_link . '">' . __("Mehr anzeigen", NECTAR_THEME_NAME) . '</a>';
                                ?>
                            </div><!--/vert-center-->
                        </div>
                    </div>
                </div>
            </div>

            <?php

        }
    } else {
        echo 'no posts';
    } ?>
