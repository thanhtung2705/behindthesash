<?php
	if ( get_row_layout() == 'banner'):
		$bannerItem = get_sub_field('banner_item');
		$background = get_sub_field('background');
?>

<div class="banner">
	<div class="banner__wrap js-slick-banner">
		<?php
			if (have_rows('banner_item')):
				while(have_rows('banner_item')): the_row();
					$imageDesktop = get_sub_field('image_desktop');
					$imageMobile = get_sub_field('image_mobile');
					$imageLogo = get_sub_field('image_logo');
					$title = get_sub_field('title');
					$subTitle = get_sub_field('sub_title');
					$image = get_sub_field('image');
					$logoMobile = get_sub_field('logo_mobile');
		?>

		<div class="banner__item">
			<div class="banner__image">
				<div class="image-desktop"><?php echo wp_get_attachment_image( $imageDesktop['ID'], '' ); ?></div>
				<div class="image-mobile"><?php echo wp_get_attachment_image( $imageMobile['ID'], '' ); ?></div>
			</div>

			<div class="banner__body">
				<h2 class="banner__title"><?php echo $title; ?></h2>
				<h2 class="banner__subtitle"><?php echo $subTitle; ?></h2>

				<div class="banner__picture">
					<?php echo wp_get_attachment_image( $image['ID'], ''); ?>
				</div>
			</div>
		</div>
		<?php endwhile;
	endif; ?>
	</div>

	<div class="banner__text-mobile">
		<div class="banner__background">
			<?php echo wp_get_attachment_image( $background['ID'], ''); ?>
		</div>
		<div class="banner__text-wrap">
			<div class="image-mobile">
				<?php echo wp_get_attachment_image( $imageLogo['ID'], '' ); ?>
			</div>
			<h2 class="banner__title"><?php echo $title; ?></h2>
			<h2 class="banner__subtitle"><?php echo $subTitle; ?></h2>

			<div class="banner__picture">
				<?php echo wp_get_attachment_image( $logoMobile['ID'], ''); ?>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
