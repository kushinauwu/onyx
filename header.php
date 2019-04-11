<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Onyx
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content">
            <?php esc_html_e( 'Skip to content', 'onyx' ); ?></a>

        <header id="masthead" class="site-header">
            <div class="site-branding">

            </div><!-- .site-branding -->


            <nav id="site-navigation" class="navbar navbar-expand-md navbar-light bg-light main-navigation" role="navigation" style="background-image:url('<?php header_image(); ?>'); width=<?php echo absint( get_custom_header()->width ); ?> height=<?php echo absint( get_custom_header()->height ); ?>">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <?php if ( function_exists( 'the_custom_logo' ) ) {
 the_custom_logo();
} ?>
                    </a>
                    <?php
		wp_nav_menu( array(
			'theme_location'    => 'primary',
			'depth'             => 2,
			'container'         => 'div',
			'container_class'   => 'collapse navbar-collapse',
			'container_id'      => 'bs-example-navbar-collapse-1',
			'menu_class'        => 'nav navbar-nav',
			'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			'walker'            => new WP_Bootstrap_Navwalker(),
		) );
		?>
                </div>
            </nav>
        </header><!-- #masthead -->

        <div id="content" class="site-content">
