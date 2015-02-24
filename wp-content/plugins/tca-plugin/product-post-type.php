<?php 
if ( ! function_exists('article') ) {

// Register Custom Post Type
function article() {

	$labels = array(
		'name'                => _x( 'Articles', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Article', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Article', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Article', 'text_domain' ),
		'all_items'           => __( 'All Articles', 'text_domain' ),
		'view_item'           => __( 'View Article', 'text_domain' ),
		'add_new_item'        => __( 'Add New Article', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Article', 'text_domain' ),
		'update_item'         => __( 'Update Article', 'text_domain' ),
		'search_items'        => __( 'Search Article', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'taxonomies'          => array( 'product_cat' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'article', $args );

}

// Hook into the 'init' action
add_action( 'init', 'article', 0 );

}
?>