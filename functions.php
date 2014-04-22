<?php

//* Start the engine

include_once( get_template_directory() . '/lib/init.php' );



//* Set Localization (do not remove)

load_child_theme_textdomain( 'metro', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'metro' ) );



//* Child theme (do not remove)

define( 'CHILD_THEME_NAME', __( 'Metro Pro Theme', 'metro' ) );

define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/metro/' );

define( 'CHILD_THEME_VERSION', '2.0.0' );



//* Add HTML5 markup structure

add_theme_support( 'html5' );



//* Add viewport meta tag for mobile browsers

add_theme_support( 'genesis-responsive-viewport' );



//* Enqueue Google fonts

add_action( 'wp_enqueue_scripts', 'metro_google_fonts' );

function metro_google_fonts() {

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Oswald:400', array(), CHILD_THEME_VERSION );

}



/** Display author box on single posts */

add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );



//* Enqueue Backstretch script and prepare images for loading

add_action( 'wp_enqueue_scripts', 'metro_enqueue_scripts' );

function metro_enqueue_scripts() {



	//* Load scripts only if custom background is being used

	if ( ! get_background_image() )

		return;



	wp_enqueue_script( 'metro-pro-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_script( 'metro-pro-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'metro-pro-backstretch' ), '1.0.0' );



	wp_localize_script( 'metro-pro-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', get_background_image() ) ) );



}



//* Add custom background callback for background color

function metro_background_callback() {



	if ( ! get_background_color() )

		return;



	printf( '<style>body { background-color: #%s; }</style>' . "\n", get_background_color() );



}



//* Add new image sizes

add_image_size( 'home-bottom', 150, 150, TRUE );

add_image_size( 'home-middle', 332, 190, TRUE );

add_image_size( 'home-top', 700, 400, TRUE );



//* Add support for custom background

add_theme_support( 'custom-background', array( 'wp-head-callback' => 'metro_background_callback' ) );



//* Add support for custom header

add_theme_support( 'custom-header', array(

	'width'           => 270,

	'height'          => 80,

	'header-selector' => '.site-title a',

	'header-text'     => false

) );



//* Add support for additional color style options

add_theme_support( 'genesis-style-selector', array(

	'metro-pro-blue'  => __( 'Blue', 'metro' ),

	'metro-pro-green' => __( 'Green', 'metro' ),

	'metro-pro-pink'  => __( 'Pink', 'metro' ),

	'metro-pro-red'   => __( 'Red', 'metro' ),

) );



//* Add support for 3-column footer widgets

add_theme_support( 'genesis-footer-widgets', 3 );



//* Reposition the secondary navigation

remove_action( 'genesis_after_header', 'genesis_do_subnav' );

add_action( 'genesis_before', 'genesis_do_subnav' );



//* Hooks after-entry widget area to single posts

add_action( 'genesis_entry_footer', 'metro_after_post'  ); 

function metro_after_post() {



    if ( ! is_singular( 'post' ) )

    	return;



    genesis_widget_area( 'after-entry', array(

		'before' => '<div class="after-entry widget-area"><div class="wrap">',

		'after'  => '</div></div>',

    ) );



}



//* Remove comment form allowed tags

add_filter( 'comment_form_defaults', 'metro_remove_comment_form_allowed_tags' );

function metro_remove_comment_form_allowed_tags( $defaults ) {

	

	$defaults['comment_notes_after'] = '';

	return $defaults;



}



//* Reposition the footer widgets

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

add_action( 'genesis_after', 'genesis_footer_widget_areas' );



//* Reposition the footer

remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );

remove_action( 'genesis_footer', 'genesis_do_footer' );

remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );

add_action( 'genesis_after', 'genesis_do_footer', 12 );

add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );



//* Register widget areas

genesis_register_sidebar( array(

	'id'          => 'home-top',

	'name'        => __( 'Home - Top', 'metro' ),

	'description' => __( 'This is the top section of the homepage.', 'metro' ),

) );

genesis_register_sidebar( array(

	'id'          => 'home-middle-left',

	'name'        => __( 'Home - Middle Left', 'metro' ),

	'description' => __( 'This is the middle left section of the homepage.', 'metro' ),

) );

genesis_register_sidebar( array(

	'id'          => 'home-middle-right',

	'name'        => __( 'Home - Middle Right', 'metro' ),

	'description' => __( 'This is the middle right section of the homepage.', 'metro' ),

) );

genesis_register_sidebar( array(

	'id'          => 'home-bottom',

	'name'        => __( 'Home - Bottom', 'metro' ),

	'description' => __( 'This is the bottom section of the homepage.', 'metro' ),

) );

genesis_register_sidebar( array(

	'id'          => 'after-entry',

	'name'        => __( 'After Entry', 'metro' ),

	'description' => __( 'This is the after entry section.', 'metro' ),

) );





//* Change Title in author box

add_filter( 'genesis_author_box', 'sk_author_box' );

function sk_author_box() {

 

	// Author's Gravatar image

	$gravatar_size = apply_filters( 'genesis_author_box_gravatar_size', 100, $context );

	$gravatar      = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );

 

	// Author's name

	$name = get_the_author();

	$title = get_the_author_meta( 'title' );

	if( !empty( $title ) )

		$name .= ', ' . $title;

 	$link = get_the_author_meta( 'user_url' );



	// Author's Biographical info

	$description   = wpautop( get_the_author_meta( 'description' ) );

 

	// Build Author box output

	$output = '';

	$output .= '<section class="author-box" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">';

	$output .= $gravatar;

	$output .= '<h3 class="author-box-title">About the author</span></h3>';

	$output .= '<div itemprop="description" class="author-box-content">' . $description . '</div>';

	if (get_the_author_meta( 'user_url' ))

	{

		$output .= '<div class="custom-link"><br><p>Website: <a href="'.$link.'" target="_blank">'. $link .'</a></p></div>';

	}

	$output .= '</section>';

	return $output;

 

}



/* Jetpack Share Buttons */



add_action( 'init', 'custom_init', 11 );

function custom_init(){

   

    // if sharing_display() function does not exist, return

    if( ! function_exists( 'sharing_display' ) )

        return;

     

    // remove the callback sharing_display() for the 

    // 'the_content' and 'the_excerpt' filters.

    remove_filter( 'the_content', 'sharing_display', 19 );

    remove_filter( 'the_excerpt', 'sharing_display', 19 );

     

}

if (function_exists('bp_is_current_component')) {
	if(bp_is_current_component( 'activity' ) || bp_is_current_component( 'profile' ) || bp_is_current_component( 'blogs' )
	|| bp_is_current_component( 'messages' ) || bp_is_current_component( 'friends' ) || bp_is_current_component( 'groups' )
	|| bp_is_current_component( 'settings' ) || bp_is_current_component( 'notifications' ) || bp_is_current_component( 'forums' ) || is_bbpress())
	{
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

// To remove the entry meta under bbpress or buddypress

// BuySellAds tracking code

    add_action(‘genesis_before’, ‘buysellads’);
    function buysellads() { ?>

    <!-- BuySellAds Ad Code -->
	<script type="text/javascript">
	(function(){
	  var bsa = document.createElement('script');
		 bsa.type = 'text/javascript';
		 bsa.async = true;
		 bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
	  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
	})();
	</script>
	<!-- End BuySellAds Ad Code -->

    <?php
    }

// BuySellAds tracking code