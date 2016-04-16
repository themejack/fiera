<?php
/**
 * Fiera Theme Customizer
 *
 * @package Fiera
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fiera_customize_register( $wp_customize ) {
	/**
	 * Customizer additions.
	 */
	require get_template_directory() . '/inc/customizer-functions.php'; // Extra functions.
	require get_template_directory() . '/inc/customizer-controls.php'; // Extra controls.

	// Change site title and tagline controls transport to postMessage.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->add_setting( 'fiera_header_textcolor', array(
		'type' => 'theme_mod',
		'default' => '#ffffff',
		'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( 'fiera_header_textcolor', array(
		'setting' => 'fiera_header_textcolor',
		'section' => 'colors',
		'label' => esc_html__( 'Header text color', 'fiera' ),
		'type' => 'color',
	) );

	/* -------		Layouts 		------- */
	$wp_customize->add_section( 'layouts', array(
		'title' => __( 'Layouts', 'fiera' ),
		'priority' => 40,
	) );

	$sanitize_global_layouts = new Fiera_Sanitize_Select( array( 'none', 'left', 'right' ), 'left' );
	$sanitize_layouts = new Fiera_Sanitize_Select( array( 'disabled', 'none', 'left', 'right' ), 'disabled' );

	$wp_customize->add_setting( 'fiera_global_layout', array(
		'default' => 'left',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_global_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_global_layout', array(
		'label' => __( 'Global', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 1,
	) ) );

	$wp_customize->add_setting( 'fiera_blog_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_blog_layout', array(
		'label' => __( 'Blog', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 3,
	) ) );

	$wp_customize->add_setting( 'fiera_single_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_single_layout', array(
		'label' => __( 'Single', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 4,
	) ) );

	$wp_customize->add_setting( 'fiera_archive_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_archive_layout', array(
		'label' => __( 'Archive', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 5,
	) ) );

	$wp_customize->add_setting( 'fiera_category_archive_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_category_archive_layout', array(
		'label' => __( 'Category archive', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 6,
	) ) );

	$wp_customize->add_setting( 'fiera_search_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_search_layout', array(
		'label' => __( 'Search', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 7,
	) ) );

	$wp_customize->add_setting( 'fiera_404_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_404_layout', array(
		'label' => __( '404', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 8,
	) ) );

	$wp_customize->add_setting( 'fiera_page_layout', array(
		'default' => 'disabled',
		'transport' => 'postMessage',
		'sanitize_callback' => array( $sanitize_layouts, 'callback' ),
	) );

	$wp_customize->add_control( new Fiera_Layout_Control( $wp_customize, 'fiera_page_layout', array(
		'label' => __( 'Default Page', 'fiera' ),
		'section' => 'layouts',
		'layouts' => array(
			'disabled' => array(
				'label' => __( 'Disabled', 'fiera' ),
			),
			'none' => array(
				'label' => __( 'None', 'fiera' ),
			),
			'left' => array(
				'label' => __( 'Left', 'fiera' ),
			),
			'right' => array(
				'label' => __( 'Right', 'fiera' ),
			),
		),
		'priority' => 9,
	) ) );

	$wp_customize->add_section( 'footer', array(
		'title' => 'Footer',
	) );

	$wp_customize->add_setting( 'fiera_footer_content', array(
		'type' => 'theme_mod',
		'default' => '',
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_html',
	) );

	$wp_customize->add_control( 'fiera_footer_content', array(
		'setting' => 'fiera_footer_content',
		'section' => 'footer',
		'label' => esc_html__( 'Content', 'fiera' ),
		'type' => 'textarea',
	) );
}
add_action( 'customize_register', 'fiera_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fiera_customize_preview_js() {
	wp_enqueue_script( 'fiera_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'fiera_customize_preview_js' );
