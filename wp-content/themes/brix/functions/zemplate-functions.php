<?php
/*
 * @package WordPress
 * @subpackage Zemplate
 * @since Zemplate 3.0
 */

/*------------------------------------*\
    //Zemplate Setup
\*------------------------------------*/
//Usage: don't touch
//Descript: Sets up some automatic things from twenty* themes.

function zemplate_setup() {
    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
}
add_action('after_setup_theme', 'zemplate_setup');

/*------------------------------------*\
    //Menu Registration
\*------------------------------------*/
function setup_menus(){
    register_nav_menu('head-menu-left', 'Header Menu - Left');
    register_nav_menu('head-menu-right', 'Header Menu - Right');
    register_nav_menu('foot-menu', 'Footer Menu');
}
add_action('after_setup_theme', 'setup_menus');

/*------------------------------------*\
    //Bloginfo Shortcode
\*------------------------------------*/
//Usage: [bloginfo key='name']

function bloginfo_shortcode($atts) {
    extract(shortcode_atts(array(
        'key' => '',
    ), $atts));
    return ($key == 'url' ? home_url() : get_bloginfo($key));
}
add_shortcode('bloginfo', 'bloginfo_shortcode');

/*------------------------------------*\
    //Password Form Text
\*------------------------------------*/
function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <label for="' . $label . '">' . __( "Password:<br>" ) . ' </label><input class="password__box" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><br><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    </form>';
    return $o;
}
add_filter( 'the_password_form', 'my_password_form' );

/*------------------------------------*\
    //WP Navmenu Shortcode
\*------------------------------------*/
//Usage: [wpnavmenu menu='menuname' menu_class='page_menu']
//Descript: Returns our Wordpress menu inside page content

function wp_nav_menu_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'menu'            => '',
        'container'       => 'div',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => '',
        'theme_location'  => ''),
        $atts));

    return wp_nav_menu(array(
        'menu'            => $menu,
        'container'       => $container,
        'container_class' => $container_class,
        'container_id'    => $container_id,
        'menu_class'      => $menu_class,
        'menu_id'         => $menu_id,
        'echo'            => false,
        'fallback_cb'     => $fallback_cb,
        'before'          => $before,
        'after'           => $after,
        'link_before'     => $link_before,
        'link_after'      => $link_after,
        'depth'           => $depth,
        'walker'          => $walker,
        'theme_location'  => $theme_location));
}
add_shortcode("wpnavmenu", "wp_nav_menu_shortcode");

/*------------------------------------*\
    //Continue Reading Link
\*------------------------------------*/

function excerpt_read_more_link($output) {
    global $post;
    return $output . ' <a href="'. get_permalink() . '">' . __('&hellip;read more') . '</a>';
}
add_filter('get_the_excerpt', 'excerpt_read_more_link');

/*------------------------------------*\
    //Gets rid of that stupid [...].
\*------------------------------------*/
function replace_excerpt($content) {
       return str_replace('[&hellip;]',
               ' ',
               $content
      );
}
add_filter('the_excerpt', 'replace_excerpt');

/*------------------------------------*\
    //More Control over Comments
\*------------------------------------*/
//Usage: <?php wp_list_comments('type=comment&callback=mytheme_comment'); ? >
//Descript: Overrides wp_list_comments

function zemplate_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    if ('div' == $args['style']) {
        $tag = '<div>';
        $add_below = 'comment';
    } else {
        $tag = '<li>';
        $add_below = 'div-comment';
    }

    echo '<li id="comment-'.get_comment_ID().'">';

    if ('div' != $args['style']):
        echo '<div id="div-comment-'.get_comment_ID().'" class="comment__body">';
    endif;

    echo '<div class="comment__meta">';
    echo '<div class="comment__author vcard">';
    if ($args['avatar_size'] != 0):
        echo get_avatar($comment, $args['avatar_size']);
        echo get_comment_author_link();
    echo '</div>';
    endif;

    if ($comment->comment_approved == '0'):
        echo '<em class="comment-awaiting-moderation"> Your comment is awaiting moderation. </em>';
    endif;

    echo '<div class="comment__date commentmetadata">';
        echo get_comment_date();
        echo get_comment_time();
        echo edit_comment_link(__('(Edit)'),'  ','');
    echo '</div>';
    echo '</div>';

    comment_text();

    echo '<div class="reply">';
    comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])));
    echo '</div>';

    if ('div' != $args['style']):
        echo '</div>';
    endif;
}


/*------------------------------------*\
    //Custom Search
\*------------------------------------*/
function custom_search($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <div class="search-wrap">
        <input type="search" placeholder="Search" value="' . get_search_query() . '" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';
    return $form;
}
add_filter('get_search_form', 'custom_search');


if(!is_admin()){
    add_action('init', 'add_cat_to_archives');
}

