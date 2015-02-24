<!DOCTYPE html><html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
<?php wp_head(); ?>
<link rel="stylesheet" href="/wp-content/themes/tca-2015/style.css" type="text/css"/>
<link rel="stylesheet" media="(min-width: 20em)" href="/wp-content/themes/tca-2015/css/f-sans.css" type="text/css" />
</head>
<body id="body" data-ua="" <?php body_class(); ?>>
<header id="header" class="hdr-m back-blue f-san-200" data-toggle="">
	<div class="container-full">
	<div id="top-bar"class="top-bar font-white link-white f-up"><?php if ( ! dynamic_sidebar( 'top-bar' ) ) : endif; ?></div>
	<a href="<?php echo get_site_url(); ?>" class="logo"><img src="<?php echo get_theme_mod('logo_setting'); ?>" alt="logo" /></a>
	<?php include'nav/nav-main.php' ?>
	</div>
</header>
<div class="nv-mob back-blue"><a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_theme_mod('logo_setting'); ?>" alt="logo" class="nv-mob-logo"/></a><a href="#top-bar" id="nav-open" class="nv-btn"> <i class="nv-btn-bar"></i><i class="nv-btn-bar"></i><i class="nv-btn-bar"></i></a></div>
