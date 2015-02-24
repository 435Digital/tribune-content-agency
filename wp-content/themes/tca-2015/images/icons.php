<?php

function svg_blades($col = '#fff', $is_uri = true){
	$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 337.68 337.68" height="337.68px" width="337.68px"><g stroke="'.$col.'" fill-opacity="0" stroke-width="4.07"><rect transform="matrix(-.96593-.25882 0 1-206.16-363.52)" rx="12.5" y="278.45" x="-505.59" height="228.76" width="160.32"/><rect transform="matrix(0 1 .96593-.25882-206.16-363.52)" rx="12.5" y="270.86" x="614.53" height="234.73" width="152.49"/></g></svg>';
	if($is_uri = true){
		return svg64($svg);
	}else{
		return $svg;
	}
}

?>