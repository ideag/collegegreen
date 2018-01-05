<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="wrapper">
            <!-- ******HEADER****** -->
            <header class="header">
                <!-- <div class="top-bar">
                    <div class="container">
                        <ul class="social-icons col-md-6 col-sm-6 col-xs-12 hidden-xs">
                            <li><a href="#" ><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" ><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" ><i class="fa fa-youtube"></i></a></li>
                            <li><a href="#" ><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#" ><i class="fa fa-google-plus"></i></a></li>
                            <li class="row-end"><a href="#" ><i class="fa fa-rss"></i></a></li>
                        </ul>
                        <form class="pull-right search-form" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search the site...">
                            </div>
                            <button type="submit" class="btn btn-theme">Go</button>
                        </form>
                    </div>
                </div> -->
                <div class="header-main container">
                    <h1 class="logo col-md-4 col-sm-4">
                        <a href="<?php bloginfo( 'url' ); ?>"><img id="logo" src="<?php College_Green::_l('assets/images/md_logo.png'); ?>" alt="<?php bloginfo( 'title' ); ?>" style="max-width:200px;"></a>
                    </h1>
                    <div class="info col-md-8 col-sm-8">
                        <ul class="menu-top navbar-right hidden-xs">
<!--                             <li class="divider"><a href="index.html">Home</a></li>
                            <li class="divider"><a href="faq.html">FAQ</a></li> -->
                            <li><?php echo apply_filters( 'green_college_language_link', '<a href="http://en.media.kauko.lt">English</a>' ); ?></li>
                        </ul><!--//menu-top-->
                        <br />
                        <!-- <div class="contact pull-right">
                            <p class="phone"><i class="fa fa-phone"></i>Call us today 0800 123 4567</p>
                            <p class="email"><i class="fa fa-envelope"></i><a href="#">enquires@website.com</a></p>
                        </div> -->
                    </div><!--//info-->
                </div><!--//header-main-->
            </header><!--//header-->
           <nav class="main-nav" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="sr-only"><?php _e( 'Toggle navigation', 'college-green' ); ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <?php wp_nav_menu( array(
                        'theme_location'    => 'primary',
                        'fallback_cb'       => false,
                        'container_class'   => 'navbar-collapse collapse',
                        'container_id'      => 'navbar-collapse',
                        'menu_class'        => 'nav navbar-nav',
                        'walker'            => new wp_bootstrap_navwalker(),
                    ) ); ?>
                </div>
            </nav>
