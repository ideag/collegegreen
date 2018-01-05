<?php get_header(); ?>
    
        <!-- ******CONTENT****** --> 
        <div class="content container">
            <div class="page-wrapper">
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left"><?php the_archive_title(); ?></h1>
                    <div class="breadcrumbs pull-right">
<?php get_template_part( 'part', 'breadcrumb' ); ?>
                    </div>
                </header> 
                <div class="page-content">
                    <div class="row page-row">
                        <div class="events-wrapper col-md-8 col-sm-7">
<?php 
if ( have_posts() ) :
    while ( have_posts() ) : 
        the_post(); 
        $event = $post;
        $title = get_post_meta( $event->ID, 'tinyevents_title', true) ;
        if ( !$title ) {
            $title = get_the_title($event);
        }
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
?>
                            <article class="events-item page-row has-divider clearfix">
                                <div class="date-label-wrapper col-md-1 col-sm-2">
                                    <p class="date-label">
                                        <span class="month"><?php echo $month; ?></span>
                                        <span class="date-number"><?php echo $day; ?></span>
                                    </p>
                                </div><!--//date-label-wrapper-->

                                <div class="details col-md-11 col-sm-10">
                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h3>
                                    <p class="meta">
                                      <span class="time"><i class="fa fa-clock-o"></i><?php echo $start; ?></span>
                                      <span class="time"><i class="fa fa-clock-o"></i><?php echo $end; ?></span>
                                      <span class="location"><i class="fa fa-map-marker"></i><?php echo $place; ?></span>
                                    </p>  
                                    <p class="desc"><?php echo get_the_excerpt(); ?></p>                       
<!--                                     <a class="btn btn-theme read-more" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'college-green' ); ?><i class="fa fa-chevron-right"></i></a> -->
                                </div>
                            </article>
<?php
    endwhile; 
endif; 
?>
<?php College_Green::pagination(array(
            'before_output'   => '<ul class="pagination">',
            'after_output'    => '</ul>'    
)); ?>                            
                        </div>
                        <aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1">      
<?php dynamic_sidebar( 'archive' ); ?> 
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>