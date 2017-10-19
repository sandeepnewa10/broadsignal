<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 1.1
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



<!--
		     <header id="header">
		       <div class="container"><div class="row">
		         <div class="col-sm-3">
		           <div class="logo"><a href=""><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" class="img-responsive"></a></div>
		         </div>
		         <div class="col-sm-9">
							 <div class="header-adsense pull-right">
		           <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/header-banner.jpg">
		           </div>
		         </div></div>
		       </div>
		     </header>-->


				 <nav class="navbar navbar-default navbar-fixed-top" role="navigation">

				 	<div class="container">
				 		<div class="row">
				 			<div class="col-md-12">
				 						<div class="navbar-header">

				 								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				 									<span class="icon-bar"></span>
				 									<span class="icon-bar"></span>
				 									<span class="icon-bar"></span>
				 					</button>

				 								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"  class="navbar-brand"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" class="img-responsive"></a>

				 						</div>

				 				<?php
				 				$args = array('theme_location' => 'primary',
				 								'container_class' => 'collapse navbar-collapse',
				 								'menu_class' => 'nav navbar-nav  pull-right',
				 								'fallback_cb' => '',
				 														'menu_id' => 'main-menu',
				 														'walker' => new Upbootwp_Walker_Nav_Menu());
				 				wp_nav_menu($args);
				 				?>
				 			</div><!-- .col-md-12 -->
				 		</div><!-- row -->
				 	</div><!-- container -->
				 </nav>
