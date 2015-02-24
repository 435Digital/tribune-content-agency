<?php get_header();?>
<?php
include 'index.php';
//echo 'Bob';

	if (is_archive()) {
			
			
		if (is_tax('product_cat')){
			
			$queried_object = get_queried_object(); 
			$taxonomy = $queried_object->taxonomy;
			$term_id = $queried_object->term_id;  
			
			$isProduct = get_field('is_product', $taxonomy . '_' . $term_id);
			
			if ($isProduct){
				get_template_part('content/content', 'product_cat-product');
				}
			else {
				get_template_part('content/content','product_cat-archive');
			}
			get_template_part( 'content/content','archive-product_cat');	
			
				}
	}elseif(get_post_type()==='article'){
			if (is_single()){
				get_template_part( 'content/content','article');
			}
					
	
	}elseif(is_post()){
			get_template_part( 'content/content','post');
			
	}
	
	
	//$is_product = get_field("is_product");
	//echo $is_product;
	
	

?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php dynamic_sidebar('premium_content'); ?>
<?php endif; ?>

<?php get_footer();?>