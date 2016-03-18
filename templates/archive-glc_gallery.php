<?php
/*template name: Portfolio */

wp_register_script('momentjs', plugins_url( './../lib/momentjs/moment-with-locales.js' , __FILE__ ));
wp_enqueue_script('momentjs');

/**
 * this template is now using project_style "1" and "elastic-porfolio-item" which orders the gallery elements in full-width
 */
get_header();

?>
<?php nectar_page_header($post->ID); ?>

<style>
    #days .day{
        cursor: pointer;
    }

    .portfolio-filters-inline .container > ul li {
        padding: 0px 10px;
        margin: 7px 0px;
        font-size: 12px;
        line-height: 14px;
        display: inline-block;
    }

    .portfolio-filters-inline:not([data-color-scheme="default"]) ul li {
        color: #fff;
        padding: 7px 10px;
        transition: background-color 0.15s linear, color 0.15s linear;
    }
</style>

<?php
$get_array = array();
parse_str(substr(strstr($_REQUEST['q'], '/?'), 2), $get_array);
?>

<div class="container-wrap">
    <div class="container main-content" data-col-num="elastic"/>

        <div class="portfolio-filters-inline full-width-content  first-section" style="margin-left: -90px; width: 1359px; visibility: visible; margin-top: -70px; padding-top: 50px;" instance="0">
            <div class="container">
                <span id="current-category">Veranstaltungsdatum</span>
                <ul id="days"></ul>
                <div class="clear"></div>
            </div>
        </div>

        <div class="portfolio-wrap default-style">

            <div id="portfolio"
                 class="row portfolio-items no-masonry"
                 data-categories-to-show=""
                 data-ps="1" data-starting-filter="">

                <?php
                $portfolio = array(
                    'posts_per_page' => -1,
                    'post_type' => 'glc_gallery',
                    'meta_key' => 'event_date',
                    'meta_query'        => array(
                        array(
                            'key'           => 'event_date',
                            'compare'       => '=',
                            'value'         => $get_array['date']
                        )
                    )
                );

                $the_query = new WP_Query($portfolio);

                if ( $the_query->have_posts() ): while ( $the_query->have_posts() ):

                    $the_query->the_post();

                    $the_project_link = get_permalink();
                    ?>

                    <div
                        class="col elastic-portfolio-item element" data-default-color="true">

                        <div class="inner-wrap animated">

                            <div class="work-item style-1">

                                <?php

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

                                    <div class="vert-center">
                                        <?php
                                            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                            echo '<a class="default-link" href="' . $the_project_link . '">' . __("Mehr anzeigen", NECTAR_THEME_NAME) . '</a>';
                                        ?>

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

                        </div><!--inner-->
                    </div><!--/col-->

                <?php endwhile; endif; ?>
            </div><!--/portfolio-->
        </div><!--/portfolio wrap-->

    </div><!--/container-->

</div><!--/container-wrap-->
<form style="display: none;" id="dateform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input name="date" type="hidden">
</form>
<!-- Generate days -->
<script>
    jQuery(document).ready(function(){
        var day = moment().locale('de');
        for(var i = 0; i < 7; i++){
            jQuery('#days').prepend('<li data-date="' + day._d + '" class="day">' + day.format('dd, D.') + '</li>');
            day.subtract(1, 'days');
        }

        jQuery('#days .day').click(function(e){
            e.preventDefault();

            var d = new Date(jQuery(this).attr('data-date'));
            var m = moment(d);
            var dString = m.format('YYYY-MM-DD');

            jQuery('input[name="date"]').val(dString);
            jQuery('#dateform').submit();
        });
    });
</script>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
