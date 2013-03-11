<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/normalize.css" />
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/foundation.css" />
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/skycandy.css" />
		<script src="<?php bloginfo('template_url'); ?>/js/vendor/custom.modernizr.js"></script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
