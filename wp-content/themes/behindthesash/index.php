<?php get_header(); ?>
	<main role="main">
    <div class="container">
      <div class="main-content">
        <h1><?php _e( 'Latest Posts', 'behindthesash' ); ?></h1>
        <?php get_template_part('loop'); ?>
        
        <!-- pagination -->
          <div class="pagination">
            <?php behindthesash_pagination(); ?>
          </div>
        <!-- /pagination -->

      </div>
      <?php get_sidebar(); ?>
    </div>
	</main>
<?php get_footer(); ?>
