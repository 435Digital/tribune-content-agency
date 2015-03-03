<?php  add_theme_support( 'menus' );
function register_my_menus() {
  register_nav_menus(
    array(
      'main' => __( 'main' ),
      'top' => __( 'top' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );?>