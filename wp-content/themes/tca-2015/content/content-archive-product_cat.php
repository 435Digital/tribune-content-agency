<?php 
	//echo '<h1>' .get_category_by_slug('product_cat' ).'</h1>';
	//$cat_id = get_cat_ID();
	$queried_object = get_queried_object(); 
	
	$taxonomy = $queried_object->taxonomy;
	
	$term_id = $queried_object->term_id;
	
	$term = get_term( $term_id, $taxonomy);
	
	$name = $term->name;
	$slug = $term->slug;
	echo '<h1>'.$name.'</h1>';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args= array( 'posts_per_page' => 3,'taxonomy' => 'product_cat', 'term' => $slug,'post_type'=> array('article'), 'total'=> 3,'end_size'=>2,'paged' => $paged);

$pro_cat_loop = new  WP_Query($args);

while ( $pro_cat_loop->have_posts() ) : $pro_cat_loop->the_post();
  $id = get_the_ID();
  $cat = get_the_category($id->ID);
  echo '<h2>';
  echo '<a href="'.get_permalink() .'">';
  the_title();
  echo '</a>';
  echo'</h2>';
  
endwhile;
 /*posts_nav_link(' &bull; ','&laquo; Go forward in time','Go back in time &raquo;');
 wp_reset_query();*/
 
 next_posts_link( 'Older Entries', $pro_cat_loop->max_num_pages );
     previous_posts_link( 'Newer Entries' );//previous_posts_link('&laquo; Previous');
//next_posts_link('More &raquo;');

//$args = array('posts_per_page' => 3,'total'=> 3,'end_size'=>2,'taxonomy' => 'product_cat', 'term' => $slug,'post_type'=> array('article'));
//echo paginate_links( $args );

// $big = 999999999; // need an unlikely integer

// echo paginate_links( array(
// 	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
// 	'format' => '?paged=%#%',
// 	'current' => max( 1, get_query_var('paged') ),
// 	'total' => $the_query->max_num_pages;
// 	'total'=> 3,
// 	'end_size'=>2
// ) );


?>


