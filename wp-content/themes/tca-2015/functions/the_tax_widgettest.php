<?php 
/**
 * adds custom recent posts widget.
 */
class the_tax_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'the_tax_widget', // Base ID
			__( 'custom recent posts', 'text_domain' ), // Name
			array( 'description' => __( 'custom recent posts', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
     	        //$wid_posts_num = ! empty( $instance['wid_posts_num'] ) ? $instance['wid_posts_num'] : __( '', 'text_domain' );
     	        //$wid_cat = ! empty( $instance['wid_cat'] ) ? $instance['wid_cat'] : __( '', 'text_domain' );
     	        
     	        //$wid_tax_term = ! empty( $instance['wid_tax_term'] ) ? $instance['wid_tax_term'] : __( '', 'text_domain' );
				
				//$custom_taxonomy = ! empty( $instance['custom_taxonomy'] ) ? $instance['custom_taxonomy'] : __( '', 'text_domain' );
     	       // $parent_cat = ! empty( $instance['parent_cat'] ) ? $instance['parent_cat'] : __( '', 'text_domain' );
		/*?>

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_posts_num' ); ?>"><?php _e( 'Number of posts' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_posts_num' ); ?>" name="<?php echo $this->get_field_name( 'wid_posts_num' ); ?>" type="text" value="<?php echo esc_attr( $wid_posts_num ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_cat' ); ?>"><?php _e( 'Category' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_cat' ); ?>" name="<?php echo $this->get_field_name( 'wid_cat' ); ?>" type="text" value="<?php echo esc_attr( $wid_cat ); ?>">
		</p> !-->

		<!--<p>
		<label for="<?php echo $this->get_field_id( 'wid_post_type' ); ?>"><?php _e( 'Post Type' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_post_type' ); ?>" name="<?php echo $this->get_field_name( 'wid_post_type' ); ?>" type="text" value="<?php echo esc_attr( $wid_post_type ); ?>">
		</p> !-->

		<p>
		<label for="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>"><?php _e( 'Taxonomy' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'custom_taxonomy' ); ?>" type="text" value="<?php echo esc_attr( $custom_taxonomy ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'parent_cat' ); ?>"><?php _e( 'Taxonomy Term' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'parent_cat' ); ?>" name="<?php echo $this->get_field_name( 'parent_cat' ); ?>" type="text" value="<?php echo esc_attr( $parent_cat ); ?>">
		</p>
<?php */ 

} 

		public function widget( $args, $instance ){
/*			echo $instance['wid_posts_num'];
			echo $instance['wid_cat'];
			echo $instance['wid_post_type'];
			echo $instance['wid_tax'];
			echo $instance['wid_tax_term'];*/

			// WP_Query arguments
					/*$args = array (
					);

			if(empty($instance['custom_taxonomy']) === false){
			 	$args['custom_taxonomy']=$instance['custom_taxonomy'];
				}
			 if(empty($instance['parent_cat']) === false){
			 	$args['parent_cat']=$instance['parent_cat'];
				}
			 /*if(empty($instance['wid_post_tax']) === false){
			 	$args['taxonomy']=$instance['wid_tax'];
			 	$args['terms']=$instance['wid_tax_term'];
			 	$args['field']=$instance['slug'];
			 	}
			 /*if(empty($instance['wid_posts_num']) === false){
			 	$args['posts_per_page']=$instance['wid_posts_num'];
			 	}*/
			 /*	$args = array( 
				taxonomy => $custom_taxonomy,
				title_li => '',
				child_of=> $parent_cat
				); 
				echo wp_list_categories($args);*/



					// The Query
					// $query = new WP_Query( $args );
					// echo '<ul id="feed-news" class="feed-news">';
					// The Loop


					// if ( $query->have_posts() ) {
					// 	while ( $query->have_posts() ) {
					// 		$query->the_post();
					// 		echo '<li>'; 
					// 		echo '<a href="'.get_permalink().'">';
					// 		the_post_thumbnail( 'thumbnail', array( 'class' => '' ) ); 
					// 		echo '<span><h3>'.get_the_title().'</h3>';
					// 		echo '<p>'.get_the_date('M j, Y').'</p></span>';
					// 		echo '</a></li>';

					// 	}
					// } else {
					// 	// no posts found
					// }
					// echo '</ul>';
					// // Restore original Post Data
					// wp_reset_postdata();

				echo $args['before_widget'];
				if ( ! empty( $instance['title'] ) ) {
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
				}
				echo __( 'Hello, World!', 'text_domain' );
				echo $args['after_widget'];
			}

		function register_test(){
		    register_widget( 'test_widget' );
		}
		add_action('widgets_init', 'register_test');

		?>
