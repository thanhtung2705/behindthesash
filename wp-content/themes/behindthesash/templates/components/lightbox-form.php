<?php
	if ( get_row_layout() == 'lightbox_form' ):
		$title = get_sub_field('title');
		$content = get_sub_field('content');
		$body = get_sub_field('body');
?>
<div class="lightbox-formwrap is-lightbox">
	<div class="container">
		<div class="lightbox-form">
			<span class="form-bars js-close-form">
				<span class="form-bars__row"></span>
				<span class="form-bars__row"></span>
			</span>
				
			<div class="lightbox-form__wrap">
				
				<h3 class="lightbox-form__title"><?php echo $title; ?></h3>

				<div class="lightbox-form__content text--large">
					<?php echo $content; ?>
				</div>

				<?php echo $body; ?> 
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
