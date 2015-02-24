<?php

function ryans_short_code($atts, $content = null) {

	$c = shortcode_atts( array(
			'title' => '',
			'column' => '',
			'slug' => '',
			'number_of_posts'=>'',
		), $atts );
	
	

	$col = esc_attr($c['column']);
	
	$limit = esc_attr($c['number_of_posts']);
	
	
	if (empty($limit) and empty($col)) {
		$column = 'w1-6';
		$limit = 12;
		}

	
	$column = '';
	if (empty($col)){
		$column = 'w1-6';
			}
	if (!empty($col)){
			$w1_6 = array('6','six','one-sixth','1/6','sixth');
			$w1_5 = array('5','five','one-fifth','1/5','fifth');
			$w1_4 = array('4','four','one-fourth','1/4', 'fourth');
			$w1_3 = array('3','three','third','one third','one-third','one thirds','one-thirds','1 3','1/3','1-3','13','33','33%','thirtythree');
			$w1_2 = array('half','one half','one-half','1 2','1/2','2-3','12','50','50%','fifty');
			$wful = array('full','1-1','1/1','1 1','3-3','3/3','3 3','2-2','2/2','2 2','two halves','two halfs','2 halves','2 halfs','three thirds');
			
			
			if (in_array($col, $w1_6)) {
				$column = 'w1-6';
				if (empty($limit)) {
					$limit = 12; 
				}
			}elseif (in_array($col, $w1_5)) {
				$column = 'w1-5';
				if (empty($limit)) {
					$limit = 10; 
				}
			}elseif (in_array($col, $w1_4)) {
				$column = 'w1-4';
				if (empty($limit)) {
					$limit = 8; 
				}
			}elseif (in_array($col, $w1_3)) {
				$column = 'w1-3';
				if (empty($limit)) {
					$limit = 6; 
					    }
			}
			elseif (in_array($col, $w1_2)) {
				$column = 'w1-2';
				if (empty($limit)) {
					$limit = 4; 
				}
			}elseif (in_array($col, $wful)) {
				$column = "wful";
				if (empty($limit)) {
					$limit = 2; 
				}
			}
			
				
		}
	
	$title = esc_attr($c['title']);
	if ($title==''){
		$title = 'You Might Also Like...';
		}	
	
	$slug = esc_attr($c['slug']);
	$arr = explode(", ", $slug);
	
	
	echo '<h3>'. $title .'</h3> <br /> Number of Columns: ' . $column;	
	echo '<br /><br />Limited amount of posts: '.$limit;
	if ($slug == ''){
		//if (is_page()) echo 'True';
		$queried_object = get_queried_object();
		//var_dump($queried_object);
		$IDD = $queried_object->ID;
		$postType = $queried_object->post_type;
		$taxonomy_name = 'product_cat';
		if (is_page($IDD) or is_singular($postType)) {
			$terms = get_the_terms($queried_object->id,'product_cat' );
			$term = array_pop($terms);
			$term_id = $term->term_id;
			$currentTerm = get_term( $term_id, $taxonomy_name );
			$parentsID = $currentTerm->parent;
		}
		
		else {
			$currentID = $queried_object->term_id;
			$parentsID = $queried_object->parent;
			
		
		}
		//echo '<p>'.$term_id.'</p>';
	if ($parentsID == 0){
		$right_id = $currentTerm->term_id;
		$termed = get_term( $right_id, 'product_cat');
		$name = $termed->name;
		}
	else {
		$right_id = $parentsID;
		}
		
		$str_id = (string)$right_id;
		$termchildrened = get_term_children( $str_id, 'product_cat' );
		$count = 0;
		foreach ($termchildrened as $p ) {
			if ($count == $limit)  break;
				
			$Pterms = get_term_by( 'id', $p, 'product_cat' );
			//$PPterms = get_term($Pterms->term_id, 'product_cat');
			//echo $PPterms;
			$Pterm = get_term($Pterms->parent, 'product_cat');
			$parentID = $Pterm->term_id;
				
			if ($parentID == $right_id and $p != $currentID){
				//echo $parentID;
				$child_terms = get_term_by( 'id', $p, $taxonomy_name );
					
				$link = get_term_link($p, 'product_cat');
				
				$logo_url = get_field('product_cat_logo', $child_terms);
				$term = get_term( $p, 'product_cat');
				$namer = $term->name;
				
				$link = get_term_link($p, 'product_cat');
					
				echo '<a href="'.$link.'"><h2>' .$namer . '</h2></a>';
					
				if (!empty($logo_url)){
					echo '<a href="'.$link.'"><img src="'.$logo_url.'"></a>';
					}
				else {
					echo 'Sorry, no image';
					}
			
				}
			$count++;
				}
			

			}
	
	else if (count($arr)==1) {
		$Array = get_term_by('slug', $slug, 'product_cat');
		if ($Array==false){ 
		return 'This is not valid input';
		}
		
		
		$newArray = array();
		foreach ($Array as $key => $value) {
			if (is_int($value)){
				$newArray[] = $value;
			}
		
		}
	
		$right_id = $newArray[0];
		$str_id = (string)$right_id;
		$terms = get_the_terms($str_id,'product_cat' );
		$termchildrened = get_term_children( $str_id, 'product_cat' );
		
		$count = 0;
		foreach ($termchildrened as $p ) {
			
			if ($count == $limit)  break;
			$Pterms = get_term_by( 'id', $p, 'product_cat' );
			$Pterm = get_term($Pterms->parent, 'product_cat');
			$parentID = $Pterm->term_id;
			
			if ($parentID == $right_id){
			
				$child_terms = get_term_by( 'id', $p, 'product_cat' );
				
				$link = get_term_link($p, 'product_cat');
				
				$logo_url = get_field('product_cat_logo', $child_terms);
				
				$term = get_term( $p, 'product_cat');
				$namer = $term->name;
			
				$link = get_term_link($p, 'product_cat');
			
				echo '<a href="'.$link.'"><h2>' .$namer . '</h2></a>';
		
				if (!empty($logo_url)){
					echo '<a href="'.$link.'"><img src="'.$logo_url.'"></a>';
					}
				else {
					echo 'Sorry, no image';
					}
		
				}
			$count++;
			}
			
	
		}
	
	elseif (count($arr > 1)) {
	
		$st = array();
		
		foreach ($arr as $k => $v){
			//echo($v);
			$slug2 = get_term_by('slug', $v, 'product_cat'); 
			if ($slug2==false){ 
				return 'This is not valid input';}
			
			$st[] = $slug2; 
			
			}
				$finalarr = array();
		foreach ($st as $index => $items) {
			
			$finalarr[] = ($items->term_id);
			
			}
		foreach ($finalarr as $i => $f) {
			$t = get_term($f, 'product_cat');
			$child_term = get_term_by('id', $f, 'product_cat');
			$logo_url = get_field('product_cat_logo', $child_term);
			$namer = $t->name;
			$link = get_term_link($f, 'product_cat');
			
			echo '<a href="'.$link.'"><h2>' .$namer . '</h2></a>';
			//echo '<br />';
			if (!empty($logo_url)){
				echo '<a href="'.$link.'"><img src="'.$logo_url.'"></a>';
				}
			else {
				echo 'Sorry, no image';
				}
			echo '</li>';
			
			
			}
		}
		/*This Might be of some use, don't remove
		$allchildren = array();
		
		foreach ($finalarr as $keys => $children_id) {
			$allchildren[] = get_term_children( $children_id, 'product_cat');
			}
		
		foreach ($allchildren as $i => $f) {
			if (is_array($f)){
				foreach ($f as $key => $k) {
					$t = get_term($k, 'product_cat');
					$namer = $t->name;
					echo $namer;
					echo "<br />";
			}
			
			}
			//echo '<br /><br /><br /><br /><br />';}
			//$done = get_term($f, 'product_cat');
			//echo $done;
		}	*/
		
	
	return;
}

add_shortcode('myshortcode', 'ryans_short_code');
	
?>
