<?php
if( have_rows('components') ):
     // loop through the rows of data
  while ( have_rows('components') ) : the_row();
    // Logo carousel
    get_template_part('templates/components/logo-carousel');

    // Cta
    get_template_part('templates/components/cta');

    // Banner
    get_template_part('templates/components/banner');

    // Video block
    get_template_part('templates/components/video-block');

    // Grid cart
    get_template_part('templates/components/grid-cart');

    // Lightbox form
    get_template_part('templates/components/lightbox-form');

    // Box instagram
    get_template_part('templates/components/box-instagram');

  endwhile;
endif;?>
