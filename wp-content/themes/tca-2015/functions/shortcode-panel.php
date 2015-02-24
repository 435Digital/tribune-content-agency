<?php
function generate_panel( $atts , $content = null ) {
	// Attributes
	$atts = shortcode_atts( array(
		'background_color'=>'',
		'background_image'=>'',
		'id'=>'',
		'padding_top'=>'',
		'padding_bottom'=>'',
		'tag' => 'div',
		'full'=> 'true',
	), $atts, 'panel' );

	$bgc ='';
	if (!empty($atts['background_color'])){
		$bgc =' background-color:'.$atts['background_color'].';';
	}
	$pt ='';
	if (!empty($atts['background_color'])){
		$pt =' padding-top:'.$atts['padding_top'].';';
	}
	$pb ='';
	if (!empty($atts['background_color'])){
		$pb =' padding-bottom:'.$atts['padding_bottom'].';';
	}
	$style=' style="'.$bgc.$pt.$pb.'"';

	$id =' ';
	if (!empty($atts['id'])){
		$id = ' id="'.$atts['id'].'" ';
	}
	if (!empty($atts['background_image'])){
		res_img($atts['background_image'],'#'.$atts['id']);
	}

	$start = '';
	$end = '';
	$start_content = '';
	$end_content = '';

	if($atts['full'] == 'true'){
			$start = '</div>';
			$end = '<div class="content-simple">';
			$start_content = $end;
			$end_content = $start;
	}

	$the_return = $start.'<'.$atts['tag'].$id.$style.' class="panel">'.$start_content.$content.$end_content.'</'.$atts['tag'].'>'.$end;

	return $the_return;
}
add_shortcode( 'panel', 'generate_panel' );
?>