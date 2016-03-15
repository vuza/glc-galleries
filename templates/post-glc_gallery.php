<?php get_header(); ?>

<?php

global $nectar_theme_skin, $options;

$$options = get_nectar_theme_options();
$cols = 'elastic';
$span_num = 'elastic-portfolio-item';
$project_style = '1';
$masonry_layout = 'false';
$infinite_scroll_class = null;

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


                        <div class="row">
                            <div class="col elastic-portfolio-item element">
                                <div class="inner-wrap animated">
                                    <div class="work-item style-1">
                                        <?php
                                        $images = get_post_gallery_images($post->ID);

                                        foreach($images as $image): ?>
                                            <div class="col span_3  element applications illustration  one-fourths clear-both">

                                                <div class="inner-wrap" data-animation="none">


                                                    <div class="work-item style-2" data-custom-content="">

                                                        <img width="600" height="403" src="http://themenectar.com/demo/salient-ascend/wp-content/uploads/2014/07/1r2DXHY-600x403.jpg" class="attachment-portfolio-thumb size-portfolio-thumb wp-post-image" alt="SAMSUNG CSC" title="" style="height: 194px;">
                                                        <div class="work-info-bg" style="opacity: 0;"></div>
                                                        <div class="work-info" style="opacity: 0;">




                                                            <a href="http://www.youtube.com/user/ThemeNectar" target="_blank"></a>



                                                            <div class="vert-center" style="margin-top: -20px;">

                                                                <h3 style="opacity: 0;">The Mountains</h3>
                                                                <p style="opacity: 0;">External Link Example</p>									</div><!--/vert-center-->

                                                        </div>
                                                    </div><!--work-item-->



                                                </div><!--/inner-wrap-->
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>

        <?php if($theme_skin != 'ascend') nectar_next_post_display(); ?>

    </div><!--/container-->

    </div><!--/container-wrap-->

<?php get_footer(); ?>