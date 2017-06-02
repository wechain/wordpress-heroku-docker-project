<?php
/**
 * This file adds the Home Page to the Epik Theme.
 *
 * @author Appfinite
 * @package Epik
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'epik_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function epik_front_page_genesis_meta() {

	if ( is_active_sidebar( 'slider-wide' ) || is_active_sidebar( 'slider' ) || is_active_sidebar( 'welcome-wide' ) || is_active_sidebar( 'welcome-feature-1' ) || is_active_sidebar( 'welcome-feature-2' ) || is_active_sidebar( 'welcome-feature-3' ) || is_active_sidebar( 'home-feature-top' ) || is_active_sidebar( 'home-feature-1' ) || is_active_sidebar( 'home-feature-2' ) || is_active_sidebar( 'home-feature-3' ) || is_active_sidebar( 'home-feature-4' ) || is_active_sidebar( 'home-feature-5' ) || is_active_sidebar( 'home-feature-6' ) || is_active_sidebar( 'home-feature-7' ) || is_active_sidebar( 'home-feature-8' ) || is_active_sidebar( 'home-feature-9' ) || is_active_sidebar( 'home-feature-10' ) || is_active_sidebar( 'home-feature-11' ) || is_active_sidebar( 'home-feature-12' ) || is_active_sidebar( 'home-feature-13' ) || is_active_sidebar( 'home-feature-14' ) ) {

		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'epik_enqueue_epik_script' );
		function epik_enqueue_epik_script() {

			//wp_enqueue_script( 'epik-script', get_bloginfo( 'stylesheet_directory' ) . '/js/home.js', array( 'jquery' ), '1.0.0' );
			wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
			wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );

		}
		
		//* Enqueue parallax script
		add_action( 'wp_enqueue_scripts', 'aspire_enqueue_parallax_script' );
		function aspire_enqueue_parallax_script() {

			if ( ! wp_is_mobile() ) {

				wp_enqueue_script( 'parallax-script', get_bloginfo( 'stylesheet_directory' ) . '/js/parallax.js', array( 'jquery' ), '1.0.0' );

			}

		
		}
		

		//* Add front-page body class
		add_filter( 'body_class', 'epik_body_class' );
		function epik_body_class( $classes ) {

   			$classes[] = 'front-page';
  			return $classes;

		}

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		
		//* Add homepage widgets
		add_action( 'genesis_after_header', 'epik_home_loop_helper_top' );
		add_action( 'genesis_after_header', 'epik_home_loop_helper_welcome' );		
		add_action( 'genesis_after_header', 'epik_home_loop_helper_middle' );
		add_action( 'genesis_after_header', 'epik_home_loop_helper_mid_bottom' );
		add_action( 'genesis_after_header', 'epik_home_loop_helper_bottom' );
		
		$journal = get_option( 'epik_journal_setting', 'true' );
		
				if ( $journal === 'true' ) {
		
					//* Add opening markup for blog section
					add_action( 'genesis_before_loop', 'epik_front_page_blog_open' );
		
					//* Add closing markup for blog section
					add_action( 'genesis_after_loop', 'epik_front_page_blog_close' );
		
				} else {
				
					//* Force full width content layout
					add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
		
					//* Remove the default Genesis loop
					remove_action( 'genesis_loop', 'genesis_do_loop' );
		
					//* Remove .site-inner
					add_filter( 'genesis_markup_site-inner', '__return_null' );
					add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
					add_filter( 'genesis_markup_content', '__return_null' );
					remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		
				}

	}
	
}


/**
 * Display widget content for "Slider Wide" and "Slider" sections.
 *
 */
function epik_home_loop_helper_top() {
	
	genesis_widget_area( 'slider-wide', array(
		'before' => '<div class="slider-wide"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap">',
		'after' => '</div></div></div></div>',
	) );
			
	genesis_widget_area( 'slider', array(
		'before' => '<div class="slider"><div class="front-page-1"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap">',
		'after' => '</div></div></div></div></div>',
	) );
		
}


/**
 * Display widget content for the "Welcome-wide", "Welcome Feature 1", "Welcome Feature 2", and "Welcome Feature 3" sections.
 *
 */
function epik_home_loop_helper_welcome() {

	if ( is_active_sidebar( 'welcome-wide' ) || is_active_sidebar( 'welcome-feature-1' ) || is_active_sidebar( 'welcome-feature-2' ) || is_active_sidebar( 'welcome-feature-3' ) ) {
 
		echo '<div class="welcome front-page-2"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect">';
		
		if ( is_active_sidebar( 'welcome-wide' ) ) {
		
			genesis_widget_area( 'welcome-wide', array(
				'before' => '<div class="welcome-wide"><div class="wrap">',
				'after' => '</div></div>',
			) );
			
		}
			
		if ( is_active_sidebar( 'welcome-feature-1' ) || is_active_sidebar( 'welcome-feature-2' ) || is_active_sidebar( 'welcome-feature-3' ) ) {
			
		echo '<div class="welcome-features"><div class="wrap">';
			
			genesis_widget_area( 'welcome-feature-1', array(
				'before' => '<div class="welcome-feature-1">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'welcome-feature-2', array(
				'before' => '<div class="welcome-feature-2">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'welcome-feature-3', array(
				'before' => '<div class="welcome-feature-3">',
				'after' => '</div>',
			) );				
		
		echo '</div><!-- end .wrap --></div><!-- end .welcome-features -->';
		
		}
		
		echo '</div></div></div><!-- end .welcome -->';

	}
		
}


