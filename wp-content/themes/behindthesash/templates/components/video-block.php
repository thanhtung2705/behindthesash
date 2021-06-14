<?php
	if ( get_row_layout() == 'video_block' ):
		$image = get_sub_field('image');
		$title = get_sub_field('title');
		$content = get_sub_field('content');
		$video = get_sub_field('video');
		$videoImage = get_sub_field('video_image');
		$videoImageMobile = get_sub_field('video_image_mobile');
?>

<div class="video-block">
	<div class="container">
		<div class="video-block__image image-desktop">
			<?php echo wp_get_attachment_image( $image['ID'], ''); ?>
		</div>

		<h1 class="video-block__title"><?php echo $title; ?></h1>

		<div class="video-block__content text--large">
			<?php echo $content; ?>
		</div>
	</div>

	<div class="video-block__video">
		<?php if($video): ?>
	    <a href="<?php echo $video; ?>" data-lity>
	    	<picture>
					<source media="(max-width: 767px)" srcset="<?php echo $videoImageMobile['sizes']['medium_large']?>">
					<img src="<?php echo $videoImage['url']?>" alt="<?php echo $videoImage['alt']?>" width="<?php echo $videoImage['width']?>" height="<?php echo $videoImage['height']?>">
				</picture>

	    	<div class="video-block__video--play js-video-embed">
		      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play-circle.svg" alt="">
		    </div>
		  </a>

		  <?php else :?>
		  	<picture>
					<source media="(max-width: 767px)" srcset="<?php echo $videoImageMobile['sizes']['medium_large']?>">
					<img src="<?php echo $videoImage['url']?>" alt="<?php echo $videoImage['alt']?>" width="<?php echo $videoImage['width']?>" height="<?php echo $videoImage['height']?>">
				</picture>
		<?php endif; ?>
  </div>
</div>

<?php endif; ?>
