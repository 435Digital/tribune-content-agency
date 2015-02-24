<?php 
add_action( 'widgets_init', 'my_register_sidebars' );

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


/*function arphabet_widgets_init() {

  register_sidebar( array(
    'name'          => 'Home right sidebar',
    'id'            => 'home_right_1',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );*/

/*function wpsites_before_post_widget( $content ) {


  if ((get_post_type()==='article') && is_single() && is_active_sidebar( 'before-post' ) && is_main_query() ) {
    dynamic_sidebar('before-post');
  }else{
    echo 'This is not working';
  }
  return $content;
}

add_filter( 'the_content', 'wpsites_before_post_widget' );*/

?>