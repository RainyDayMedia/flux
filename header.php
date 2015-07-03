<?php
/**
 * The Header for the theme.
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package flux
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js sixteen colgrid">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="author" href="<?php echo get_template_directory_uri(); ?>/inc/humans.txt">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<header id="masthead" class="site-header" role="banner">



	</header><!-- #masthead -->

	<div id="content" class="site-content">
