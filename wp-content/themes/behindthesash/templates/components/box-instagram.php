<?php
	if ( get_row_layout() == 'box_instagram' ):
		$title = get_sub_field('title');
?>

<div class="box-instagram">
	<h2 class="section-title"><?php echo $title; ?></h2>

	<div class="box-instagram__wrap js-slick-instagram">
		<?php
			if (have_rows('box_item')):
				while(have_rows('box_item')): the_row();
					$image = get_sub_field('image');
					$link = get_sub_field('link');
		?>

		<div class="box-instagram__item">
			<a href="<?php echo $link['url']; ?>" target="_blank"><?php echo wp_get_attachment_image( $image['ID'], ''); ?></a>
		</div>
		<?php endwhile;
		endif; ?>
	</div>
</div>

<?php endif; ?>
