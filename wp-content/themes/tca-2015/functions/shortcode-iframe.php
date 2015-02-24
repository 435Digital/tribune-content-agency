<?php
function gen_ifrm( $atts , $content = null ) {
	// Attributes
	$atts = shortcode_atts( array(
		'id'=>'',
		'full'=>'false'
	), $atts, 'iframe' );

    function after ($this, $inthat){
	    if (!is_bool(strpos($inthat, $this)))
	    return substr($inthat, strpos($inthat,$this)+strlen($this));
    };

    function after_last ($this, $inthat){
        if (!is_bool(strrevpos($inthat, $this)))
        return substr($inthat, strrevpos($inthat, $this)+strlen($this));
    };

    function before ($this, $inthat){
        return substr($inthat, 0, strpos($inthat, $this));
    };

    function before_last ($this, $inthat){
        return substr($inthat, 0, strrevpos($inthat, $this));
    };

    function between ($this, $that, $inthat){
        return before ($that, after($this, $inthat));
    };

    function between_last ($this, $that, $inthat){
     return after_last($this, before_last($that, $inthat));
    };


    $w=between('width="','"',$content);
    $h=between('height="','"',$content);

    $p = $h / $w * 100;

   	$start = '';
	$end = '';

	if($atts['full'] == 'true'){
			$start = '</div>';
			$end = '<div class="content-simple">';
	}

	$the_return = $start.'<div class="ifrm-con" style="position:relative;width:100%;padding:0 0 '.$p.'%;">'.$content.'</div>'.$end;

	return $the_return;
}
add_shortcode( 'iframe', 'gen_ifrm' );
?>