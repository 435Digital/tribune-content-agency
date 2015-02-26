<?php 
			
		$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;

		$q_articles = new WP_Query( array( 
			'posts_per_page' => 6,
			'post_type' => 'article',
			'paged' => $paged_a

		) );

			$loop_prod_type='text';

			$the_loop_return ='';

			//if item is image break

			//else add output to the return;

			//if $loop_prod_image is image
			//clear the return
			//while loop with different parameters

			while ( $q_articles->have_posts() ) :  $q_articles->the_post();

					foreach (get_the_terms( get_the_id(),'product_cat') as $term) {
						
						if (get_field('cat-type',$term)=='product'){
							$the_loop_return .= '<a href="'.get_the_permalink().'" class="topic-article-loop-link f-ser link-black"><span class="topic-first-line font-grey-med f-up">'.$term->name.' '.get_the_date('m/d/Y').'</span>'.get_the_title().'</a>';						
						}

					}

			endwhile;

			echo '<br>ARTICLES<br>'.$the_loop_return;

			echo get_next_posts_link( __( '>>More Articles' ) );

			wp_reset_query();
			


?>