/**
 * Display widget content for "Home Feature 1, 2, 3, and 4" sections.
 *
 */
function epik_home_loop_helper_middle() {

	if ( is_active_sidebar( 'home-feature-top' ) || is_active_sidebar( 'home-feature-1' ) || is_active_sidebar( 'home-feature-2' ) ) {								
		
		echo '<div class="home-feature-bg-alt hf1"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap">';
		
			genesis_widget_area( 'home-feature-top', array(
				'before' => '<div class="home-feature-top"><div class="wrap">',
				'after' => '</div></div>',
			) );
			
			genesis_widget_area( 'home-feature-1', array(
				'before' => '<div class="home-feature-1">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'home-feature-2', array(
				'before' => '<div class="home-feature-2">',
				'after' => '</div>',
			) );									
		
		echo '</div><!-- end .wrap --></div></div><!-- end .home-feature-bg-alt -->';
				
	}	
	
	genesis_widget_area( 'home-feature-3', array(
		'before' => '<div class="home-feature-bg hf3 front-page-3"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-3">',
		'after' => '</div></div></div></div></div>',
	) );
	
	genesis_widget_area( 'home-feature-4', array(
		'before' => '<div class="home-feature-bg-alt hf4"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-4">',
		'after' => '</div></div></div></div>',
	) );
	
}


/**
 * Display widget content for "Home Feature 5, 6, 7, and 8" sections.
 *
 */
function epik_home_loop_helper_mid_bottom() {

	genesis_widget_area( 'home-feature-5', array(
		'before' => '<div class="home-feature-bg-dark hf5 front-page-5"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-5">',
		'after' => '</div></div></div></div></div>',
	) );
	
	genesis_widget_area( 'home-feature-6', array(
		'before' => '<div class="home-feature-bg-alt hf6"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-6">',
		'after' => '</div></div></div></div>',
	) );
			
	genesis_widget_area( 'home-feature-7', array(
		'before' => '<div class="home-feature-bg hf7 front-page-7"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-7">',
		'after' => '</div></div></div></div></div>',
	) );
	
	genesis_widget_area( 'home-feature-8', array(
		'before' => '<div class="home-feature-bg-alt hf8"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-8">',
		'after' => '</div></div></div></div>',
	) );
	
}


/**
 * Display widget content for the "Home Feature 9, 10, 11, 12, 13, and 14" sections.
 *
 */
function epik_home_loop_helper_bottom() {

	if ( is_active_sidebar( 'home-feature-9' ) || is_active_sidebar( 'home-feature-10' ) || is_active_sidebar( 'home-feature-11' ) || is_active_sidebar( 'home-feature-12' ) || is_active_sidebar( 'home-feature-13' ) ) {								
	
		echo '<div class="home-feature-bg hf9 front-page-8"><div class="image-section"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap">';
		
			genesis_widget_area( 'home-feature-9', array(
				'before' => '<div class="home-feature-9">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'home-feature-10', array(
				'before' => '<div class="home-feature-10">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'home-feature-11', array(
				'before' => '<div class="home-feature-11">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'home-feature-12', array(
				'before' => '<div class="home-feature-12">',
				'after' => '</div>',
			) );
			
			genesis_widget_area( 'home-feature-13', array(
				'before' => '<div class="home-feature-13">',
				'after' => '</div>',
			) );
					
		echo '</div></div></div><!-- end .wrap --></div><!-- end .home-feature-bg -->';	
	
	}
	
	genesis_widget_area( 'home-feature-14', array(
		'before' => '<div class="home-feature-bg-alt hf14"><div class="flexible-widgets widget-area fadeup-effect"><div class="wrap"><div class="home-feature-14">',
		'after' => '</div></div></div></div>',
	) );

}

//* Add opening markup for blog section
function epik_front_page_blog_open() {

	$journal_text = get_option( 'epik_journal_text', __( 'Latest From the Blog', 'epik' ) );
	
	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '<div id="journal" class="widget-area"><div class="wrap">';

		if ( ! empty( $journal_text ) ) {

			echo '<h2 class="widgettitle widget-title journal-title">' . $journal_text . '</h2><hr>';

		}

	}

}

//* Add closing markup for blog section
function epik_front_page_blog_close() {

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '</div></div>';

	}

}

genesis();