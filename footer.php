        <!-- ******FOOTER****** --> 
        <footer class="footer">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                    <div class="footer-col col-md-3 col-sm-4 about">
                        <?php dynamic_sidebar( 'footer-1' ); ?>

                    </div><!--//foooter-col-->
                    <div class="footer-col col-md-6 col-sm-8 newsletter">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div><!--//foooter-col-->
                    <div class="footer-col col-md-3 col-sm-12 contact">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div><!--//foooter-col-->
                    </div>
                </div>
            </div><!--//footer-content-->
            <div class="bottom-bar">
                <div class="container">
                    <div class="row">
                        <small class="copyright col-md-6 col-sm-12 col-xs-12"><?php printf( College_Green::get_option( 'footer_text' ), College_Green::get_option( 'footer_link' ), College_Green::get_option( 'footer_name' ), '2011'.(2011 < date('Y') ? ( '-' . date('Y') ) : '' ) ); ?></small>
                        <ul class="social pull-right col-md-6 col-sm-12 col-xs-12">
<!--                             <li><a href="#" ><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" ><i class="fa fa-youtube"></i></a></li>
                            <li><a href="#" ><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#" ><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#" ><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#" ><i class="fa fa-skype"></i></a></li>  -->
                            <li><a href="mailto:md@kauko.lt" ><i class="fa fa-envelope"></i></a></li>
                            <li><a href="https://www.facebook.com/medijutechnologiju.katedra" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li class="row-end"><a href="<?php bloginfo('rss2_url'); ?>" ><i class="fa fa-rss"></i></a></li>
                        </ul><!--//social-->
                    </div><!--//row-->
                </div><!--//container-->
            </div><!--//bottom-bar-->
        </footer><!--//footer-->
        <?php wp_footer(); ?>
    </body>
</html>
