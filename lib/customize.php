<?php
/**
 * Genesis Sample.
 *
 * This file adds the Customizer additions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_action( 'customize_register', 'genesis_sample_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function genesis_sample_customizer_register( $wp_customize ) {

	$appearance = genesis_get_config( 'appearance' );

	// ERC 2023
	$wp_customize->add_panel(
		'erc_pro_settings', array(
			'description' => __( 'Customize the ERC Pro Theme.', 'breakthrough-pro' ),
			'priority'    => 80,
			'title'       => __( 'ERC Pro Settings', 'breakthrough-pro' ),
		)
	);


	// Image Settings section.
	$wp_customize->add_section(
		'erc_pro_image_settings', array(
			'description' => sprintf( '<strong>%s</strong>', __( 'Modify the images displayed on the front page, the default image shown on inside pages, and the footer image. The recommended image size is 1600px wide by 420px tall. Larger images will be cropped to that size.', 'breakthrough-pro' ) ),
			'title'       => __( 'Image Settings', 'breakthrough-pro' ),
			'panel'       => 'erc_pro_settings',
		)
	);

	// Front Page Image 1.
	$wp_customize->add_setting(
		'erc_pro_front_page_image_1', array(
			'default'           => erc_pro_get_default_front_page_image_1(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'erc_pro_front_page_image_1', array(
				'description' => __( 'Select an image for the hero section of the front page.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 1', 'breakthrough-pro' ),
				'section'     => 'erc_pro_image_settings',
				'settings'    => 'erc_pro_front_page_image_1',
			)
		)
	);

	// Front Page Image 2.
	$wp_customize->add_setting(
		'erc_pro_front_page_image_2', array(
			'default'           => erc_pro_get_default_front_page_image_2(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'erc_pro_front_page_image_2', array(
				'description' => __( 'Select an image to appear if the Front Page 1, Front Page 2 or Front Page 3 sections are in use.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 2', 'breakthrough-pro' ),
				'section'     => 'erc_pro_image_settings',
				'settings'    => 'erc_pro_front_page_image_2',
			)
		)
	);

	// Front Page Image 3.
	$wp_customize->add_setting(
		'erc_pro_front_page_image_3', array(
			'default'           => erc_pro_get_default_front_page_image_3(),
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'erc_pro_front_page_image_3', array(
				'description' => __( 'Select an image to appear if the Front Page 4 or Front Page 5 sections are in use.', 'breakthrough-pro' ),
				'label'       => __( 'Front Page Image 3', 'breakthrough-pro' ),
				'section'     => 'erc_pro_image_settings',
				'settings'    => 'erc_pro_front_page_image_3',
			)
		)
	);

	$wp_customize->add_setting(
		'genesis_sample_link_color',
		[
			'default'           => $appearance['default-colors']['link'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_sample_link_color',
			[
				'description' => __( 'Change the color of post info links and button blocks, the hover color of linked titles and menu items, and more.', 'genesis-sample' ),
				'label'       => __( 'Link Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'genesis_sample_link_color',
			]
		)
	);

	$wp_customize->add_setting(
		'genesis_sample_accent_color',
		[
			'default'           => $appearance['default-colors']['accent'],
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_sample_accent_color',
			[
				'description' => __( 'Change the default hover color for button links, menu buttons, and submit buttons. The button block uses the Link Color.', 'genesis-sample' ),
				'label'       => __( 'Accent Color', 'genesis-sample' ),
				'section'     => 'colors',
				'settings'    => 'genesis_sample_accent_color',
			]
		)
	);

	$wp_customize->add_setting(
		'genesis_sample_logo_width',
		[
			'default'           => 350,
			'sanitize_callback' => 'absint',
			'validate_callback' => 'genesis_sample_validate_logo_width',
		]
	);

	// Add a control for the logo size.
	$wp_customize->add_control(
		'genesis_sample_logo_width',
		[
			'label'       => __( 'Logo Width', 'genesis-sample' ),
			'description' => __( 'The maximum width of the logo in pixels.', 'genesis-sample' ),
			'priority'    => 9,
			'section'     => 'title_tagline',
			'settings'    => 'genesis_sample_logo_width',
			'type'        => 'number',
			'input_attrs' => [
				'min' => 100,
			],

		]
	);

}

/**
 * Displays a message if the entered width is not numeric or greater than 100.
 *
 * @param object $validity The validity status.
 * @param int    $width The width entered by the user.
 * @return int The new width.
 */
function genesis_sample_validate_logo_width( $validity, $width ) {

	if ( empty( $width ) || ! is_numeric( $width ) ) {
		$validity->add( 'required', __( 'You must supply a valid number.', 'genesis-sample' ) );
	} elseif ( $width < 100 ) {
		$validity->add( 'logo_too_small', __( 'The logo width cannot be less than 100.', 'genesis-sample' ) );
	}

	return $validity;

}
