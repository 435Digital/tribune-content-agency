<?php 
			

		$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;
		$q_articles = new WP_Query( array( 
			'posts_per_page' => 6,
			'post_type' => 'article',
			'taxonomy' => $taxonomy,
			'term' => $slug,
			'paged' => $paged_a

		) );



		if($q_articles->have_posts()==1){

			$x = 0;

			$img = true;

			while ( $q_articles->have_posts() ) :  $q_articles->the_post();

				if($x == 6){

					echo '<br>---</br>end<br>---</br>';
					break;

				}else{
					
					if ( has_post_thumbnail() ) {

					}else{
						$img = false;
					}

					echo get_the_title().'<br>---</br>';
					$x++;
				}
			endwhile;

			if($img == true){
				echo '<br>HAS IMAGES<br>';
			}else{
					echo '<br>NO IMAGES<br>';
			}

			echo'<br>ARTICLES<br>';

			while ( $q_articles->have_posts() ) :  $q_articles->the_post();

				 echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';

			endwhile;

			echo get_next_posts_link( __( '>>Read More' ) );

			wp_reset_query();
		}

?>