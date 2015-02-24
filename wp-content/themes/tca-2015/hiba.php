
<?php
	// $topcat=get_field("cat-type");
	// if (is_tax('product_cat')){
	// if($topcat=="topic"){
	// 	echo 'bob';
	// }
	// }
$topcat=the_field("cat-type");
	if($topcat=='topic'){
		echo 'bob';
	}
?>
