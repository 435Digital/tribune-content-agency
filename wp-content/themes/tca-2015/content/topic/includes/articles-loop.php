<?php 
			
		$paged_a = get_query_var('paged') ? get_query_var('paged') : 1;

		$q_articles = new WP_Query( array( 
			'posts_per_page' => 6,
			'post_type' => 'article',
			'paged' => $paged_a

		) );

			$loop_prod_type='Text';

			$the_loop_return ='';

			//if item is image break

			//else add output to the return;

			//if $loop_prod_image is image
			//clear the return
			//while loop with different parameters



			while ( $q_articles->have_posts() ) :  $q_articles->the_post();

					foreach (get_the_terms( get_the_id(),'product_cat') as $term) {
						
						if (get_field('cat-type',$term)=='product'){

							if(get_field('product_type',$term)=='Image'){

								$loop_prod_type = 'Image';

								break 2;

							}elseif(get_field('product_type',$term)=='Text'||'Image Editorial'||'Image and Text'){
					
								$the_loop_return .= '<a href="'.get_the_permalink().'" class="topic-article-loop-link f-ser link-black"><span class="topic-first-line font-grey-med f-up">'.$term->name.' '.get_the_date('m/d/Y').'</span>'.get_the_title().'</a>';	
							
							}/*end elseif*/
							
						}/*end if(catype==product)*/

					}/*end foreach*/

			endwhile;

			wp_reset_query();



			if($loop_prod_type=='Image'){

				while ( $q_articles->have_posts() ) :  $q_articles->the_post();

					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail-size', false)[0];
					//echo $img_url;

					foreach (get_the_terms( get_the_id(),'product_cat') as $term) {

						
						if (get_field('cat-type',$term)=='product'){



							if(get_field('product_type',$term)=='Image' && $img_url!=''){							

								$the_loop_return .= '<a href="'.get_the_permalink().'">
														<span class="topic-first-line font-grey-med f-up">'.$term->name.' '.get_the_date('m/d/Y').'</span>
														<img src="'.$img_url.'" alt="'.get_the_title().'" style="background-color:#ddd;">
													</a>';

							}else{
								
								$the_img='';
								if($img_url!=''){
									$the_img='<img src="'.$img_url.'" alt="">';
								}

								$the_loop_return .= '
								<a href="'.get_the_permalink().'" class="">
									<span class="topic-first-line font-grey-med f-up">'.$term->name.' '.get_the_date('m/d/Y').'</span>
									'.$the_img.'
									<h3 class="font-black f-ser-bold">'.get_the_title().'</h3>
									<p class="font-grey-med f-ser">'.get_the_excerpt().'</p>
								</a>';
							
							}/*end elseif*/
							
						}/*end if(catype==product)*/

					}/*end foreach*/

				endwhile;

			}/*end if($loop_prod_type=='Image')*/


			echo '<br>ARTICLES<br>'.$the_loop_return;

			echo get_next_posts_link( __( '>>More Articles' ) );

			wp_reset_query();
			


?>