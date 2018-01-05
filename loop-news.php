                <section class="news">
                    <h1 class="section-heading text-highlight"><span class="line"><?php _e( 'Latest News', 'college-green' ); ?></span></h1>     
                    <div class="carousel-controls">
                        <a class="prev" href="#news-carousel" data-slide="prev"><i class="fa fa-caret-left"></i></a>
                        <a class="next" href="#news-carousel" data-slide="next"><i class="fa fa-caret-right"></i></a>
                    </div><!--//carousel-controls--> 
                    <div class="section-content clearfix">
                        <div id="news-carousel" class="news-carousel carousel slide">
                            <div class="carousel-inner">
                                <div class="item active">
<?php 
$total = 9;
$my_query = new WP_Query( array(
    'category_name' => College_Green::get_option('news_category'),
    'posts_per_page'=> $total 
) );
if ( $my_query->have_posts() ) :
    $count = 0;
    while ( $my_query->have_posts() ) : 
        $my_query->the_post(); 
?>
                                    <div class="col-md-4 news-item">
                                        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'thumbnail-news', array( 'class' => 'thumb' ) ); ?>
<?php else : ?>
                                        <img class="thumb" src="<?php College_Green::_l('assets/images/news/news-thumb-'.($count % 3 + 1).'.jpg' ); ?>"  alt="" />
<?php endif; ?>
                                        <?php the_excerpt(); ?>
                                        <a class="read-more" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'college-green' ); ?><i class="fa fa-chevron-right"></i></a>                
                                    </div><!--//news-item-->
<?php
        ++$count;
        if ( 0 == $count % 3 && $count < $total ) :
?>
                                </div><!--//item-->
                                <div class="item"> 
<?php
        endif;
    endwhile; 
endif; 
?>
                                </div><!--//item-->
                            </div><!--//carousel-inner-->
                        </div><!--//news-carousel-->  
                    </div><!--//section-content-->     
                </section><!--//news-->
