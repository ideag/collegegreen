<?php 
class WP_Widget_CG_Contacts extends WP_Widget {
    public function __construct() {
        $widget_ops = array('classname' => 'widget_contacts contacts', 'description' => __('Contacts widget for College Green theme'));
        parent::__construct('cg_contacts', __('[CG] Contacts'), $widget_ops);
    }
    public function widget( $args, $instance ) {
        $title =    apply_filters( 'widget_title',      empty( $instance['title'] ) ? ''    : $instance['title'], $instance, $this->id_base );
        $address =  apply_filters( 'widget_address',    empty( $instance['address'] )  ? '' : $instance['address'],  $instance );
        $phone =    apply_filters( 'widget_phone',      empty( $instance['phone'] )  ? ''   : $instance['phone'],  $instance );
        $email =    apply_filters( 'widget_email',      empty( $instance['email'] )  ? ''   : $instance['email'],  $instance );
        $address = str_replace( "\r\n", '<br/>', $address);
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div class="row">';
        echo '<p class="adr clearfix col-md-12 col-sm-4">';
        echo '<i class="fa fa-map-marker pull-left"></i>';        
        echo '<span class="adr-group pull-left">'.$address.'</span>';
        echo '</p>';
        echo '<p class="tel col-md-12 col-sm-4"><i class="fa fa-phone"></i>'.$phone.'</p>';
        echo '<p class="email col-md-12 col-sm-4"><i class="fa fa-envelope"></i><a href="mailto:'.esc_attr($email).'">'.$email.'</a></p>';
        echo '</div>';
        echo $args['after_widget'];

    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] =    strip_tags( $new_instance['title'] );
        $instance['address'] =  $new_instance['address'];
        $instance['address'] = explode( "\r\n", $instance['address'] );
        $instance['address'] = array_map( 'sanitize_text_field', $instance['address'] );
        $instance['address'] = implode( "\r\n", $instance['address'] );
        $instance['phone'] =    sanitize_text_field( $new_instance['phone'] );
        $instance['email'] =    sanitize_text_field( $new_instance['email'] );
        return $instance;
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'count' => 5 ) );
        $title = strip_tags( $instance['title'] );
        $address = strip_tags( $instance['address'] );
        $phone = strip_tags( $instance['phone'] );
        $email = strip_tags( $instance['email'] );
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:'); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('address'); ?>" cols="30" rows="5" name="<?php echo $this->get_field_name('address'); ?>"><?php echo esc_textarea($address); ?></textarea></p>

        <p><label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone no.:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email Address:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="email" value="<?php echo esc_attr($email); ?>" /></p>
<?php
    }
}
