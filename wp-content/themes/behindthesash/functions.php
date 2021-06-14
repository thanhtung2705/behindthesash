<?php
/*
 *  Author: Sentius Group
 *  URL: sentiustdigital.com | @ssvtheme
 *  Custom functions, support, custom post types and more.
 */

  require get_template_directory() . '/inc/init.php';

  /* shortcode for the current year */
	function year_shortcode() {
	  $year = date('Y');
	  return $year;
	}

	add_shortcode('year', 'year_shortcode');

	// Disable Gutenberg editor.
 	add_filter('use_block_editor_for_post_type', '__return_false', 10);

	// Don't load Gutenberg-related stylesheets.
  add_action( 'wp_enqueue_scripts', 'bts_remove_block_css', 100 );
  function bts_remove_block_css() {
    wp_dequeue_style( 'wp-block-library' ); // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
  }

?>
