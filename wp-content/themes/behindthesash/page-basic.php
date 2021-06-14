<?php 
/* Template Name: Basic template 
*/ ?>

<?php get_header(); ?>
  <main role="main">
    <div class="container">
      <div class="main-wrap">
      	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
      </div>
    </div>
  </main>
<?php get_footer(); ?>
