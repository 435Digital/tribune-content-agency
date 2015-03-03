<?php
// Add Shortcode
function loop_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
		'slug' => '',

		), $atts )
	);

	$the_return = '';

	// Code
	//give this to hibba and ryan as a present
	//$sc_query = new  WP_Query( array( 'taxonomy' => 'product_cat', 'term' => $atts['slug'],'post_type'=> array('article') ) );

	$term = get_term_by('slug', $atts['slug'], 'product_cat');
	$term_id = $term->term_id;
	$taxonomy_name = 'product_cat';
	$termchildren = get_term_children( $term_id, $taxonomy_name );

	

	foreach ( $termchildren as $child ) {				
				$child_term = get_term_by( 'id', $child, $taxonomy_name );

				$logo_url = get_field('product_cat_logo', $child_term);

				$holder = $the_return;

				if($term_id==$child_term->parent){

				$the_return = $holder.'<a href="' . get_term_link( $child, $taxonomy_name ) . '" class="sc-loop"><img src="'.$logo_url.'" class="sc-loop-logo">' .$child_term->name .'<a>';
				
				}
			}

		return $the_return;
}
add_shortcode( 'loop', 'loop_shortcode' ); ?>