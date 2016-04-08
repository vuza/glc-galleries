<?php get_header(); ?>

<?php

$cols = 'elastic';
$span_num = 'elastic-portfolio-item';
$project_style = '1';
$masonry_layout = 'false';
$infinite_scroll_class = null;

// This is a little hack, to work with salient theme
wp_enqueue_script('isotope');

wp_register_script('lightbox', plugins_url( './../lib/lightbox/js/lightbox.js' , __FILE__ ));
wp_enqueue_script('lightbox');

wp_register_style('lightbox', plugins_url( './../lib/lightbox/css/lightbox.css' , __FILE__ ));
wp_enqueue_style('lightbox');
?>    <div class="container-wrap">
        <div class="container main-content">

            <?php
                    if((empty($bg) && empty($bg_color)) && $fullscreen_header != true):

                        $meta = array();

                        $location = get_the_term_list($post->ID, 'location');
                        $photographer = get_the_term_list($post->ID, 'photographer');

                        if($location)
                            array_push($meta, $location);

                        if($photographer)
                            array_push($meta, $photographer);

                        $date = new DateTime(get_post_meta($post->ID, 'event_date', true));

                        if($date)
                            array_push($meta, $date->format('d.m.Y'));

                        $sm = "<a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] . "'><i class='icon-facebook'></i></a>";
                        array_push($meta, $sm);
                        ?>

                        <div class="row heading-title" data-header-style="<?php echo $blog_header_type; ?>">
                            <div class="col span_12 section-title blog-title">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                <h4><?php echo implode(' | ', $meta); ?></h4>
                            </div><!--/section-title-->
                        </div><!--/row-->


                        <?php
                        $images = explode(',', get_post_galleries($post->ID, false)[0]['ids']);
                        ?>


                        <div class="row portfolio-items" data-categories-to-show="0" data-rcp="false" data-ps="2" data-starting-filter="default" data-col-num="cols-4" instance="0">
                            <?php foreach($images as $image): ?>
                                <?php $image_src = wp_get_attachment_image_src( $image, 'full' )[0];
                                $image = wp_get_attachment_image( $image, 'full' )?>

                                <div class="col span_3  element applications illustration  one-fourths clear-both" data-title-color="0" data-subtitle-color="0">
                                    <div class="inner-wrap" data-animation="none">
                                        <div class="work-item style-2" data-custom-content="">
                                            <a data-title="<a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=<?php echo $image_src; ?>'><i class='icon-facebook'></i></a>" class="lightbox-wrapper" href="<?php echo $image_src; ?>" data-lightbox="gallery">
                                                <?php echo $image; ?>

                                                <div class="work-info-bg" style="opacity: 0;"></div>
                                                <div class="work-info">
                                                    <div class="vert-center" style="text-align:center">
                                                        <img style="width:20%; display:inline-block;" src="<?php echo plugin_dir_url(__FILE__); ?>/../../img/arrows.png">
                                                    </div>
                                                    <!--/vert-center-->
                                                </div>
                                            </a>
                                            <!--/vert-center-->
                                        </div>
                                    </div><!--work-item-->
                                </div><!--/inner-wrap-->
                            <?php endforeach; ?>
                        </div>

                        <?php endif; ?>

        <?php if($theme_skin != 'ascend') nectar_next_post_display(); ?>

    </div><!--/container-->

    </div><!--/container-wrap-->

    <script>
        jQuery(document).ready(function(){
            setTimeout(function(){
                jQuery('.lightbox-wrapper').off('click').on('click', function(e){
                    e.preventDefault();
                    lightbox.start(jQuery(this));
                });

                lightbox.option({
                    showImageNumberLabel: false,
                    fadeDuration: 0
                });
            }, 200);
        });
    </script>

<?php get_footer(); ?>