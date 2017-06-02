<?php
/* 
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'epik_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function epik_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'epik_accent_color', epik_customizer_get_default_accent_color() );

	$opts = apply_filters( 'epik_images', array( '1', '2', '3', '4', '5', '6', '7', '8' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-epik-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.front-page-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( epik_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		a,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.entry-title a:hover,
		.image-section a:hover,
		.image-section .featured-content .entry-title a:hover,
		.site-footer a:hover {
			color: %1$s;
		}

		.genesis-nav-menu .sub-menu a:hover,
		.genesis-nav-menu .sub-menu li.current-menu-item > a,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button,
		.widget .button,
		.front-page-2 .image-section,
		.portfolio .more-link,
		.site-header,
		.front-page-2,
		.front-page-5,
		.footer-widgets,
		.plan .popular  {
			background-color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.front-page input:focus,
		.front-page textarea:focus,
		.widget .button {
			border-color: %1$s;
		}
		', $color ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
