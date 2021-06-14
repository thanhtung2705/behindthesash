<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>
		<!-- Favicons -->
		<link href="<?php echo get_template_directory_uri(); ?>/assets/favicons/favicon-32x32.png" rel="shortcut icon">
    	<link href="<?php echo get_template_directory_uri(); ?>/assets/favicons/favicon-32x32.png" rel="apple-touch-icon-precomposed">
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/assets/favicons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/favicon-16x16.png">
		<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/favicons/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<!-- Mobile Zoom -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>
    <?php 
      $logo = get_field('logo', 'option');
      $google_analytics = get_field('google_analytics', 'option');
      $google_manager = get_field('google_manager', 'option');
    ?>

    <?php 
      if($google_manager) {
        // if($_SERVER['HTTP_HOST'] === 'www.kennedy.com.au'){
          echo "
          <!-- Google Tag Manager -->
          <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','$google_manager');</script>
          <!-- End Google Tag Manager -->
          ";
        // } 
      }
    ?>
    
	</head>
	<body <?php body_class(); ?>>
    
    <?php 
      if($google_manager) {
        // if($_SERVER['HTTP_HOST'] === 'www.kennedy.com.au'){
          echo '
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$google_manager.'"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
            
                <!-- Start of DoubleClick Floodlight Tag: Please do not remove -->
            <script type="text/javascript">
              var axel = Math.random() + "";
              var a = axel * 10000000000000;
              document.write(\'<iframe src="https://6443501.fls.doubleclick.net/activityi;src=6443501;type=enquiry;cat=conta0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=\' + a + \'?" width="1" height="1" frameborder="0" style="display:none"></iframe>\');
            </script>
            <noscript>
              <iframe src="https://6443501.fls.doubleclick.net/activityi;src=6443501;type=enquiry;cat=conta0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
            </noscript>
            <!-- End of DoubleClick Floodlight Tag: Please do not remove -->
          ';
        // } 
      } elseif($google_analytics) {
        echo $google_analytics;
      }
    ?>

		<!-- wrapper -->
		<div class="wrapper">
			<header class="header">
        <div class="header__inner">
          <div class="header__logo">
            <a href="/"><img src="<?php echo $logo ? $logo: get_template_directory_uri(); ?>/assets/images/BTSLogo_3D_RGB_1080px.png" alt="logo"></a>
          </div>
				</div>
      </header>
			</div>
