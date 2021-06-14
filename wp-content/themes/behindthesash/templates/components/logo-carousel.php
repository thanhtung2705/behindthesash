<?php
	if ( get_row_layout() == 'logo_carousel' ):
		$title = get_sub_field('title');
?>

<div class="logo-carousel">
	<div class="container">
		<h2 class="section-title"><?php echo $title; ?></h2>

		<div class="logo-carousel__wrap js-slick-logo">
			<?php
				if(have_rows('box_item')):
					while(have_rows('box_item')): the_row();
						$image = get_sub_field('image');
			?>
			<div class="logo-carousel__item">
				<?php echo wp_get_attachment_image( $image['ID'], '' ); ?>
			</div>
		<?php endwhile;
	endif; ?>
		</div>

		<div class="logo-carousel__link">
			<a href="#" class="btn js-lightbox">Jump on the journey</a>
		</div>
	</div>
</div>

<?php endif; ?>
