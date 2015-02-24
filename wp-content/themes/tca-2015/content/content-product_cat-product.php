<?php  

$queried_object = get_queried_object(); 
	
	$taxonomy = $queried_object->taxonomy;
	
	$term_id = $queried_object->term_id;
	
	$term = get_term( $term_id, $taxonomy);
	
	$name = $term->name;
	$slug = $term->slug;
	echo '<h1>'.$name.'</h1>';

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$args= array( 'post_type' => 'article', 'posts_per_page' => 3,'paged' => $paged );
$loop = new WP_Query( array( 'post_type' => 'article', 'posts_per_page' => 3,'paged' => $paged) ); 
echo get_terms('product_cat');

$terms = get_terms( 'product_cat');

// getting the name of the catogory, if statement based on whether or not it has parents
 /*foreach ( $terms as $term ) {
  	if($term->parent > 0){
      echo '<h1>' . $term->name . '</h1>';

       }
   }*/
while ($loop->have_posts()) {
	$loop->the_post();
	
	
	$date = get_the_date('Y-m-d');
	echo  $date;
	echo '<a href="' . get_permalink() . '" >';
	
	echo '<h3>';
	the_title();
	echo '</h3>';
	//$content = get_the_content();
	$content = get_the_content(); 
	echo '<p>'.mb_strimwidth($content, 0, 300).'</p>';	
	echo "</a>";
	//echo  $date;
	}
	posts_nav_link(' &bull; ','&laquo; Go forward in time','Go back in time &raquo;');
 	wp_reset_query();
 
 	next_posts_link( 'Older Entries', $pro_cat_loop->max_num_pages );
     previous_posts_link( 'Newer Entries' );

	?>