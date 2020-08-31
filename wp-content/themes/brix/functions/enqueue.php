<?php

/*------------------------------------*\
    //Enqueues
		//CSS
		//Javascript
\*------------------------------------*/
$ver = '1.0'; // bump this number as necessary for cache busting
/*------------------------------------*\
    //Fonts
\*------------------------------------*/
wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css2?family=Bigshot+One&display=swap');
/*------------------------------------*\
    //CSS
\*------------------------------------*/
	function theme_styles(){
		wp_register_style( 'style', get_template_directory_uri() . '/assets/css/styles.css', array(), '1.4','screen, projection' );

		// enqueing:
		wp_enqueue_style( 'style' );
	}
	add_action('wp_enqueue_scripts', 'theme_styles');
	if($is_IE) {
		function ie_styles(){
			wp_register_style( 'ie', get_template_directory_uri() . '/css/ie.css', array(), '1.0','screen, projection' );

			// enqueing:
			wp_enqueue_style( 'ie' );
		}
		add_action('wp_enqueue_scripts', 'ie_styles');
	}
/*------------------------------------*\
    //Javascript
\*------------------------------------*/
// Register some javascript files, because we love javascript files. Enqueue a couple as well
// Reference: wp_register_script( $handle, $src, $deps, $ver, $in_footer );
function load_js_files() {
	if(!is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', false, '1.10.1', true);

		//Get in line!
		wp_enqueue_script( 'jquery' );
		//If necessary, page specific enqueues
		if ( function_exists('have_rows') && have_rows( 'page_sections' ) ){
			wp_enqueue_script( 'screen-js', get_template_directory_uri() . '/assets/js/screen.js', '1.4', true);
		}

		// Enable ajax support for comments
		if(is_singular() && comments_open() && get_option('thread_comments')){
		    wp_enqueue_script('comment-reply');
		}
	}
}
add_action( 'wp_enqueue_scripts', 'load_js_files' );

//======================================================================
// Template check
//======================================================================
// Add a bar at the bottom of the page that shows the template being used
function show_template() {
	global $template;
	echo '<div style="position:fixed;bottom:0;left:0;background-color:rgba(255,108,47,.9);color:#fff;padding:.5em;font-size:.8em;">'.$template.'</div>';
}
if (isset($_GET['template'])){add_action('wp_footer', 'show_template');}
