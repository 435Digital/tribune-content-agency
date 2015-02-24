<?php

$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$terms = get_term_by( 'id', $term_id, $taxonomy );
//var_dump($terms);
echo '<h3> Descpription </h3> <hr />';
echo $term->description . '<br />';


$slugs = get_field('also_like',$taxonomy . '_' . $term_id);

echo do_shortcode('[myshortcode slug="'.$slugs.'"]');



?>