<?php
// Add Shortcode
//still to do, handle rounded corners
function topic_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
		'slug' => '',
		'title'=> '',
		'columns'=>'',
		'background'=>null,
		'category_type'=>'',
		'border_radius'=>''
		), $atts )
	);

	$the_return = '';
	// Code
		$term = '';
		$termchildren = array();
		if (!empty($atts['slug'])){
			$term = get_term_by('slug', $atts['slug'], 'product_cat');
			$term_id = $term->term_id;
			$taxonomy_name = 'product_cat';
			$termchildren = get_term_children( $term_id, $taxonomy_name );
		}else{
			$queried_object = get_queried_object();
			$terms = get_the_terms($queried_object->id,'product_cat' );
			$term = array_pop($terms);
			$term_id = $term->term_id;
			$taxonomy_name = 'product_cat';
			$termchildren = get_term_children( $term_id, $taxonomy_name );

		}
	//this variable tells us if this is a product, topic, or service
	$cat_type = get_field('cat-type',$term);
	
	$css_color = '';
	
		if($atts['background']=='true'){
			$the_color = service_color($term);
			$css_color = 'background-color:'.$the_color.'; ';
		}elseif(!empty($atts['background'])){
			$css_color = 'background-color:'.$atts['background'].'; ';
		}elseif($cat_type == 'service'){
			$the_color = service_color($term);
			$css_color = 'background-color:'.$the_color.'; ';
		}

	$border_radius = '';

	if(!empty($atts['border_radius'])){

		$border_radius = 'border-radius:'.$atts['border_radius'].'; ';

	}elseif($cat_type =='service'){

		$border_radius = 'border-radius:100%; ';

	}



/* check to see if there is a column with set*/

	$sc_width = $atts['columns'];

	$width ='';
	if (!empty($sc_width)){
		$w1_6 = array('six','6','sixths','sixth');
		$w1_5 = array('five','5','fifths','fifth');
		$w1_4 = array('four','4','fourths','fourth');
		$w1_3 = array('three','3','thirds','third');
		$w1_2 = array('two','2','halves','half');
		$wful = array('full','1','single');
		
		if (in_array($sc_width, $w1_6)) {
		    $width = 'w1-6';
		}elseif (in_array($sc_width, $w1_5)) {
			$width = 'w1-5';
		}elseif (in_array($sc_width, $w1_4)) {
			$width = 'w1-4';
		}elseif (in_array($sc_width, $w1_3)) {
			$width = 'w1-3';
		}elseif (in_array($sc_width, $w1_2)) {
			$width = 'w1-2';
		}elseif (in_array($sc_width, $wful)) {
			$width = 'wful';
		}

	}else{
			$width="w1-5";
	}

	$title = '';
	if(!empty($atts['title'])){
		$title = '<h2 class="article-loop-label f-up f-san-200 font-blue bord-grey-med">'.$atts['title'].'</h2>';
	}

	foreach ( $termchildren as $child ) {
				//if($child->parent == 0 ){echo $child->name;}

				$child_term = get_term_by( 'id', $child, $taxonomy_name );

				$logo_url = get_field('product_cat_logo', $child_term);
				if ($logo_url ==''){
					$logo_url = svg_blades();
				}

				$holder = $the_return;

				if($term_id==$child_term->parent){

				$the_return = $holder.'<a href="' . get_term_link( $child, $taxonomy_name ) . '" class="sc-topic-loop link-grey-med f-cen '.$width.'"><i style="background-image:url('.$logo_url.');'.$css_color.$border_radius.'" class="sc-topic-loop-logo"></i>'.$child_term->name.'</a>';
				
				}
			}

		return $title.$the_return;
}
add_shortcode( 'topics', 'topic_shortcode' );?>
