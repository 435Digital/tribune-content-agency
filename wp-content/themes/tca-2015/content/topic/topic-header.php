<header class='topic-header back-black' style="background-image:url(<?php echo get_field('product_cat_hero',$term);?>)">
	<?php 

		$topic_img = get_field('product_cat_logo',$term);
		if(!empty($topic_img)){
			$topic_img = '<img class="topic-logo" src="'.$topic_img.'">';
		}

	?>

	<h1 class="topic-header-h1 font-white f-ser f-cen content-simple" style="border-bottom-color:<?php echo service_color(get_term_by( 'id', $queried_object->parent, $taxonomy)) ?>"><?php echo $topic_img.$name ?></h1>
</header>