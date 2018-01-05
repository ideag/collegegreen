<?php get_header(); ?>
            <div class="content container">
<?php get_template_part( 'loop', 'slider' ); ?>
<?php get_template_part( 'loop', 'promo' ); ?>
<?php get_template_part( 'loop', 'news' ); ?>
                <div class="row cols-wrapper">
                    <div class="col-md-3">
<?php dynamic_sidebar( 'left' ); ?> 
                    </div>
                    <div class="col-md-6">
<?php //get_template_part( 'loop', 'finder' ); ?>
<?php get_template_part( 'loop', 'showcase' ); ?>
                    </div>
                    <div class="col-md-3">
<?php dynamic_sidebar( 'right' ); ?> 
                    </div>
                </div>
<?php //get_template_part( 'loop', 'awards' ); ?>
            </div>
        </div>
<?php get_footer(); ?>