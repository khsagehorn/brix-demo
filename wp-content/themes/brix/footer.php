<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the wrap div and all content
 *
 * @package WordPress
 * @subpackage Zemplate
 * @since Zemplate 1.0
 */
?>

    <footer class="main-foot">
        <div class="main-foot__nav content-width">
            <div class="nav__inner horiz margins-off">
              <figure class="logo">
                <img src="<?= get_stylesheet_directory_uri();?>/assets/images/Logo-01.png" alt="">
              </figure>
                <?php
                    $attr = array(
                        'theme_location'  => 'foot-menu',
                        'container'       => 'nav',
                        'container_class' => 'foot-nav',
                        'menu_class'      => 'menu horiz'
                    );
                    wp_nav_menu($attr);
                ?>
            </div>
        </div>
    </footer><!-- // main-foot -->
<!-- sticky footer will fail if anything goes between the closing footer and .wrap -->
</div><!-- // wrap-all-the-things -->

<?php wp_footer(); //mandatory ?>

</body>
</html>
