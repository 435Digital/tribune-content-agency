<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>

			<main class="content-m f-ser">
				<div class="content-simple">
				<?php echo the_content();?>
				</div>
			</main>
		<?php
	} // end while
} // end if
?>