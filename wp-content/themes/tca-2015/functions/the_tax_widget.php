<?php 
// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('Hierarchy Sidebar Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Widget that displays the hierarchical structure of a taxonomy', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens


public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where the functionality is 
$queried_object = get_queried_object(); 

$taxonomy = $queried_object->taxonomy;

$term_id = $queried_object->term_id;

$term = get_term( $term_id, $taxonomy);

$name = $term->name;

$parent  = get_term_by( 'id', $term_id, $taxonomy);

$back = array();

 while ($parent->parent != '0'){
 	$term_ids = $parent->parent;
	
    $parent  = get_term_by( 'id', $term_ids, $taxonomy);     
    $x =$parent->term_id;
    $back[] = $x;

	}


$last_key = key( array_slice( $back, -1, 1, TRUE ) );
if (sizeof($back)==0){
	$parent_id = $term_id;
	}
else{
	$parent_id = $back[$last_key];
	}

$parent_term = get_term( $parent_id, $taxonomy);

$parent_name = $parent_term->name;

$link = get_term_link($parent_id, $taxonomy);

echo '<br><a href="'.$link.'">' .$parent_name . '</a><br>';

$args = array(
   'child_of' => $parent_id,
   'taxonomy' => $taxonomy,
	'hide_empty' => 0,
	'hierarchical' => true,
	'depth'  => 10000,//hack
	'show_option_none' => '', 
	'title_li' => __( '' ),
	'use_desc_for_title' => 0
	
   );
wp_list_categories( $args );


echo $args['after_widget'];

}


public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget');
	

?>
		
		
		
		
		
		
		