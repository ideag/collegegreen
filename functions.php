<?php
// To Do: fix widgets, create new ones

add_action( 'init', 		array( 'College_Green', 'init' ) );
add_action( 'widgets_init', array( 'College_Green', 'widgets' ) );
class College_Green {
    public static $options = array(
		'footer_text'		=> '',
		'footer_link'		=> 'http://media.kauko.lt',
		'footer_name'		=> 'Medijų tecnologijų katedra',
		'news_category' 	=> 'uncategorized',
		'slider_category' 	=> 'uncategorized',
		'events_category' 	=> 'uncategorized',
    );
    public static $tabs = array();
    public static function init() {
      load_theme_textdomain( 'college-green', get_template_directory() );
	   	self::$options['footer_text'] = __( 'Copyright @ %3$s by <a href="%1$s">%2$s</a>.', 'College_Green' );
		add_action( 'wp_head', 			  		array( 'College_Green', 'head' ) );
		add_action( 'wp_enqueue_scripts', 		array( 'College_Green', 'styles' ) );
		add_action( 'wp_enqueue_scripts', 		array( 'College_Green', 'scripts' ) );
		add_image_size( 'thumbnail-news',  100, 100, true );
		add_image_size( 'full-news',  750, 422, true );
		add_image_size( 'slider',  1140, 350, true );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		// add_filter( 'pre_option_link_manager_enabled', '__return_true' );

		add_shortcode( 'cg_tab', 	array( 'College_Green', 'cg_tab' ) );
		add_shortcode( 'cg_tabs', 	array( 'College_Green', 'cg_tabs' ) );

		require_once( 'includes/navwalker.php' );
		register_nav_menu( 'primary', __( 'Primary Menu', 'college-green' ) );
		add_filter( 'nav_menu_css_class', 		array( 'College_Green', 'menu_css'), 	  10, 3 );
		add_filter( 'widget_nav_menu_args',		array( 'College_Green', 'menu_args'), 	  10, 3 );
		add_filter( 'wp_nav_menu_objects',		array( 'College_Green', 'menu_items'), 	  10, 2 );
		// nav_menu_link_attributes
		add_filter( 'body_class', 				array( 'College_Green', 'body_class' ), 999 );

		add_filter( 'excerpt_length', 			array( 'College_Green', 'excerpt_length' ), 999 );
		add_filter( 'excerpt_more', 			array( 'College_Green', 'excerpt_more' ), 999 );

		add_filter( 'get_the_archive_title',	array( 'College_Green', 'archive_title' ) );
		add_filter( 'archive_template',			array( 'College_Green', 'archive_template' ) );
		add_filter( 'single_template',			array( 'College_Green', 'single_template' ) );
		add_filter( 'pre_get_posts',			array( 'College_Green', 'archive_query' ) );

		self::sidebar( array(
			'name'	=> __( 'Left Sidebar', 'college-green' ),
			'id'    => 'left',
		) );
		self::sidebar( array(
			'name'	=> __( 'Right Sidebar', 'college-green' ),
			'id'    => 'right',
		) );
		self::sidebar( array(
			'name'	=> __( 'Archive Sidebar', 'college-green' ),
			'id'    => 'archive',
		) );
		self::sidebar( array(
			'name'	=> __( 'Single Post Sidebar', 'college-green' ),
			'id'    => 'single',
		) );
		self::sidebar( array(
			'name'	=> __( 'Footer 1 Sidebar', 'college-green' ),
			'id'    => 'footer-1',
			'before_widget' => '<div id="%1$s" class="footer-col-inner %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		self::sidebar( array(
			'name'	=> __( 'Footer 2 Sidebar', 'college-green' ),
			'id'    => 'footer-2',
			'before_widget' => '<div id="%1$s" class="footer-col-inner %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		self::sidebar( array(
			'name'	=> __( 'Footer 3 Sidebar', 'college-green' ),
			'id'    => 'footer-3',
			'before_widget' => '<div id="%1$s" class="footer-col-inner %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		require_once( get_template_directory().'/includes/options.php' );
		self::init_settings();
    }
    public static function cg_tabs( $attr, $content ) {
    	self::$tabs = array();
    	$content = do_shortcode( $content );
    	if ( 0 < sizeof(self::$tabs) ) {
    		$tabs  = '<div class="tabbed-info page-row">';
    		$tabs .= '<ul class="nav nav-tabs">';
	    	$active_flag = false;
            foreach ( self::$tabs as $id => $title ) {
            	$active = $active_flag ? '' : ' class="active"';
	    		$tabs .= "<li{$active}><a href=\"#{$id}\" data-toggle=\"tab\">{$title}</a></li>";
	    		$active_flag = true;
            }
    		$tabs .= '</ul>';
    		$tabs .= '<div class="tab-content">';
    		$tabs .= $content;
    		$tabs .= '</div>';
    		$tabs .= '</div>';
    		$content = $tabs;
    	}
		return $content;
    }
    public static function cg_tab( $attr, $content ) {
    	if ( !isset( $attr['title'] ) ) {
    		return do_shortcode($content);
    	} else {
    		$slug = sanitize_title( $attr['title'] );
    		self::$tabs[$slug] = $attr['title'];
    		$active = 1 === sizeof( self::$tabs ) ? ' active' : '';
    		$content = do_shortcode($content);
    		$content = "<div class=\"tab-pane{$active}\" id=\"{$slug}\">{$content}</div>";
    		return $content;
    	}
    }

    public static function archive_title( $title ) {
    	if( is_category() ) {
	        $title = single_cat_title( '', false );
	    }
	    return $title;
    }
    public static function single_template( $template ) {
    	if( in_category( College_Green::get_option( 'events_category' ) ) ) {
    		$events_template = locate_template('single-event.php');
    		if ($events_template) {
    			$template = $events_template;
    		}
	    }
	    return $template;
    }
    public static function archive_template( $template ) {
    	if( is_category( College_Green::get_option( 'events_category' ) ) ) {
    		$events_template = locate_template('archive-event.php');
    		if ($events_template) {
    			$template = $events_template;
    		}
	    }
	    return $template;
    }
    public static function archive_query( $query ) {
    	if( $query->is_category( College_Green::get_option( 'events_category' ) ) ) {
    		$meta_query = $query->get( 'meta_query' );
    		$meta_query[] =	array(
				'key' => 'tinyevents_start',
				'compare' => 'EXISTS',
	    	);
    		$query->set( 'meta_query', $meta_query );
		}
	    return $query;
    }
    public static function init_settings() {
    	$cats = get_categories();
    	$categories =  array();
    	foreach ($cats as $key => $value) {
    		$categories[$value->slug] = $value->name;
    	}
		$settings = array(
			'college-green' => array(
				'title' 		=> __( 'College Green Settings',  'college-green' ),
				'description' 	=> __( 'Basic theme settings', 'college-green' ),
				'priority' 		=> 31,
				'fields' 		=> array(
					'news_category' 		=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['news_category'],
						),
						'control' 	=> array(
							'label' 	=> __( 'News Category', 'college-green' ),
							'choices'	=> $categories,
						),
						'type' 		=> 'select',
					),
					'slider_category' 		=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['slider_category'],
						),
						'control' 	=> array(
							'label' 	=> __( 'Slider Category', 'college-green' ),
							'choices'	=> $categories,
						),
						'type' 		=> 'select',
					),
					'events_category' 		=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['events_category'],
						),
						'control' 	=> array(
							'label' 	=> __( 'Events Category', 'college-green' ),
							'choices'	=> $categories,
						),
						'type' 		=> 'select',
					),
				),
			),
			'college-green_footer' => array(
				'title' 		=> __( 'Footer Settings',  'college-green' ),
				'description' 	=> __( 'Open theme footer settings', 'college-green' ),
				'priority' 		=> 31,
				'fields' 		=> array(
					'footer_text' 	=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['footer_text'],
						),
						'control' 	=> array(
							'label' 	=> __( 'Footer text', 'college-green' ),
						),
						'type' 		=> 'text',
					),
					'footer_link' 	=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['footer_link'],
						),
						'control' 	=> array(
							'label' 	=> __( 'Footer link', 'college-green' ),
						),
						'type' 		=> 'url',
					),
					'footer_name' 	=> array(
						'setting' 		=> array(
							'default' 		=> self::$options['footer_name'],
						),
						'control' 	=> array(
							'label' 	=> __( 'Footer name', 'college-green' ),
						),
						'type' 		=> 'text',
					),
				),
			),
		);
		College_Green_options::init( $settings );
		// // Setup the Theme Customizer settings and controls...
		add_action( 'customize_register' , 	array( 'College_Green_options' , 'register' ) );
		// // Output custom CSS to live site
		add_action( 'wp_head' , 			array( 'College_Green_options' , 'header_output' ) );
		// // Enqueue live preview javascript in Theme Customizer admin screen
		// add_theme_support( 'automatic-feed-links' );
    }
    public static function body_class( $classes ) {
    	if ( is_front_page() ) {
    		$classes[] = 'home-page';
    	}
    	return $classes;
    }
    public static function excerpt_length( $length ) {
    	if ( is_front_page() ) {
    		$length = 20;
    	}
    	return $length;
    }
    public static function excerpt_more( $more ) {
    	if ( is_front_page() ) {
    		$more = '';
    	}
    	return $more;
    }
    public static function menu_items ($items, $args) {
    	if ( '' === $args->theme_location ) {
    		foreach( $items as $key => $item ) {
    			$items[$key]->title = '<i class="fa fa-caret-right"></i>' . $item->title;
    		}
    	}
    	return $items;
    }
    public static function menu_args ( $nav_menu_args, $nav_menu, $args ) {
    	$nav_menu_args['container'] = false;
    	$nav_menu_args['menu_class'] = '';
		return $nav_menu_args;
    }
    public static function menu_css ( $classes, $item, $args ) {
    	if ( 'primary' === $args->theme_location ) {
			$classes[] = 'nav-item';
    	}
		return $classes;
    }
    public static function widgets() {
		require_once( 'includes/widget-links.php' );
		register_widget( "WP_Widget_CG_Links" );
		require_once( 'includes/widget-footer-contact.php' );
		register_widget( "WP_Widget_CG_Contacts" );
		if ( class_exists('tinyEvents') ) {
			require_once( 'includes/widget-events.php' );
			register_widget( "WP_Widget_CG_Events" );
		}
    }
    public static function sidebar( $args=array() ) {
    	$defaults = array(
			'name'          => __( 'Sidebar', 'college-green' ),
			'id'            => 'sidebar',
			'description'   => __( 'A sidebar', 'college-green' ),
		    'class'         => '',
			'before_widget' => '<section id="%1$s" class="%2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="section-heading text-highlight"><span class="line">',
			'after_title'   => '</h1>',
		);
		$args = wp_parse_args( $args, $defaults );
    	register_sidebar( $args );
    }
    public static function head() {
		$tags = array(
			'meta-charset'      => '<meta charset="'.esc_attr( get_bloginfo( 'charset' ) ).'">',
			'meta-ie-edge'      => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
			'meta-description'  => '<meta name="description" content="'.esc_attr( get_bloginfo( 'description' ) ).'">',
			'meta-viewport'     => '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>',
			// 'favicon'           => '<link rel="shortcut icon" href="'.self::get_option( 'favicon' ).'" type="image/x-icon" />',
		);
		$tags = apply_filters( 'college-green_head', $tags );
		$result = implode( "\n\t\t", $tags );
		$result = "\t\t".$result."\n";
		echo $result;
    }
    public static function scripts() {
        wp_register_script( 'bootstrap', 			get_template_directory_uri()."/assets/plugins/bootstrap/js/bootstrap.min.js" );
        wp_register_script( 'bootstrap-hover', 		get_template_directory_uri()."/assets/plugins/bootstrap-hover-dropdown.min.js" );
        wp_register_script( 'back-to-top', 			get_template_directory_uri()."/assets/plugins/back-to-top.js" );
        wp_register_script( 'jquery-placeholder', 	get_template_directory_uri()."/assets/plugins/jquery-placeholder/jquery.placeholder.js" );
        wp_register_script( 'pretty-photo', 		get_template_directory_uri()."/assets/plugins/pretty-photo/js/jquery.prettyPhoto.js" );
        wp_register_script( 'flexslider', 			get_template_directory_uri()."/assets/plugins/flexslider/jquery.flexslider-min.js" );
        wp_register_script( 'jflickrfeed', 			get_template_directory_uri()."/assets/plugins/jflickrfeed/jflickrfeed.min.js" );
        wp_register_script( 'college-green', 	get_template_directory_uri()."/assets/js/main.js", array('jquery','bootstrap','bootstrap-hover','flexslider','back-to-top','jquery-placeholder','pretty-photo','jflickrfeed'), false, true );
		wp_enqueue_script( 'college-green' );
    }
    public static function styles() {
		wp_register_style( 'college-green-font',  	'//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin-ext,latin' );
		wp_register_style( 'bootstrap', 			get_template_directory_uri().'/assets/plugins/bootstrap/css/bootstrap.min.css' );
		wp_register_style( 'fontawesome', 			get_template_directory_uri().'/assets/plugins/font-awesome/css/font-awesome.css' );
		wp_register_style( 'flexslider', 			get_template_directory_uri().'/assets/plugins/flexslider/flexslider.css' );
		wp_register_style( 'pretty-photo', 			get_template_directory_uri().'/assets/plugins/pretty-photo/css/prettyPhoto.css' );
		wp_register_style( 'college-green', 		get_template_directory_uri().'/assets/css/styles-green.css', array('college-green-font','bootstrap','fontawesome','pretty-photo','flexslider') );
		wp_enqueue_style( 'college-green' );
    }
    public static function get_option( $key ) {
    	return get_theme_mod( $key, false ) ? get_theme_mod( $key, false ) : self::$options[$key];
    }

    public static function pagination( $args = array() ) {
	    $defaults = array(
	        'range'           => 4,
	        'custom_query'    => FALSE,
	        'leading_zeros'	  => 0,
	        'first_last'	  => false,
	        'previous_string' => __( '<i class="glyphicon glyphicon-chevron-left"></i>', 'college-green' ),
	        'next_string'     => __( '<i class="glyphicon glyphicon-chevron-right"></i>', 'college-green' ),
	        'before_output'   => '<div class="post-nav"><ul class="pager">',
	        'after_output'    => '</ul></div>'
	    );

	    $args = wp_parse_args(
	        $args,
	        apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
	    );

	    $args['range'] = (int) $args['range'] - 1;
	    if ( !$args['custom_query'] )
	        $args['custom_query'] = @$GLOBALS['wp_query'];
	    $count = (int) $args['custom_query']->max_num_pages;
	    $page  = intval( get_query_var( 'paged' ) );
	    $ceil  = ceil( $args['range'] / 2 );

	    if ( $count <= 1 )
	        return FALSE;

	    if ( !$page )
	        $page = 1;

	    if ( $count > $args['range'] ) {
	        if ( $page <= $args['range'] ) {
	            $min = 1;
	            $max = $args['range'] + 1;
	        } elseif ( $page >= ($count - $ceil) ) {
	            $min = $count - $args['range'];
	            $max = $count;
	        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
	            $min = $page - $ceil;
	            $max = $page + $ceil;
	        }
	    } else {
	        $min = 1;
	        $max = $count;
	    }

	    $echo = '';
	    $previous = intval($page) - 1;
	    $previous = esc_attr( get_pagenum_link($previous) );

	    $firstpage = esc_attr( get_pagenum_link(1) );
	    if ( $firstpage && (1 != $page) && $args['first_last'] )
	        $echo .= '<li class="previous"><a href="' . $firstpage . '">' . __( 'First', 'college-green' ) . '</a></li>';
	    if ( $previous && (1 != $page) )
	        $echo .= '<li><a href="' . $previous . '" title="' . __( 'previous', 'college-green') . '">' . $args['previous_string'] . '</a></li>';

	    if ( !empty($min) && !empty($max) ) {
	        for( $i = $min; $i <= $max; $i++ ) {
	            if ($page == $i) {
	                $echo .= '<li class="active"><span class="active">' . str_pad( (int)$i, $args['leading_zeros']+1, '0', STR_PAD_LEFT ) . '</span></li>';
	            } else {
	                $echo .= sprintf( '<li><a href="%s">%s</a></li>', esc_attr( get_pagenum_link($i) ), str_pad( (int)$i, $args['leading_zeros']+1, '0', STR_PAD_LEFT ) );
	            }
	        }
	    }

	    $next = intval($page) + 1;
	    $next = esc_attr( get_pagenum_link($next) );
	    if ($next && ($count != $page) )
	        $echo .= '<li><a href="' . $next . '" title="' . __( 'next', 'college-green') . '">' . $args['next_string'] . '</a></li>';

	    $lastpage = esc_attr( get_pagenum_link($count) );
	    if ( $lastpage  && $args['first_last'] ) {
	        $echo .= '<li class="next"><a href="' . $lastpage . '">' . __( 'Last', 'college-green' ) . '</a></li>';
	    }
	    if ( isset($echo) )
	        echo $args['before_output'] . $echo . $args['after_output'];
	}
    public static function _l( $url ) {
    	echo get_template_directory_uri().'/'.$url;
    }
    public static function _rand_img( $slug, $count, $extension = 'jpg' ) {
    	$no =  mt_rand(1,$count);
    	self::_l('assets/images/'.$slug.'-'.$no.'.'.$extension);
    }

}
?>
