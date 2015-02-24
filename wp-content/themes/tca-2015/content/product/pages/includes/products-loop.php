<?php 
			
			$queried_object = get_queried_object();

			$products = '';

			foreach ( get_term_children( $queried_object->term_id, 'product_cat' ) as $child ) {

				$chi_term = get_term_by( 'id', $child, 'product_cat' );
		
				if($chi_term->parent == $queried_object->term_id){
					
					if(get_field('cat-type', $chi_term) == 'product'){

						$products .= '<a href="'.get_term_link( $child, $taxonomy_name ).'">'.$chi_term->name.'</a>';

					}

				}

			}

			if(!empty($products)){echo '<br>PRODUCTS<br>'.$products;}
 ?>