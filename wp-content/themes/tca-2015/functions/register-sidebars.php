<?php add_action( 'widgets_init', 'my_register_sidebars' );

function my_register_sidebars() {

if (function_exists('register_sidebar')) {
  register_sidebar(array(
	    'name'=> 'premium_content',
	    'id' => 'premium_content',
	    'before_widget' => '<li id="%1$s" class="widget %2$s">',
	    'after_widget' => '</li>',
	    'before_title' => '<h2>',
	    'after_title' => '</h2>',
  	));

    register_sidebar(array(
	    'name'=> 'footer',
	    'id' => 'footer',
	    'before_widget' => '',
	    'after_widget' => '',
	    'before_title' => '',
	    'after_title' => '',
  	));

	register_sidebar(array(
		'name'=> 'top-bar',
		'id' => 'top-bar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar(array(
	    'name'=> 'custom_tax_widget',
	    'id' => 'custom_tax_widget',
	    'before_widget' => '<li id="%1$s" class="widget %2$s">',
	    'after_widget' => '</li>',
	    'before_title' => '<h2>',
	    'after_title' => '</h2>',
  	));

}
}
?>