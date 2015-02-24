
<?php 

//echo "<p>this is pulling from content-product_cat-archive.php</p>";
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term = get_term( $term_id, $taxonomy);
$value = get_field('cat-type',$taxonomy . '_' . $term_id);
//if ($value=='service') echo $value;
if ($value=='topic'){
	include 'product_cat/topic.php';}
elseif ($value=='product') {
	include('product_cat/product.php');
	}
	
?>