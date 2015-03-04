<?php

$qo = get_queried_object();
$slug = $qo->slug;

$query = new WP_Query( array( 

		'posts_per_page' => 6,
		'post_type' => 'post',
		'category_name'=>$slug,

		) );

if($query->have_posts()==1){

	echo'<h2 class="part-label f-up f-san-200 font-blue bord-grey-med">News</h2>';

	while ( $query->have_posts() ) : 

		$query->the_post();
		
		$tags = '';

		  foreach(get_the_tags() as $tag) {
		    $tags .= $tag->name . ' '; 
		  }

		  if (!empty($tags)){
		  	$tags='<div class="news-tags f-san-200 font-grey-med">'.$tags.'</div>';
		  }

		  $img = '';
		  $img_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id(), 'thumbnail') );

		  if (!empty($img_url)){
		  	$img .= '<i class="news-img" style="background-image:url('.$img_url.')"></i>';
		  }


		 echo '<a href="'.get_permalink().'" class="column wful news-link">'.$img.$tags.'<h3 class="news-headline font-black f-ser-bold">'.get_the_title().'</h3><div class="news-excerpt font-grey-med f-ser">'.get_the_excerpt().'</div></a>';

	endwhile;

	wp_reset_query();
}

 ?>