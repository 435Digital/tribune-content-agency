<?php 
/**
 * adds custom recent posts widget.
 */
class the_recent_posts_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'custom_recent_posts_wid', // Base ID
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
     	        //$wid_posts_num = ! empty( $instance['wid_posts_num'] ) ? $instance['wid_posts_num'] : __( '', 'text_domain' );
     	        //$wid_cat = ! empty( $instance['wid_cat'] ) ? $instance['wid_cat'] : __( '', 'text_domain' );
     	        $wid_post_type = ! empty( $instance['wid_post_type'] ) ? $instance['wid_post_type'] : __( '', 'text_domain' );
     	        $wid_tax = ! empty( $instance['wid_tax'] ) ? $instance['wid_tax'] : __( '', 'text_domain' );
     	        $wid_tax_term = ! empty( $instance['wid_tax_term'] ) ? $instance['wid_tax_term'] : __( '', 'text_domain' );

		?>
		<!--<p>
		<label for="<?php echo $this->get_field_id( 'wid_posts_num' ); ?>"><?php _e( 'Number of posts' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_posts_num' ); ?>" name="<?php echo $this->get_field_name( 'wid_posts_num' ); ?>" type="text" value="<?php echo esc_attr( $wid_posts_num ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_cat' ); ?>"><?php _e( 'Category' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_cat' ); ?>" name="<?php echo $this->get_field_name( 'wid_cat' ); ?>" type="text" value="<?php echo esc_attr( $wid_cat ); ?>">
		</p> !-->

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_post_type' ); ?>"><?php _e( 'Post Type' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_post_type' ); ?>" name="<?php echo $this->get_field_name( 'wid_post_type' ); ?>" type="text" value="<?php echo esc_attr( $wid_post_type ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_tax' ); ?>"><?php _e( 'Taxonomy' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_tax' ); ?>" name="<?php echo $this->get_field_name( 'wid_tax' ); ?>" type="text" value="<?php echo esc_attr( $wid_tax ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'wid_tax_term' ); ?>"><?php _e( 'Taxonomy Term' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'wid_tax_term' ); ?>" name="<?php echo $this->get_field_name( 'wid_tax_term' ); ?>" type="text" value="<?php echo esc_attr( $wid_tax_term ); ?>">
		</p>
<?php } 

		public function widget( $args, $instance ){
/*			echo $instance['wid_posts_num'];
			echo $instance['wid_cat'];
			echo $instance['wid_post_type'];
			echo $instance['wid_tax'];
			echo $instance['wid_tax_term'];*/

			// WP_Query arguments
					$args = array (
					);

			if(empty($instance['wid_post_type']) === false){
			 	$args['post_type']=$instance['wid_post_type'];
				}
			 /*if(empty($instance['wid_cat']) === false){
			 	$args['category_name']=$instance['wid_cat'];
				}*/
			 if(empty($instance['wid_post_tax']) === false){
			 	$args['taxonomy']=$instance['wid_tax'];
			 	$args['terms']=$instance['wid_tax_term'];
			 	$args['field']=$instance['slug'];
			 	}
			 /*if(empty($instance['wid_posts_num']) === false){
			 	$args['posts_per_page']=$instance['wid_posts_num'];
			 	}*/



					// The Query
					$query = new WP_Query( $args );
					echo '<ul id="feed-news" class="feed-news">';
					// The Loop


					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							echo '<li>'; 
							echo '<a href="'.get_permalink().'">';
							the_post_thumbnail( 'thumbnail', array( 'class' => '' ) ); 
							echo '<span><h3>'.get_the_title().'</h3>';
							echo '<p>'.get_the_date('M j, Y').'</p></span>';
							echo '</a></li>';

						}
					} else {
						// no posts found
					}
					echo '</ul>';
					// Restore original Post Data
					wp_reset_postdata();


		
			}
		




		}
		function register_custom_recent_posts(){
		    register_widget( 'the_recent_posts_widget' );
		}
		add_action('widgets_init', 'register_custom_recent_posts');

		?>