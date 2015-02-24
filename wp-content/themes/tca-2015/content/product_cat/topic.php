<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;  

if(1 == $paged) {
  echo 'This is first page';

$queried_object = get_queried_object(); 
	
	$taxonomy = $queried_object->taxonomy;
	
	$term_id = $queried_object->term_id;
	
	$term = get_term( $term_id, $taxonomy);
	
	$name = $term->name;
	$slug = $term->slug;

$type='article';
query_posts(  array (  
   'posts_per_page' => 3,
   'post_type' => $type,
   'total'=> 3, 
   'taxonomy' => $taxonomy,
   'order' => 'ASC', 
   'term' => $slug,
   'orderby' =>'menu_order', 
   'end_size'=>2,
   'paged' => $paged ) );

$list = ' ';   

while ( have_posts() ) { the_post();
$img = '';
$img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );

if(!empty($img_url[0])){
$img = '<a href="'. get_permalink() .'"><img src="'.$img_url[0].'"></a>';
}
   $list .= '<article class="blog-big-post post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized et_pb_post">

'.$img.'

<h2>
<a href="'.get_permalink().'">
'.get_the_title().'
</a>
</h2>';
	

}
echo'<a href="'.get_permalink().'" class="blog-big-button f-up f-serif bord-grey-lite link-grey-dark f-center">Read More</a>';
}else{
	echo 'This is not working if this message is showing up on the first page';
}

/*echo
'<div class="blog-big clearfix">' 
//. $list 
//. '<div class="nav-previous link-accent f-serif f-up">' . get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts' ) ) . '</div>'
//. '<div class="nav-next link-accent f-serif f-up">' . get_previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>' ) ) . '</div>'
. '</div>' ;
wp_reset_query();*/

?>