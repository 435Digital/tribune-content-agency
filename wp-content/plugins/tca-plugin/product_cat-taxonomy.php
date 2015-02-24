<?php
if (!function_exists('product_cat'))
	{
	function product_cat()
		{
		$a = array(
			'name' => _x('Product Catgories', 'Taxonomy General Name', 'text_domain') ,
			'singular_name' => _x('Product Category', 'Taxonomy Singular Name', 'text_domain') ,
			'menu_name' => __('Product Categories', 'text_domain') ,
			'all_items' => __('All Product Categories', 'text_domain') ,
			'parent_item' => __('Parent Cateogry', 'text_domain') ,
			'parent_item_colon' => __('Parent Category:', 'text_domain') ,
			'new_item_name' => __('New Product Category', 'text_domain') ,
			'add_new_item' => __('Add New Product Category', 'text_domain') ,
			'edit_item' => __('Edit Product Category', 'text_domain') ,
			'update_item' => __('Update Product Category', 'text_domain') ,
			'separate_items_with_commas' => __('Separate Product Categories with commas', 'text_domain') ,
			'search_items' => __('Search Product Categories', 'text_domain') ,
			'add_or_remove_items' => __('Add or Remove Product Categories', 'text_domain') ,
			'choose_from_most_used' => __('Choose from the most used Product Categories', 'text_domain') ,
			'not_found' => __('Not Found', 'text_domain') ,
		);
		$b = array(
			'labels' => $a,
			'hierarchical' => true,
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
		);
		register_taxonomy('product_cat', array(
			'post',
			' article',
			'page'
		) , $b);
		}

	add_action('init', 'product_cat', 0);
	} ?>