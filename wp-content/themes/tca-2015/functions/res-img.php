<?php 
	function get_image_id($image_url) {
				global $wpdb;
				$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
			        return $attachment[0]; 
			}

	function med_query($med_width,$med_selector,$med_url){
				$half_min = $med_width/2;
				$med_min = $med_width-100;

				echo "@media screen and (min-width: ".$med_min."px), (min-width: ".$half_min."px) and (min-resolution: 125dpi), (min-width: ".$half_min."px) and (-webkit-min-device-pixel-ratio: 1.3), (min-width: ".$half_min."px) and (min-resolution: 1.3dppx) ){".$med_selector."{background-image:url('".$med_url."');}}";
			}

	function res_img($img_id,$selector){
		//check to see if you have an id or a url
		if(substr($img_id, 0, 4)=="http"){
			$get_id = get_image_id($img_id);
			$img_id = $get_id;
		}

		$links = array();

		$image_zero = wp_get_attachment_image_src($img_id,'medium');

			echo '<style>'.$selector.'{background-image:url('.$image_zero[0].')}';

			/* Get the intermediate image sizes and add the full size to the array. */
			$sizes = get_intermediate_image_sizes();
			$sizes[] = 'full';
			/* Loop through each of the image sizes. */
			foreach ( $sizes as $size ) {

				/* Get the image source, width, height, and whether it's intermediate. */
				$image = wp_get_attachment_image_src( $img_id, $size );

				/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
				if ( !empty( $image ) && ( true == $image[3] || 'full' == $size ) );

				med_query($image[1],$selector,$image[0]);
				}

			echo '</style>';
		}
?>