<?php

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function epik_customizer_get_default_accent_color() {
	return '#303236';
}

add_action( 'customize_register', 'epik_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function epik_customizer_register() {

	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class Child_Epik_Image_Control extends WP_Customize_Image_Control {

		/**
		 * Constructor.
		 *
		 * If $args['settings'] is not defined, use the $id as the setting ID.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Upload_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct( $manager, $id, $args ) {
			$this->statuses = array( '' => __( 'No Image', 'epik' ) );

			parent::__construct( $manager, $id, $args );

			$this->add_tab( 'upload-new', __( 'Upload New', 'epik' ), array( $this, 'tab_upload_new' ) );
			$this->add_tab( 'uploaded',   __( 'Uploaded', 'epik' ),   array( $this, 'tab_uploaded' ) );

			if ( $this->setting->default )
				$this->add_tab( 'default',  __( 'Default', 'epik' ),  array( $this, 'tab_default_background' ) );

			// Early priority to occur before $this->manager->prepare_controls();
			add_action( 'customize_controls_init', array( $this, 'prepare_control' ), 5 );
		}

		/**
		 * @since 3.4.0
		 * @uses WP_Customize_Image_Control::print_tab_image()
		 */
		public function tab_default_background() {
			$this->print_tab_image( $this->setting->default );
		}

	}

	global $wp_customize;

	$images = apply_filters( 'epik_images', array( '1', '2', '3', '4', '5', '6', '7', '8' ) );

	$wp_customize->add_section( 'epik-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 1050 pixels tall</strong>.', 'epik' ),
		'title'    => __( 'Front Page Background Images', 'epik' ),
		'priority' => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-epik-image', array(
			'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'     => 'option',
		) );

		$wp_customize->add_control( new Child_Epik_Image_Control( $wp_customize, $image .'-epik-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'epik' ), $image ),
			'section'  => 'epik-settings',
			'settings' => $image .'-epik-image',
			'priority' => $image+1,
		) ) );

	}

	$wp_customize->add_setting(
		'epik_accent_color',
		array(
			'default' => epik_customizer_get_default_accent_color(),
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'epik_accent_color',
			array(
				'description' => __( 'Change the default accent color for links, buttons, and more.', 'epik' ),
			    'label'       => __( 'Accent Color', 'epik' ),
			    'section'     => 'colors',
			    'settings'    => 'epik_accent_color',
			)
		)
	);
	
	//* Add front page setting to the Customizer
	$wp_customize->add_section( 'epik_journal_section', array(
	    'title'    => __( 'Front Page Content Settings', 'epik' ),
	    'description' => __( 'Choose if you would like to display the content section below widget sections on the front page.', 'epik' ),
	    'priority' => 75.01,
	));
	
	//* Add front page setting to the Customizer
	$wp_customize->add_setting( 'epik_journal_setting', array(
	    'default'           => 'true',
	    'capability'        => 'edit_theme_options',
	    'type'              => 'option',
	));	

	$wp_customize->add_control( new WP_Customize_Control( 
	    $wp_customize, 'epik_journal_control', array(
			'label'       => __( 'Front Page Content Section Display', 'epik' ),
			'description' => __( 'Show or Hide the content section. The section will display on the front page by default.', 'epik' ),
			'section'     => 'epik_journal_section',
			'settings'    => 'epik_journal_setting',
			'type'        => 'select',
			'choices'     => array(                    
				'false'   => __( 'Hide content section', 'epik' ),
				'true'    => __( 'Show content section', 'epik' ),
			),
	    ))
	);
	
    $wp_customize->add_setting( 'epik_journal_text', array(
		'default'           => __( 'Latest From the Blog', 'epik' ),
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control( 
        $wp_customize, 'epik_journal_text_control', array(
			'label'      => __( 'Journal Section Heading Text', 'epik' ),
			'description' => __( 'Choose the heading text you would like to display above posts on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'epik' ),
			'section'    => 'epik_journal_section',
			'settings'   => 'epik_journal_text',
			'type'       => 'text',
		))
	);	

}
