<?php
	if ( get_row_layout() == 'grid_cart' ):
		$title = get_sub_field('title');
?>

<div class="grid-cart">
	<h2 class="section-title"><?php echo $title; ?></h2>

	<div class="grid-cart__list">
		<?php
			if (have_rows('box_item')):
			while(have_rows('box_item')): the_row();
				$imageNormal = get_sub_field('image_normal');
				$imageHover = get_sub_field('image_hover');
				$subTitle = get_sub_field('sub_title');
				$content = get_sub_field('content');
				$link = get_sub_field('link');
				$class = get_sub_field('class');
		?>

		<div class="grid-cart__item <?php echo $class; ?>">
			<?php if ($imageNormal): ?>
				<div class="grid-cart__image <?php if ($imageHover): ?> js-hover <?php endif; ?>" <?php if ($imageHover): ?> data-imghover="<?php echo $imageHover['url']; ?>" <?php endif; ?>>
					<?php echo wp_get_attachment_image( $imageNormal['ID'], ' '); ?>
				</div>
			<?php endif; ?>

			<div class="grid-cart__body">
				<h3 class="grid-cart__title"><?php echo $subTitle; ?></h3>

				<div class="grid-cart__content">
					<?php echo $content; ?>
				</div>

				<div class="grid-cart__link">
					<a href="<?php echo $link['url']; ?>" class=" btn btn--with-icon" target="_blank"><?php echo $link['title']; ?></a>
				</div>
			</div>
		</div>
		<?php endwhile;
		endif; ?>
	</div>
</div>

<?php endif; ?>
