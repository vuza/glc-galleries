<?php
/*template name: Portfolio */

/**
 * this template is now using project_style "1" and "elastic-porfolio-item" which orders the gallery elements in full-width
 */
get_header();

$options = get_nectar_theme_options();
$project_style = '1';
//$infinite_scroll_class = null;
$lightbox_only = false;

$display_sortable = get_post_meta($post->ID, 'nectar-metabox-portfolio-display-sortable', true);
$bg = get_post_meta($post->ID, '_nectar_header_bg', true);
//disable masonry for default project style fullwidth

?>
<?php nectar_page_header($post->ID); ?>

<div class="container-wrap">
    <div class="container main-content" data-col-num="elastic"/>
        <div class="portfolio-wrap default-style">
            <div id="portfolio"
                 class="row portfolio-items no-masonry"
                 data-categories-to-show="<?php echo $project_categories; ?>"
                 data-ps="1" data-starting-filter=""
                 data-col-num="elastic">

                <?php

                $portfolio = array(
                    'posts_per_page' => $posts_per_page,
                    'post_type' => 'glc_gallery',
                    'project-type' => $project_categories,
                    'paged' => $paged
                );


                if (have_posts()) : while (have_posts()) : the_post();

                    $terms = get_the_terms($post->id, "project-type");
                    $project_cats = NULL;

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $project_cats .= strtolower($term->slug) . ' ';
                        }
                    }

                    $custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
                    $the_project_link = (!empty($custom_project_link)) ? $custom_project_link : get_permalink();

                    //TODO
                    $project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);
                    $project_title_color = get_post_meta($post->ID, '_nectar_project_title_color', true);
                    $project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
                    ?>

                    <div
                        class="col elastic-portfolio-item element"
                        <?php if (!empty($project_accent_color)) {
                            echo 'data-project-color="' . $project_accent_color . '"';
                        } else {
                            echo 'data-default-color="true"';
                        } ?> data-title-color="<?php echo $project_title_color; ?>"
                        data-subtitle-color="<?php echo $project_subtitle_color; ?>">

                        <div class="inner-wrap animated">

                            <?php //project style 1

                            $using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true);
                            $custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>

                            <div class="work-item style-1"
                                 data-custom-content="<?php echo $using_custom_content; ?>">

                                <?php

                                $thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';

                                if (has_post_thumbnail()) {
                                    echo get_the_post_thumbnail($post->ID, $thumb_size, array('title' => ''));
                                } //no image added
                                else {
                                    switch ($thumb_size) {
                                        case 'wide':
                                            $no_image_size = 'no-portfolio-item-wide.jpg';
                                            break;
                                        case 'tall':
                                            $no_image_size = 'no-portfolio-item-tall.jpg';
                                            break;
                                        case 'regular':
                                            $no_image_size = 'no-portfolio-item-tiny.jpg';
                                            break;
                                        case 'wide_tall':
                                            $no_image_size = 'no-portfolio-item-tiny.jpg';
                                            break;
                                        default:
                                            $no_image_size = 'no-portfolio-item-small.jpg';
                                            break;
                                    }
                                    echo '<img src="' . get_template_directory_uri() . '/img/' . $no_image_size . '" alt="no image added yet." />';
                                }

                                ?>

                                <div class="work-info-bg"></div>
                                <div class="work-info">

                                    <?php
                                    //custom content
                                    if ($using_custom_content == 'on') {
                                        if (!empty($custom_project_link)) echo '<a href="' . $the_project_link . '"></a>';
                                        echo '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div></div></div>';
                                        //default
                                    } else { ?>

                                    <div class="vert-center">
                                        <?php

                                        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

                                        if ($lightbox_only != 'true') {
                                            echo '<a class="default-link" href="' . $the_project_link . '">' . __("Mehr anzeigen", NECTAR_THEME_NAME) . '</a>';
                                        } ?>

                                    </div><!--/vert-center-->
                                </div>
                            </div><!--work-item-->

                            <div class="work-meta">
                                <h4 class="title"><?php the_title(); ?></h4>

                                <?php //set date of gallery
                                $metaData = array();

                                $location = get_the_term_list($post->ID, 'location');
                                if($location)
                                    array_push($metaData, $location);

                                $date = new DateTime(get_post_meta($post->ID, 'event_date', true));
                                array_push($metaData, $date->format('m - d - y'));

                                echo '<p>' . implode(' | ', $metaData) . '</p>';
                                ?>
                            </div>

                        <?php }

                        ?>

                        </div><!--inner-->
                    </div><!--/col-->

                <?php endwhile; endif; ?>
            </div><!--/portfolio-->
        </div><!--/portfolio wrap-->

    </div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>
