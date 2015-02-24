<?php
function gen_column( $atts , $content = null ) {
	// Attributes
	$atts = shortcode_atts( array(
		'tag'=>'div',
		'width'=>'',
		'headline'=>'',
		'headline-tag'=>'h2'
	), $atts, 'column' );

	$tag = $atts['tag'];


	$sc_width = $atts['width'];

	 $width ='';
	if (!empty($sc_width)){

		$w1_3 = array('third','one third','one-third','one thirds','one-thirds','1 3','1/3','1-3','13','33','33%','thirtythree');
		$w2_3 = array('two third','two-third','two thirds','two-thirds','1 2','2/3','2-3','23','66','66%','sixtysix');
		$w1_2 = array('half','one half','one-half','1 2','1/2','2-3','12','50','50%','fifty');
		$wful = array('full','1-1','1/1','1 1','3-3','3/3','3 3','2-2','2/2','2 2','two halves','two halfs','2 halves','2 halfs','three thirds');
		
		if (in_array($sc_width, $w1_3)) {
		    $width = 'w1-3';
		}elseif (in_array($sc_width, $w2_3)) {
			$width = 'w2-3';
		}elseif (in_array($sc_width, $w1_2)) {
			$width = 'w1-2';
		}elseif (in_array($sc_width, $wful)) {
			$width = "wful";
		}

	}

	$headline = '';
	if (!empty($atts['headline'])){
		$headline = '<'.$atts['headline-tag'].' class="column-headline font-grey-drk f-san-200 bord-grey-med">'.$atts['headline'].'</'.$atts['headline-tag'].'>';
	}

	$class='';
	if (!empty($width)){
		$class = ' class="column font-grey-med '.$width.'" ';
	}

	$the_return = '<'.$tag.$class.'>'.$headline.do_shortcode($content).'</'.$tag.'>';

	return $the_return;
}
add_shortcode( 'column', 'gen_column' );
add_shortcode( 'row', 'gen_column' );
?>