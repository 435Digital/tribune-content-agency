<?php
//allow svg
  function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter('upload_mimes', 'cc_mime_types');

/*returns an svg data uri*/
  function svg64($in){
    $uri= base64_encode($in);
    $the_return = 'data:image/svg+xml;base64,'.$uri;
    return $the_return;
  }

//get rid of garbage
    remove_action ('wp_head', 'rsd_link');
    remove_action( 'wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action( 'wp_head', 'wp_shortlink_wp_head');
    function remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }
    add_action('widgets_init', 'remove_recent_comments_style');
    add_action('widgets_init', 'remove_recent_comments_style');

//remove p tags from images
  function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  }

add_filter('the_content', 'filter_ptags_on_images');

/*enqueue scripts*/
  function enq_scripts(){
    wp_enqueue_script('main-js', get_template_directory_uri().'/js/main.js', null,'',true);
  }
  add_action('init', 'enq_scripts');
//add support for post thumbnails
add_theme_support( 'post-thumbnails' );



// sanitize shortcodes

function san_shortcode( $string ){$patterns = array('#^\s*</p>#','#<p>\s*$#');
    return preg_replace($patterns, '', $string);
}


//convert colors to rgb
  function hex2rgba( $colour,$a = '1') {
          if ( $colour[0] == '#' ) {
                  $colour = substr( $colour, 1 );
          }
          if ( strlen( $colour ) == 6 ) {
                  list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
          } elseif ( strlen( $colour ) == 3 ) {
                  list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
          } else {
                  return false;
          }
          $r = hexdec( $r );
          $g = hexdec( $g );
          $b = hexdec( $b );
          $c = ',';
          return 'rgba('.$r.$c.$g.$c.$b.$c.$a.')';

  }



//get the service color
      function service_color($parent){
        // start from the current term
        while(get_field('cat-type', $parent) != 'service'){
            $parent = $parent->parent;
          }

        $ser_col = get_field('product_cat_color', $parent);

        return $ser_col;
      }



include 'functions/customizer.php';
include 'functions/image-sizes.php';
include 'functions/register-menus.php';
include 'functions/register-sidebars.php';
include 'functions/res-img.php';
include 'functions/shortcode-iframe.php';
include 'functions/shortcode-panel.php';
include 'functions/shortcode-column.php';
include 'functions/shortcode-loop.php';
include 'functions/shortcode-topics.php';
include 'images/icons.php';
//include 'functions/the_tax_widget.php';
include 'functions/shortcode-also.php';


?>