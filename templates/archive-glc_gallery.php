<?php
/*template name: Portfolio */

wp_register_script('momentjs', plugins_url('./../lib/momentjs/moment-with-locales.js', __FILE__));
wp_enqueue_script('momentjs');

wp_register_script('pikaday', plugins_url( './../lib/pikaday/pikaday.js' , __FILE__ ));
wp_enqueue_script('pikaday');

wp_register_style('pikaday', plugins_url( './../lib/pikaday/pikaday.css' , __FILE__ ));
wp_enqueue_style('pikaday');

/**
 * this template is now using project_style "1" and "elastic-porfolio-item" which orders the gallery elements in full-width
 */
get_header();

?>
<?php nectar_page_header($post->ID); ?>

<style>
    #days .day:not(.inactive) {
        cursor: pointer;
    }

    #days .day.active {
        background: #27CFC3;
    }

    #days .day.inactive{
        color: rgba(255, 255, 255, 0.6);
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

    @media only screen and (max-width: 1000px){
        .container.main-content{
            margin-top:33px;
        }
    }

    .is-selected .pika-button {
        color: #fff;
        font-weight: bold;
        background: #27CFC3;
        box-shadow: inset 0 1px 3px #178fe5;
        border-radius: 0px;
    }

    .pika-button:hover {
        color: #fff;
        background: #27CFC3;
        box-shadow: none;
        border-radius: 0px;
    }
</style>

<?php
$get_array = array();
$request = $_REQUEST['q'];

if($request){
    parse_str(substr(strstr($request, '/?'), 2), $get_array);
} else{
    $get_array = $_REQUEST;
}

if(!$get_array['date']){
    // Find last gallery
    $args = array(
        'post_type'         => 'glc_gallery',
        'order'             => 'DESC',
        'posts_per_page'    => -1,
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

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            $thisDate = date_format(date_create(get_post_meta(get_the_ID(), 'event_date', true)), "Y-m-d");
            break;
        }
    }

    wp_reset_postdata();
} else{
    $thisDate = $get_array['date'];
}
?>

<div class="container-wrap">
    <div class="container main-content" data-col-num="elastic" >

        <div class="portfolio-filters-inline full-width-content  first-section"
             style="margin-left: -90px; width: 1359px; visibility: visible; margin-top: -70px; padding-top: 50px;"
             instance="0">
            <div class="container">
                <span id="current-category">FOTOS</span>
                <ul id="days"><input type="hidden" id="pickedDate"><div id="pickaday" class="icon-calendar" style="cursor:pointer;background: none;vertical-align: sub;"></div><span class="inner"></span></ul>
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
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'compare' => '=',
                            'value' => $thisDate
                        )
                    )
                );

                $the_query = new WP_Query($portfolio);

                if ($the_query->have_posts()): while ($the_query->have_posts()):

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

                                    </div>
                                    <!--/vert-center-->
                                </div>
                            </div>
                            <!--work-item-->

                            <div class="work-meta">
                                <h4 class="title"><?php the_title(); ?></h4>

                                <?php //set date of gallery
                                $metaData = array();

                                $location = get_the_term_list($post->ID, 'location');
                                if ($location)
                                    array_push($metaData, $location);

                                $date = new DateTime(get_post_meta($post->ID, 'event_date', true));
                                array_push($metaData, $date->format('d.m.Y'));

                                echo '<p>' . implode(' | ', $metaData) . '</p>';
                                ?>
                            </div>

                        </div>
                        <!--inner-->
                    </div><!--/col-->

                <?php endwhile; endif; ?>
            </div>
            <!--/portfolio-->
        </div>
        <!--/portfolio wrap-->

    </div><!--/container-->

    <?php wp_reset_postdata(); ?>

</div><!--/container-wrap-->
<form style="display: none;" id="dateform" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input name="date" type="hidden">
</form>

<!-- Generate days -->
<script>
    <?php
    $the_query =
    new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'glc_gallery'
    ));

    $json = array();
    if ($the_query->have_posts()){
        while ($the_query->have_posts()){
            $the_query->the_post();

             $d = new DateTime(get_post_meta($post->ID, 'event_date', true));

            if($d){
                if($json[$d->format('d.m.Y')]){
                    array_push($json[$d->format('d.m.Y')], get_the_ID());
                } else{
                    $json[$d->format('d.m.Y')] = array(get_the_ID());
                }
            }
        }
    }

    echo 'var galleries = ' . json_encode($json, true);

    wp_reset_postdata();
    ?>

    jQuery(document).ready(function () {
        // Generating day entries
        var day = moment().locale('de');
        for (var i = 0; i < 7; i++) {
            var inactive = 'inactive';
            if(galleries[day.format('DD.MM.YYYY')])
                inactive = '';

            jQuery('#days .inner').prepend('<li data-day="' + day.format('YYYY-MM-DD') + '" data-date="' + day._d + '" class="' + inactive + ' day">' + day.format('dd, D.') + '</li>');
            day.subtract(1, 'days');
        }

        jQuery('#days .day').not('.inactive').click(function (e) {
            e.preventDefault();

            var d = new Date(jQuery(this).attr('data-date'));
            var m = moment(d);
            var dString = m.format('YYYY-MM-DD');

            jQuery('input[name="date"]').val(dString);
            jQuery('#dateform').submit();
        });

        jQuery('.day[data-day="<?php echo $thisDate; ?>"]').addClass('active');

        // Init calendar
        var currentDate = new Date('<?php echo $thisDate; ?>');
        var pikaday = new Pikaday({
            field: jQuery('#pickedDate')[0],
            trigger: jQuery('#pickaday')[0],
            disableDayFn: function(d){
                return !galleries[moment(d).format('DD.MM.YYYY')];
            },
            onSelect: function() {
                var d = this.getDate();
                var m = moment(d);
                var dString = m.format('YYYY-MM-DD');

                d.setHours(0,0,0,0);
                currentDate.setHours(0,0,0,0);
                if(d.getTime() == currentDate.getTime()) return;

                jQuery('input[name="date"]').val(dString);
                jQuery('#dateform').submit();
            },
            onOpen: function(){
                pikaday.gotoDate(currentDate);
                pikaday.setDate(currentDate);
            }
        });
    });
</script>

<?php get_footer(); ?>
