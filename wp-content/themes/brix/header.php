    <?php
/**
 * The header for our theme.
 *
 *
 * @package WordPress
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <?php //<meta name="viewport" content="width=device-width, initial-scale=1.0" /> ?>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php wp_head(); //mandatory ?>
    <?php //get_template_part('templates/parts/header', 'analytics'); ?>
</head>

<body <?php body_class('page-'.$post->post_name); ?>>
<div class="wrap-all-the-things">
    <header class="main-head margins-off">
        <div class="horiz x2">  
          <div class="callout">
            <p class="uppercase">Apartments</br>Starting at $2,350</p>
          </div>
          <div class="utility-nav horiz h4">
            <a href="#" class="btn secondary">Apply</a>
            <a href="#" class="btn secondary">Residents</a>
            <a href="#" class="phone"> &mdash; &nbsp; 516.758.4200</a>
          </div>
        </div>
        <div class="main-head__inner content-width">
            <div class="main-head__nav horiz x3">
                <?php
                $nav_left = array(
                  'theme_location'  => 'head-menu-left',
                  'container'       => 'nav',
                  'container_class' => 'nav header-nav-left',
                  'menu_class'      => 'menu horiz space-between h3',
                  'depth'           => 1,
                  'fallback_cb'     => false,
                );
                    wp_nav_menu($nav_left);
                ?>
                <figure class="logo">
                  <img src="<?= get_stylesheet_directory_uri();?>/assets/images/Logo-01.png" alt="">
                </figure>
                <?php
                $nav_right = array(
                  'theme_location'  => 'head-menu-right',
                  'container'       => 'nav',
                  'container_class' => 'nav header-nav-right',
                  'menu_class'      => 'menu horiz space-between h3',
                  'depth'           => 1,
                  'fallback_cb'     => false,
                );
                    wp_nav_menu($nav_right);
                ?>
            </div>
        </div> <!-- //__inner -->
    </header> <!-- //main-head -->
