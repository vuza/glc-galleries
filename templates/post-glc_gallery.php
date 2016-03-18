<?php get_header(); ?>

<?php

$cols = 'elastic';
$span_num = 'elastic-portfolio-item';
$project_style = '1';
$masonry_layout = 'false';
$infinite_scroll_class = null;

// This is a little hack, to work with salient theme
wp_enqueue_script('isotope');
?>

    <div class="container-wrap">
        <div class="container main-content">

            <?php
                    if((empty($bg) && empty($bg_color)) && $fullscreen_header != true): ?>

                        <div class="row heading-title" data-header-style="<?php echo $blog_header_type; ?>">
                            <div class="col span_12 section-title blog-title">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </div><!--/section-title-->
                        </div><!--/row-->


                        <?php
                        $images = get_post_gallery_images($post->ID); ?>


                        <div class="row portfolio-items" data-categories-to-show="0" data-rcp="false" data-ps="2" data-starting-filter="default" data-col-num="cols-4" instance="0">
                            <?php foreach($images as $image): ?>
                            <div class="col span_3  element applications illustration  one-fourths clear-both" data-title-color="0" data-subtitle-color="0">
                                <div class="inner-wrap" data-animation="none">
                                    <div class="work-item style-2" data-custom-content="">
                                        <img width="600" height="403" src="<?php echo $image; ?>" class="attachment-portfolio-thumb size-portfolio-thumb wp-post-image" alt="SAMSUNG CSC" title="" style="height: 194px;">
                                        <div class="work-info-bg" style="opacity: 0;"></div>
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

<?php get_footer(); ?>