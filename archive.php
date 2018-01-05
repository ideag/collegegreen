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
                        <div class="news-wrapper col-md-8 col-sm-7">
<?php 
if ( have_posts() ) :
    while ( have_posts() ) : 
        the_post(); 
?>
                            <article class="news-item page-row has-divider clearfix row">       
                                <figure class="thumb col-md-2 col-sm-3 col-xs-4">
<?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'thumbnail-news', array( 'class' => 'img-responsive' ) ); ?>
<?php else : ?>
                                        <img class="img-responsive" src="<?php College_Green::_l('assets/images/news/news-thumb-'.($count % 3 + 1).'.jpg' ); ?>"  alt="" />
<?php endif; ?>
                                </figure>
                                <div class="details col-md-10 col-sm-9 col-xs-8">
                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php the_excerpt(); ?>
                                    <a class="btn btn-theme read-more" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'college-green' ); ?><i class="fa fa-chevron-right"></i></a>
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