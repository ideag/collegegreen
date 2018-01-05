<?php 
if ( have_posts() ) :
    while ( have_posts() ) : 
        the_post(); 
?>
                <section class="promo box box-dark">        
                    <div class="col-md-9">
                    	<h1 class="section-heading"><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>  
                    <div class="col-md-3">
                        <a class="btn btn-cta" href="#"><i class="fa fa-play-circle"></i>Apply Now</a>  
                    </div>
                </section>
<?php
    endwhile; 
endif; 
?>