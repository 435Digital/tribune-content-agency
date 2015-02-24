<?php 
			

		$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;
		$q_articles = new WP_Query( array( 
			'posts_per_page' => 6,
			'post_type' => 'article',
			'taxonomy' => $taxonomy,
			'term' => $slug,
			'paged' => $paged_a

		) );
			$queried_object = get_queried_object(); 
			
			$taxonomy = $queried_object->taxonomy;
			
			$term_id = $queried_object->term_id;
			
			$terms = get_terms( 'product_cat');

			echo'<br>ARTICLES<br>';

			$loop_prod_type='text';

			$the_loop_return;

			//if item is image break

			//else add output to the return;

			//if $loop_prod_image is image
			//clear the return
			//while loop with different parameters

			while ( $q_articles->have_posts() ) :  $q_articles->the_post();
				 
				  foreach ( $terms as $term ) {

				  		

				  		$product_type=get_field('product_type',$term);

				    	if(get_field('cat-type', $term) =='product'){

				    		if ($product_type=='Image') {

						 		$loop_prod_type ='image';

						 		break;
						 		
						 	}
						}
					}

					$the_loop_return .= '<a href="'.get_permalink().'">'.get_the_title().'</a>';

			endwhile;




			echo $the_loop_return;

			//echo $loop_prod_type;

			echo get_next_posts_link( __( '>>Read More' ) );

			wp_reset_query();
			


?>