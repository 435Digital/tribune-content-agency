<?php get_header();?>
<?php
	//include 'hiba.php';
	//include 'ryan.php';
	if (is_front_page()){

			get_template_part( 'content/content','home');

	}elseif (is_page()) {

			$landing_page =  get_field('landing_page_switch');
			if (!empty($landing_page[0])){
				get_template_part( 'content/content','page-landing');

			}else{
				get_template_part( 'content/content','page');
			}
	
	}elseif (is_archive()) {
			
			if (is_tax('product_cat')){

				$queried_object = get_queried_object(); 
				$taxonomy = $queried_object->taxonomy;

				$term_id = $queried_object->term_id;
				$term = get_term( $term_id, $taxonomy);
				$value = get_field('cat-type',$taxonomy . '_' . $term_id);

				if ($value=='service'){echo $value;}

				if ($value=='topic'){
					
					get_template_part( 'content/content','topic');}
				elseif ($value=='product') {
					
					get_template_part( 'content/content','product');
					}

				//get_template_part('content/content','product_cat-archive');
				//get_template_part( 'content/content','archive-product_cat');

			}			
		
	}elseif(get_post_type()==='article'){
			if (is_single()){
				get_template_part( 'content/content','article');
			}
					
	
	}elseif(is_post()){
			get_template_part( 'content/content','post');
			
	}

	
?>

<?php get_footer();?>