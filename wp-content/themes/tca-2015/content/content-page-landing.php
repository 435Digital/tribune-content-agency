<?php 
	$queried_object = get_queried_object(); 
	
	$terms = get_the_terms($queried_object->id,'product_cat' );

	$term = array_pop($terms);

	$service_logo = get_field('product_cat_logo', $term);

	$service_hero = get_field('product_cat_hero', $term);

	$service_color = get_field('product_cat_color', $term); 

	$cat_type = get_field('cat-type', $term);
	?>

			<style>
				.font-service
				.link-service a,
				a.link-service{color:<?php echo $service_color; ?>}
				.back-service{background-color:<?php echo $service_color; ?>}
				.bord-service{border:solid <?php echo $service_color; ?>}

				.lp-h1.lp-h1{
					display:inline-block;
					padding: 5%;
					background-origin: content-box;
					background-position: left center;
					background-size: contain;
					background-repeat: no-repeat;
					font-size: 3.5em;
					/*font-size: 5.75vw;*/
					vertical-align: middle;
					width: 87%;
					line-height: .75;
				}

				@media screen and (min-width:83em){

					.lp-h1.lp-h1{
						font-size: 3.5em;
					}

				}/*@media end*/

				.lp-h1.lp-h1[style*="http"]{color:rgba(0,0,0,0);}

				p.lp-h1-sub{
					display: block;
					padding:0em;
					font-size: 1.875em;
					/*font-size: 3.125vw;*/
					}
				@media screen and (min-width:83em){

				}
				.lp-logo{
					display:inline-block;
					padding: 0;
					border-radius: 50% 50%;	
					vertical-align: middle;
					width:13%;
					background-size:75%;
					background-position: center center;
					background-repeat: no-repeat;
				}
				.lp-logo:before{
					content: '';
					display: block;
					width: 100%;
					padding-top: 100%;
				}
				.hdr-lp{padding: 1em 0;font-size: 1em;}
			</style>

<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
			<?php $lp_sub = get_field('sub_header'); ?>
			<main class="content-m f-ser">
			
				<header class="hdr-lp"style="background-color:<?php echo hex2rgba($service_color, '.1'); ?>">
					<div class="content-simple">
						<i class="lp-logo" style="background-color:<?php echo $service_color; ?>; background-image:url(<?php echo svg_blades(); ?>)"></i><h1 class="lp-h1 font-blue" style="background-image:url(<?php echo $service_hero; ?>)"><?php the_title();?></h1>
						<p class="lp-h1-sub f-ser font-grey-med"><?php echo $lp_sub; ?></p>
					</div>
				</header>
				<div class="content-simple">
					<?php echo the_content();?>
				</div>
			</main>
		<?php
	} // end while
} // end if
?>