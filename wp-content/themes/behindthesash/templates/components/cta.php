<?php
	if ( get_row_layout() == 'cta' ):
		$type = get_sub_field('type');
		$background = get_sub_field('background');
		$backgroundMobile = get_sub_field('background_mobile');
		$image = get_sub_field('image');
		$title = get_sub_field('title');
		$content = get_sub_field('content');
		$link = get_sub_field('link');
		$class = get_sub_field('class');
?>

<div class="cta <?php echo $type; ?>">
	<div class="container">
		<?php if($background): ?>
			<div class="cta__background">
				<picture>
					<source media="(max-width: 767px)" srcset="<?php echo $backgroundMobile['sizes']['medium_large']?>">
					<source media="(max-width: 1024px)" srcset="<?php echo $background['sizes']['large']?>">
					<img src="<?php echo $background['url']?>" alt="<?php echo $background['alt']?>" width="<?php echo $background['width']?>" height="<?php echo $background['height']?>">
				</picture>

			</div>
		<?php endif; ?>

		<div class="cta__wrap">
			<div class="cta__image">
				<?php echo wp_get_attachment_image( $image['ID'], ''); ?>
			</div>

			<div class="cta__body">
				<?php if($title): ?>
					<h2 class="cta__title"><?php echo $title; ?></h2>
				<?php endif; ?>

				<?php if($content): ?>
					<div class="cta__content">
						<?php echo $content; ?>
					</div>
				<?php endif; ?>

				<div class="cta__link">
					<a href="<?php echo $link['url']; ?>" class="btn <?php echo $class; ?>"><?php if($link['title']) {echo $link['title'];} else {echo 'Find out more';} ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
