<?php 
class WP_Widget_CG_Links extends WP_Widget {
	public function __construct() {
		$widget_ops = array('classname' => 'widget_links links', 'description' => __('Links widget for College Green theme'));
		parent::__construct('cg_links', __('[CG] Links'), $widget_ops);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? ''         : $instance['title'], $instance, $this->id_base );
		$count =  apply_filters( 'widget_count',  empty( $instance['count'] )  ? '5'         : $instance['count'],  $instance );
		$category =  apply_filters( 'widget_category',  empty( $instance['category'] )  ? '' : $instance['category'],  $instance );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="section-content">';
		$my_query = new WP_Query( array(
		    'category_name' => $category,
		    'posts_per_page'=> $count
		) );
		if ( $my_query->have_posts() ) :
		    while ( $my_query->have_posts() ) : 
		        $my_query->the_post(); 
                echo '<p><a href="'.get_permalink().'"><i class="fa fa-caret-right"></i>'.get_the_title().'</a></p>';
		    endwhile; 
		endif; 
        echo '</div>';
		// echo wpautop( $text ); 
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = sanitize_text_field( $new_instance['category'] );
		$instance['count'] = $new_instance['count'] * 1;
		return $instance;
	}
	public static function options( $a, $value ) {
		$return = '';
		foreach ( $a as $key=>$e ) {
		  	$checked = selected( $value, $e, false );
			$return .= "<option value=\"{$key}\" {$checked}>{$e}</option>";
		}		
		return $return;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'count' => 5 ) );
		$title = strip_tags( $instance['title'] );
		$category = strip_tags( $instance['category'] );
    	$cats = get_categories();
    	$categories =  array();
    	foreach ($cats as $key => $value) {
    		$categories[$value->slug] = $value->name; 
    	}
		$count = $instance['count'] * 1;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
		<?php echo self::options( $categories, $category ); ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many posts to show:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" min="1" step="1" value="<?php echo esc_attr($count); ?>" /></p>
<?php
	}
}