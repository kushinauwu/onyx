<?php
/**
 * The front page template file
 * @package Onyx
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="showcase-wrapper">
            <!-- carousel for cpt -->
            <div id="carouselSlider" class="carousel slide container" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselSlider" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselSlider" data-slide-to="1"></li>
                    <li data-target="#carouselSlider" data-slide-to="2"></li>
                    <li data-target="#carouselSlider" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <?php $args = array(
                                                'post_type' => 'custom-slides',
                                                'posts_per_page' => 4,
                                            );
                                $slider_query = new WP_Query( $args );
                    //set initial counter to 0 to keep track of active carousel item on load
                            $counter = 0; 
                  if ( $slider_query->have_posts() ) : while ( $slider_query->have_posts() ) : $slider_query->the_post(); 
                ?>
                    <div class="carousel-item <?php echo ($counter == 0) ? 'active' : ''; ?>">

                        <?php the_post_thumbnail(); ?>
                        <div class="carousel-text">
                            <h1>
                                <?php the_title(); ?>
                            </h1>
                            <p>
                                <?php
                                if ( has_excerpt() ) {
                                    the_excerpt();
                                }
                                else {
                                    the_content();
                                } ?>
                            </p>
                        </div>
                    </div>
                    <?php $counter++; ?>
                    <?php endwhile; else : ?>
                    <p>
                        <?php __('No post found'); ?>
                    </p>
                    <?php endif;
                                wp_reset_postdata(); ?>
                </div>
                <a class="carousel-control-prev" href="#carouselSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
