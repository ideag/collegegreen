<?php get_header(); ?>    
        <!-- ******CONTENT****** --> 
        <div class="content container">
            <div class="page-wrapper">
<?php 
if ( have_posts() ) :
    while ( have_posts() ) : 
        the_post(); 
?>
                <header class="page-heading clearfix">
                    <h1 class="heading-title pull-left"><?php the_title(); ?></h1>
                    <div class="breadcrumbs pull-right">
<?php get_template_part( 'part', 'breadcrumb' ); ?>
                    </div>
                </header> 
                <div class="page-content">
                    <div class="row page-row">
                        <div class="news-wrapper col-md-8 col-sm-7">                         
                            <article class="news-item">
                                <p class="meta text-muted"><?php _e( 'By:', 'college-green' ); ?> <?php the_author(); ?> | <?php _e( 'Posted on:', 'college-green' ); ?> <?php the_date(); ?></p>
                                <p class="featured-image">
<?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'full-news', array( 'class' => 'img-responsive' ) ); ?>
<?php endif; ?>
                                <?php the_content(); ?>
                            </article><!--//news-item-->
                        </div><!--//news-wrapper-->
                        <aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">                    
                            <?php dynamic_sidebar( 'single' ); ?> 
                        </aside>
                    </div><!--//page-row-->
                </div><!--//page-content-->
<?php
    endwhile; 
endif; 
?>
            </div><!--//page--> 
        </div><!--//content-->
    </div><!--//wrapper-->
<?php get_footer(); ?>