<?php
function mytheme_customize_register( $wp_customize ) {
//All our sections, settings, and controls will be added here

//echo get_theme_mod('logo_setting');
	$wp_customize->add_setting( 'logo_setting' , array(
	    'transport'   => 'refresh',
	));

	$wp_customize->add_section( 'logo_section' , array(
		'title'      => __( 'Logo', 'mytheme' ),
	    'priority'   => 30,
	));

	$wp_customize->add_control(new WP_Customize_Image_Control(
	    $wp_customize,'logo',array(
	       	'label'      => __( 'Upload a logo', 'mytheme' ),
			'section'    => 'logo_section',
			'settings'   => 'logo_setting',
			'extensions' => array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
		)));

//echo get_theme_mod('footer_img_setting');
	$wp_customize->add_setting( 'footer_img_setting' , array(
	    'transport'   => 'refresh',
	));

	$wp_customize->add_section( 'footer_img_section' , array(
		'title'      => __( 'footer image', 'mytheme' ),
	    'priority'   => 30,
	));

	$wp_customize->add_control(new WP_Customize_Image_Control(
	    $wp_customize,'footer_img',array(
	       	'label'      => __( 'Upload a footer image', 'mytheme' ),
			'section'    => 'footer_img_section',
			'settings'   => 'footer_img_setting',
			'extensions' => array( 'jpg', 'jpeg', 'gif', 'png', 'svg' ),
		)));

}
add_action( 'customize_register', 'mytheme_customize_register' );
?>