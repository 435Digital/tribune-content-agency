<?php class custom_tax_widget extends WP_Widget {
    function custom_tax_widget() {
        $widget_ops = array( 'classname' => 'Tribune Premium Content ', 'description' => 'Displays categories' );
    // widget control settings
    $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'custom_tax_widget' );
    // create the widget
    $this->WP_Widget( 'custom_tax_widget', 'Tribune Premium Content', $widget_ops, $control_ops );
}
    }
 
    function widget($args, $instance) {
        extract( shortcode_atts( array(
        'custom_taxonomy' => '',
    ), $atts ) );

    // arguments for function wp_list_categories
        $args = array( 
        taxonomy => $custom_taxonomy,
        title_li => ''
        );

    // We wrap it in unordered list 
        echo '<ul>'; 
        echo wp_list_categories($args);
        echo '</ul>';
    }
        }
 
    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['custom_taxonomy'] = ( ! empty( $new_instance['custom_taxonomy'] ) ) ? strip_tags( $new_instance['custom_taxonomy'] ) : '';

        return $instance;
    }
    }   
     
    function form($instance) {
                $custom_taxonomy= ! empty( $instance['custom_taxonomy'] ) ? $instance['custom_taxonomy'] : __( 'New title', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>"><?php ( 'custom_taxonomy:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'custom_taxonomy' ); ?>" type="text" value="<?php echo esc_attr( $custom_taxonomy ); ?>">
        </p>
        <?php 
    }
    }
}
register_widget('custom_tax_widget'); ?>