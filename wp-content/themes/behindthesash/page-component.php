<?php  
  /* 
  Template Name: Components Page
  */  
?>
<?php get_header(); ?>
  <main role="main">
    <?php
      // check if the flexible content field has rows of data
      get_template_part('templates/components'); 
    ?>
  </main>
<?php get_footer(); ?>
