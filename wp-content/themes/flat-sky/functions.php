<?php
// add any new or customised functions here
add_action( 'wp_enqueue_scripts', 'flat_sky_enqueue_styles' );
function flat_sky_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	// Loads our main stylesheet.
	wp_enqueue_style( 'flat_sky-child-style', get_stylesheet_uri(), array('flat-style') );
}	
	
if ( ! function_exists( 'flat_sky_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function flat_sky_setup() {
	
		$custom_background_support = array(
			'default-color'          => '',
			'default-image'          => get_stylesheet_directory_uri() . '/assets/img/default-background.jpg',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-background', $custom_background_support ); # @link http://codex.wordpress.org/Custom_Backgrounds
		
		load_child_theme_textdomain( 'flat-sky', get_stylesheet_directory() . '/languages' );

	}
endif;
add_action( 'after_setup_theme', 'flat_sky_setup' );


/**
 * Notice in Customize to announce the theme is not maintained anymore
 */
function flat_sky_customize_register( $wp_customize ) {

	require_once get_stylesheet_directory() . '/class-ti-notify.php';

	$wp_customize->register_section_type( 'Ti_Notify' );

	$wp_customize->add_section(
		new Ti_Notify(
			$wp_customize,
			'ti-notify',
			array( /* translators: Link to the recommended theme */
				'text'     => sprintf( __( 'This child theme is not maintained anymore, consider using the parent theme %1$s or check-out our awesome blogging theme: %2$s.','flat-sky' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=flat' ) . '">%s</a>', 'Flat' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=amadeus' ) . '">%s</a>', 'Amadeus' ) ),
				'priority' => 0,
			)
		)
	);

	$wp_customize->add_setting( 'flat-sky-notify', array(
		'sanitize_callback' => 'esc_html',
	) );

	$wp_customize->add_control( 'flat-sky-notify', array(
		'label'    => __( 'Notification', 'flat-sky' ),
		'section'  => 'ti-notify',
		'priority' => 1,
	) );
}
add_action( 'customize_register', 'flat_sky_customize_register' );

/**
 * Notice in admin dashboard to announce the theme is not maintained anymore
 */
function flat_sky_admin_notice() {

	global $pagenow;

	if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
		echo '<div class="updated notice is-dismissible"><p>';
		printf( __( 'This child theme is not maintained anymore, consider using the parent theme %1$s or check-out our awesome blogging theme: %2$s.','flat-sky' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=flat' ) . '">%s</a>', 'Flat' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=amadeus' ) . '">%s</a>', 'Amadeus' ) );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'flat_sky_admin_notice', 99 );
