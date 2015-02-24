<?php
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$terms = get_term_by( 'id', $term_id, $taxonomy );

$headlineText = get_field('product_category_headline',$taxonomy . '_' . $term_id);

echo($headlineText);
//include 'includes/articles-loop-index.php';
?>
<div style="width: 25%;"><img src="<?php the_field('product_cat_logo',$taxonomy . '_' . $term_id); ?>" alt="" /></div>

<?php
include 'includes/text-articles-loop-index.php';
echo '<h3> Descpription </h3> <hr />';
?>
<div style="width: 10%;height: 70%;"><img src="<?php the_field('product_cat_logo',$taxonomy . '_' . $term_id); ?>" alt="" /></div>


<?php

echo $terms->description . '<br />';


$slugs = get_field('also_like',$taxonomy . '_' . $term_id);

echo do_shortcode('[myshortcode slug="'.$slugs.'"]');




?>