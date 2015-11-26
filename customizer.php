<?php
/**
 * Srizon Theme Customizer. (Include this file from your theme's functions.php
 *
 * @package srizon_2016
 */

require_once dirname( __FILE__ ) . '/controls/srizon-control-google-font.php';
require_once dirname( __FILE__ ) . '/controls/srizon-control-slider.php';
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function srizon_2016_customize_register( $wp_customize ) {
	// ----------------------------------------
	// Add a new section called 'Test Controls'
	// ----------------------------------------
	$wp_customize->add_section( 'srizon_test_section', array(
		'title'    => __( 'Test Controls' ),
		'priority' => '20',
	) );

	// -----------------------------------------------
	// Add a settings for Google Font Control (below)
	// -----------------------------------------------
	$wp_customize->add_setting( 'srizon_body_font', array(
		'default' => 'Open Sans',
	) );

	// --------------------
	// Google Font Control
	// --------------------
	$wp_customize->add_control( new Srizon_Control_Google_Font(
		$wp_customize,
		'srizon_body_font',
		array(
			'label'    => __( 'Body Font' ),
			'section'  => 'srizon_test_section',
			'settings' => 'srizon_body_font',
		)
	) );

	// ------------------------------------------------------------------------------------------
	// Sample head section for this changes to take effect:
	// sample-output/google-font-header.php
	// ------------------------------------------------------------------------------------------

	// -----------------------------------------
	// Add a settings for Slider Control (below)
	// -----------------------------------------
	$wp_customize->add_setting( 'srizon_body_font_size', array(
		'default' => '16',
	) );

	// --------------
	// Slider Control
	// --------------
	$wp_customize->add_control( new Srizon_Control_Slider(
		$wp_customize,
		'srizon_body_font_size',
		array(
			'label'       => __( 'Body Font Size' ),
			'description' => __( 'Base/Body font size in px' ),
			'section'     => 'srizon_test_section',
			'settings'    => 'srizon_body_font_size',
		),
		array(
			'step' => 1,
			'min' => 10,
			'max' => 30,
		)
	) );

	// -----------------------------------------
	// Add a settings for Slider Control (below)
	// -----------------------------------------
	$wp_customize->add_setting( 'srizon_h1_font_size', array(
		'default' => '22',
	) );

	// --------------
	// Slider Control
	// --------------
	$wp_customize->add_control( new Srizon_Control_Slider(
		$wp_customize,
		'srizon_h1_font_size',
		array(
			'label'       => __( 'H1 Font Size' ),
			'description' => __( 'H1 font size in px' ),
			'section'     => 'srizon_test_section',
			'settings'    => 'srizon_h1_font_size',
		),
		array(
			'step' => 1,
			'min' => 10,
			'max' => 40,
		)
	) );
}

add_action( 'customize_register', 'srizon_2016_customize_register' );

