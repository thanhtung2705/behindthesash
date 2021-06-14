<?php
  // Add theme options.
  if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
      'page_title'  => 'Theme General Settings',
      'menu_title'  => 'Theme Settings',
      'menu_slug'   => 'theme-settings',
      'capability'  => 'edit_posts',
      'redirect'    => false
    ));
  }

  // Theme support
  if (function_exists('add_theme_support')) {
      // Woocommerce support theme.
      // add_theme_support( 'woocommerce' );

      // Add Menu Support
      add_theme_support('menus');

      // Add Thumbnail Theme Support
      add_theme_support('post-thumbnails');
      // add_image_size('large', 700, '', true); // Large Thumbnail
      // add_image_size('medium', 250, '', true); // Medium Thumbnail
      // add_image_size('small', 120, '', true); // Small Thumbnail
  }

  // Allow SVG through WordPress Media Uploader
  function behindthesash_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter('upload_mimes', 'behindthesash_mime_types');
  
  // Remove 'text/css' from our enqueued stylesheet
  function behindthesash_style_remove($tag) {
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
  }
  
  // Add page slug to body class, love this - Credit: Starkers Wordpress Theme
  function behindthesash_add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
  }

  // Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
  function behindthesash_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $wp_query->max_num_pages
    ));
  }
  
  // Actions
  add_action('init', 'behindthesash_pagination'); // Add our sentius Pagination

  // Filters
  add_filter('style_loader_tag', 'behindthesash_style_remove'); // Remove 'text/css' from enqueued stylesheet
  add_filter('body_class', 'behindthesash_add_slug_to_body_class'); // Add slug to body class (Starkers build)
?>
