<?php 

			$queried_object = get_queried_object();


			$taxonomy_name = 'product_cat';

			$topics="";

			foreach ( get_term_children( $queried_object->term_id, 'product_cat' ) as $child ) {

					$chi_term = get_term_by( 'id', $child, 'product_cat' );
					
					if(get_field('cat-type', $chi_term) == 'topic'){

						$topics .= do_shortcode('[topics slug="'.$chi_term->slug.'" title="'.$chi_term->name.'"]');

					}


			}

			//$topics .= '<br>TOPICS1<br>';
			
			if ($topics!= ""){
				echo '<br>TOPICS1<br>'.$topics;
			}


?>