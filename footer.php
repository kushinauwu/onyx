<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Onyx
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">

    <nav id="site-navigation" class="navbar navbar-expand-lg navbar-light main-navigation" role="navigation" style="background-image:url('<?php header_image(); ?>'); width=<?php echo absint( get_custom_header()->width ); ?> height=<?php echo absint( get_custom_header()->height ); ?>">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#this-menu" aria-controls="this-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="this-menu">
                <?php
		wp_nav_menu( array(
			'theme_location'    => 'secondary',
			'depth'             => 2,
			'container'         => 'div',
			'container_class'   => 'collapse navbar-collapse',
			'container_id'      => 'this-menu',
			'menu_class'        => 'nav navbar-nav',
			'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			'walker'            => new WP_Bootstrap_Navwalker(),
		) );
		?>
            </div>

            <a class="navbar-brand" href="<?php home_url(); ?>">
                <?php if ( get_theme_mod('footer_logo') ) { ?>
                <img src="<?php echo get_theme_mod( 'footer_logo' ); ?>">
                <?php }
                else { ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/lib/img/footer-logo.png">
                <?php }
                
                ?>
            </a>

        </div>
    </nav>
    <div class="container site-info">
        <?php if ( get_theme_mod( 'text_setting')) :
            ?>
        <p>
            <?php echo get_theme_mod( 'text_setting' ); ?>
        </p>
        <?php endif;  ?>
    </div>


</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
