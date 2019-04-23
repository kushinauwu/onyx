<?php
/**
 * Onyx Theme Customizer
 *
 * @package Onyx
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function onyx_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    // add footer text customization settings
    $wp_customize->add_section('footer_settings_section', array(
    'title' => 'Footer'
    ));
    
    $wp_customize->add_setting('text_setting', array('default' => 'Default Text for Footer Section',));
    
    $wp_customize->add_control('text_setting', array(
    'label' => 'Footer Text',
        'section' => 'footer_settings_section',
        'type' => 'textarea',
    ));
    
    // add footer logo settings section
    $wp_customize->add_setting('footer_logo');
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'footer_logo', array(
    'label' => __('Footer Logo', 'onyx'),
        'section' => 'footer_settings_section',
        'settings' => 'footer_logo',
    )));

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'onyx_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'onyx_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'onyx_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function onyx_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function onyx_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function onyx_customize_preview_js() {
	wp_enqueue_script( 'onyx-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'onyx_customize_preview_js' );
