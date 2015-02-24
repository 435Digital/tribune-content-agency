<!--<?php if ( ! dynamic_sidebar( 'primary' ) ) : ?>


<?php endif; ?>

<!--<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar -->
<!--<?php endif; ?>

<?php dynamic_sidebar( 'sidebar-1' ); ?>!-->

<div id="widgetized-area"> 

	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widgetized-area')) : else : ?>

	<div class="pre-widget"> 
		<p><strong>Widgetized Area</strong></p>
		<p>This panel is active and ready for you to add some widgets via the WP Admin</p>
	/div> 
	<?php endif; ?>

</div> 

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php dynamic_sidebar('premium_content'); ?>
<?php endif; ?>

<?php if ( dynamic_sidebar('custom_tax_widget') ) : else : endif; ?>