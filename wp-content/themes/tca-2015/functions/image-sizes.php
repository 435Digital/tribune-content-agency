<?php
/*setup custom image sizes for different devices*/
  function lc_custom_image_setup () {
    add_theme_support( 'post-thumbnails' );
    add_image_size('w240', 240, 9999);
    add_image_size('w320', 320, 9999);
    add_image_size('w480', 480, 9999);
    add_image_size('w640', 640, 9999);
    add_image_size('w800', 800, 9999);
    add_image_size('w1024', 1024, 9999);
    add_image_size('w1920', 1920, 9999);
    add_filter( 'image_size_names_choose', 'lc_insert_custom_image_sizes' );
  }
  add_action( 'after_setup_theme', 'lc_custom_image_setup' );
?>