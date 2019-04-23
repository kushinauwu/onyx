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
            <div id="carouselSlider" class="vertical carousel slide container" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselSlider" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselSlider" data-slide-to="1"></li>
                    <li data-target="#carouselSlider" data-slide-to="2"></li>
                    <li data-target="#carouselSlider" data-slide-to="3"></li>
                </ol>
                <a class="carousel-control-prev" href="#carouselSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
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
                        <?php __('No post found', 'onyx'); ?>
                    </p>
                    <?php endif;
                                wp_reset_postdata(); ?>
                </div>

            </div>
        </div>

        <!-- section to display subpages of the front page's child pages -->
        <div class="page-children container">
            <?php
                $args = array(
                            'post_parent' => $post->ID,
                            'post_type' => 'page',
                            'orderby' => 'menu_order'
                        );
                //args for child pages of main page
                $parent_query = new WP_Query( $args );
                ?>
            <?php while ( $parent_query->have_posts() ) : $parent_query->the_post(); 
                                        $classes = [
                                                    'parent-list',
                                                    'id'=>get_the_ID()
                                                    ];
                            ?>
            <div class="row">
                <div class="col-lg-3 parent-wrapper">
                    <div <?php post_class( $classes ); ?>
                        id="
                        <?php the_ID(); ?>"
                        onmouseover="hoverParent(this.id)"
                        onmouseout="parentMouseOut(this.id)">

                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?></a>

                    </div>
                </div>
                <div class="col-lg-9 children-list">
                    <?php
                            $child_args = array(
                                                'post_parent' => $id,
                                                'post_type' => 'page',
                                                'orderby' => 'menu_order'
                                                );
                    //args for child pages of subpages of homepage
                            $c_query = new WP_Query( $child_args );
                            ?>
                    <div class="child-list">
                        <div class="childgrid">
                            <?php while ( $c_query->have_posts() ) : $c_query->the_post(); 
                                $cid = wp_get_post_parent_id( get_the_ID() );
                                $c_classes = [
                                            $cid.='-child',
                                            'child',
                                            'post_parent',
                                            'inactive'
                                            ];
                                ?>
                            <div <?php post_class( $c_classes ); ?>>
                                <?php the_post_thumbnail(); ?>
                                <p class="childpage-title">
                                    <?php the_title(); ?>
                                </p>
                                <p class="childpage-excerpt">
                                    <?php the_excerpt(); ?>
                                </p>
                            </div>

                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
