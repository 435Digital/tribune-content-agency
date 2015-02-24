<?php

$qo = get_queried_object();
$slug = $qo->slug;
echo 'hello';
$query = new WP_Query( array( 

		'posts_per_page' => 6,
		'post_type' => 'post',
		'category_name'=>$slug,

		) );

if($query->have_posts()==1){

	echo'<br>NEWS<br>';

	while ( $query->have_posts() ) : 

		$query->the_post();

		 echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';

	endwhile;

	wp_reset_query();
}

 ?>