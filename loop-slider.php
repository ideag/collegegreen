                <div id="promo-slider" class="slider flexslider">
                    <ul class="slides">
<?php 
$my_query = new WP_Query( array(
    'category_name' => College_Green::get_option('slider_category'),
    'posts_per_page'=> 5 
) );
if ( $my_query->have_posts() ) :
    $count = 0;
    while ( $my_query->have_posts() ) : 
        $my_query->the_post(); 
?>
                        <li>
<?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'slider' ); ?>
<?php else : ?>
                            <img src="<?php College_Green::_rand_img('slides/slide', 4, 'jpg' ); ?>"  alt="" />
<?php endif; ?>
                            <p class="flex-caption">
                                <span class="main" ><?php the_title(); ?></span>
                                <br />
                                <span class="secondary clearfix" ><?php echo get_the_excerpt(); ?></span>
                            </p>
                        </li>
<?php
    endwhile; 
endif; 
?>
                    </ul>
                </div>
