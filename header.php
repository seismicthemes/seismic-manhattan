<?php
/**
 * Theme header template
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
<?php do_action( 'seismicnyc_before' ); ?>
	<header id="branding" role="banner">
		<hgroup>
			<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
	</header><!-- #branding -->
	<nav id="access" role="navigation">
		<h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'seismic-manhattan' ); ?></h1>
		<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'seismic-manhattan' ); ?>"><?php _e( 'Skip to content', 'seismic-manhattan' ); ?></a></div>

		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => false, 'depth' => 4 ) ); ?>
	</nav><!-- #access -->

	<div id="main">