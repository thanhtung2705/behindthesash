<?php
  // Navigation
  function behindthesash_navigation($menuclass, $name, $themelocaltion='') {
    wp_nav_menu(
    array(
      'theme_location'  => $themelocaltion,
      'menu'            => $name,
      'container'       => '',
      'container_class' => '$menuclass',
      'container_id'    => '',
      'menu_class'      => $menuclass,
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul>%3$s</ul>',
      'depth'           => 0,
      'walker'          => ''
      )
    );
  }


  // Register Navigation
  function behindthesash_register_menu() {
    register_nav_menus(array( // Using array to specify more menus if needed
      'header-menu' => __('Header Menu', 'behindthesash'), // Main Navigation
      'sidebar-menu' => __('Sidebar Menu', 'behindthesash'), // Sidebar Navigation
      'extra-menu' => __('Extra Menu', 'behindthesash') // Extra Navigation if needed (duplicate as many as you need!)
    ));
  }

  // Add i tag after a in navigation
  function behindthesash_add_arrow( $item_output, $item, $depth, $args ){
    //Only add class to 'top level' items on the 'primary' menu.
    $hasChildren = (in_array('menu-item-has-children', $item->classes));

    if('has-icon' == $args->theme_location && $hasChildren && $depth == 0 ){
        $item_output .='<i class="js-show-menu icon-arrow-right"></i>';
    }
    return $item_output;
  }

  // Set class for menu dropdown
  function behindthesash_menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'menu-expend';
        }
    }
    return $sorted_menu_items;
  }
  
  // Remove Injected classes, ID's and Page ID's from Navigation <li> items
  function behindthesash_css_attributes_filter( $var ) {
    return is_array($var) ? array() : '';
  }

  // Actions
  add_action('init', 'behindthesash_register_menu');
  
  // Filters
  add_filter( 'wp_nav_menu_objects', 'behindthesash_menu_set_dropdown', 10, 2 );
  add_filter( 'walker_nav_menu_start_el', 'behindthesash_add_arrow',10,4);
  add_filter('nav_menu_item_id', 'behindthesash_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
  add_filter('page_css_class', 'behindthesash_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
?>
