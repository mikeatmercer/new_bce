<?php
add_theme_support( 'menus' );

//$siteDir = '/wp-content/themes/w25th-build';
add_post_type_support('page', 'excerpt');

add_filter( 'user_can_richedit' , '__return_false', 50 );

// Custom functions

// Tidy up the <head> a little. Full reference of things you can show/remove is here: http://rjpargeter.com/2009/09/removing-wordpress-wp_head-elements/
remove_action('wp_head', 'wp_generator');// Removes the WordPress version as a layer of simple security

add_theme_support('post-thumbnails');

function add_custom_query_var( $vars ){
  $vars['1'] = "colormode";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var' );


add_action( 'admin_init', 'my_theme_add_editor_styles' );
function my_theme_add_editor_styles() {
    add_editor_style( 'css/editor-styles.css' );
}

// DIRECTORY REPLACER

function dirReplacer($string) {
  global $siteDir;
  $time = time();
  $newString = str_replace('***REPLACEWITHTHEMEDIRECTORY***', $siteDir, $string);
  $newString = str_replace('***TIMESTAMP***', $time ,$newString);
  echo $newString;
}
//CONTENT CLEANER
function content_cleaner($content) {

    // Remove inline styling
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

    // Remove font tag
    $content = preg_replace('/<font[^>]+>/', '', $content);

    // Remove empty tags
    $post_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
    $content = strtr($content, $post_cleaners);

    return $content;
}
// add_filter('the_content', 'content_cleaner',20);


include 'backend_projects_post_type.php';
include 'backend_social_icon.php';
include 'backend_function_get_all_image_sizes.php';
include 'backend_function_slug_generator.php';
?>