function add_cat_to_archives(){
    /**
     * Changes the WHERE clause for wp_get_archives to select only posts for the categories in the
     * 'cat' parameter.
     *
     * @param String $where
     *             a SQL WHERE clause.
     * @param Array $args
     *             arguments passed to the wp_get_archives() function.
     *
     * @return String
     *             modified SQL WHERE clause with additional selection by category if $args contains a
     *             parameter called cat.
     */

    function kwebble_getarchives_where_for_category($where, $args = null){
        global $kwebble_getarchives_data, $wpdb;
        if ($args !== null && isset($args['cat'])){
            // Preserve the category for later use.
            // Preserve the category for later use.
            $kwebble_getarchives_data['cat'] = $args['cat'];
            // Split 'cat' parameter in categories to include and exclude.
            $allCategories = explode(',', $args['cat']);
            // Element 0 = included, 1 = excluded.
            $categories = array(array(), array());
            foreach ($allCategories as $cat) {
                if (strpos($cat, ' ') !== FALSE) {
                    // Multi category selection.
                }
                $idx = $cat < 0 ? 1 : 0;
                $categories[$idx][] = abs($cat);
            }
            $includedCatgories = implode(',', $categories[0]);
            $excludedCatgories = implode(',', $categories[1]);
            // Add SQL to perform selection.
            if (get_bloginfo('version') < 2.3){
                $where .= " AND $wpdb->posts.ID IN (SELECT DISTINCT ID FROM $wpdb->posts JOIN $wpdb->post2cat post2cat ON post2cat.post_id=ID)";
                if (!empty($includedCatgories)) {
                    $where .= " AND post2cat.category_id IN ($includedCatgories)";
                }
                if (!empty($excludedCatgories)) {
                    $where .= " AND post2cat.category_id NOT IN ($excludedCatgories)";
                }
                $where .= ')';
            } else{
                $where .= ' AND ' . $wpdb->prefix . 'posts.ID IN (SELECT DISTINCT ID FROM ' . $wpdb->prefix . 'posts'
                        . ' JOIN ' . $wpdb->prefix . 'term_relationships term_relationships ON term_relationships.object_id = ' . $wpdb->prefix . 'posts.ID'
                        . ' JOIN ' . $wpdb->prefix . 'term_taxonomy term_taxonomy ON term_taxonomy.term_taxonomy_id = term_relationships.term_taxonomy_id'
                        . ' WHERE term_taxonomy.taxonomy = \'category\'';
                if (!empty($includedCatgories)) {
                    $where .= " AND term_taxonomy.term_id IN ($includedCatgories)";
                }
                if (!empty($excludedCatgories)) {
                    $where .= " AND term_taxonomy.term_id NOT IN ($excludedCatgories)";
                }
                $where .= ')';
            }
        }
        return $where;
    }
    /*
     * Changes the archive link to include the categories from the 'cat' parameter.
     *
     * @param String
     *             $url the generated URL for an archive.
     *
     * @return String
     *             modified URL that includes the category.
     */
    function kwebble_archive_link_for_category($url){
        global $kwebble_getarchives_data;

        if (isset($kwebble_getarchives_data['cat'])){
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= 'cat=' . $kwebble_getarchives_data['cat'];
        }
        return $url;
    }
    /*
     * Add the filters.
     */
    // Prevent error if executed outside WordPress.
    if (function_exists('add_filter')){
        // Constants for form field and options.
        define('KWEBBLE_OPTION_DISABLE_CANONICAL_URLS', 'kwebble_disable_canonical_urls');
        define('KWEBBLE_GETARCHIVES_FORM_CANONICAL_URLS', 'kwebble_disable_canonical_urls');
        define('KWEBBLE_ENABLED', '');
        define('KWEBBLE_DISABLED', 'Y');
        add_filter('getarchives_where', 'kwebble_getarchives_where_for_category', 10, 2);
        add_filter('year_link', 'kwebble_archive_link_for_category');
        add_filter('month_link', 'kwebble_archive_link_for_category');
        add_filter('day_link', 'kwebble_archive_link_for_category');
        // Disable canonical URLs if the option is set.
        if (get_option(KWEBBLE_OPTION_DISABLE_CANONICAL_URLS) == KWEBBLE_DISABLED){
            remove_filter('template_redirect', 'redirect_canonical');
        }
    }
}

/*------------------------------------*\
    //Show Templates
\*------------------------------------*/

// /*
//  * Add a bar at the bottom of the page that shows the template being used.
//  */
// function show_template() {
//     global $template;
//     $style = '
//         background-color:rgba(0,0,0,1);
//         position:fixed;
//         bottom:0;
//         right:0;
//         left:0;
//         color:#fff;
//         opacity:.2;
//         padding:.5em;
//         font-size:.6em;
//     ';
//     echo '<div style="'.$style.'">'.$template.'</div>';
// }
// add_action('wp_footer', 'show_template');
