<?php 
class WP_Widget_CG_Events extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_events events', 'description' => __( 'Events widget for College Green theme', 'college-green') );
        parent::__construct('cg_events', __('[CG] Events', 'college-green'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);
        $count =  apply_filters( 'widget_count',  empty( $instance['count'] )  ? '5'         : $instance['count'],  $instance );
        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        echo '<div class="section-content">';
        $my_query = tinyEvents::upcoming_events(array( 'posts_per_page' => $count ) );
        if ( $my_query->have_posts() ) :
            while ( $my_query->have_posts() ) : 
                $my_query->the_post(); 
                $event = $my_query->post;
                $title = get_post_meta( $event->ID, 'tinyevents_title', true) ;
                if ( !$title ) {
                    $title = get_the_title($event);
                }
                $link = get_permalink($event);
                $start = get_post_meta( $event->ID, 'tinyevents_start', true );
                $end = get_post_meta( $event->ID, 'tinyevents_end', true );
                if ( strtotime( $start ) == strtotime( $end ) ) {
                    $date = $start;
                } else {
                    $date = $start.' - '.$end;
                }
                $month = date('M', strtotime($start) );
                $day = date('d', strtotime($start) );
                $place = get_post_meta( $event->ID, 'tinyevents_location', true );
                echo '<div class="event-item">';
                echo '<p class="date-label">';
                echo '<span class="month">'.$month.'</span>';
                echo '<span class="date-number">'.$day.'</span>';
                echo '</p>';
                echo '<div class="details">';
                echo '<h2 class="title"><a href="'.esc_attr($link).'">'.$title.'</a></h2>';
                echo '<p class="time"><i class="fa fa-clock-o"></i>'.$start.'</p>';
                if ( $end ) {
                    echo '<p class="time"><i class="fa fa-clock-o"></i>'.$end.'</p>';                
                }
                if ( $place ) {
                    echo '<p class="location"><i class="fa fa-map-marker"></i>'.$place.'</p>';                           
                }
                echo '</div>';
                echo '</div>';
            endwhile; 
        endif; 
        $category_id = get_cat_ID( College_Green::get_option('events_category') );
        $category_link = get_category_link( $category_id );
        echo '<a class="read-more" href="'.esc_url($category_link).'">'.__( 'All events', 'college-green' ).'<i class="fa fa-chevron-right"></i></a>';
        echo '</div>';
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] * 1;

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 5 ) );
        $title = strip_tags($instance['title']);
        $count = $instance['count'] * 1;
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many posts to show:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" min="1" step="1" value="<?php echo esc_attr($count); ?>" /></p>

<?php
    }
}
