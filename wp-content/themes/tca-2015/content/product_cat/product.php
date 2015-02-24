
<?php

$queried_object = get_queried_object(); 

$taxonomy = $queried_object->taxonomy;

$term_id = $queried_object->term_id;

$p = get_field('product_type',$taxonomy . '_' . $term_id);

//echo $p;
if ($p=='Text') {include 'product/text.php';}
	
elseif ($p=='Image') {include 'product/image.php';}

elseif ($p=='Image Editorial') {include 'product/image_editorial.php';}

else {include'product/image_and_text.php';}

?>