<?php 
			
			$queried_object = get_queried_object();

			$products = '';

			foreach ( get_term_children( $queried_object->term_id, 'product_cat' ) as $child ) {

				$chi_term = get_term_by( 'id', $child, 'product_cat' );
		
				if($chi_term->parent == $queried_object->term_id){
					
					if(get_field('cat-type', $chi_term) == 'product'){

						$logo_url = get_field('product_cat_logo', $chi_term);
						if ($logo_url ==''){
							$logo_url = svg_blades();
						}

						//$products .= '<a href="'.get_term_link( $child, $taxonomy_name ).'">'.$chi_term->name.'</a>';
						$products .= '<a href="' . get_term_link( $child, 'product_cat' ) . '" class="sc-topic-loop link-blue w1-4 f-san"><i style="background-image:url('.$logo_url.'); background-color:#eee;" class="sc-topic-loop-logo"></i>'.$chi_term->name.'</a>';
					}

				}

			}

			if(!empty($products)){
				echo '<h2 class="part-label f-up f-san-200 font-blue bord-grey-med">Products</h2><div>'.$products.'</div>';
			}
 ?>