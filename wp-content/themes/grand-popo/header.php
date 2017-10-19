<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grand-Popo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>




        
     <div id="nav">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php bloginfo('url'); ?>"><img class="logo" src="<?php bloginfo('template_directory'); ?>/images/logo3.png" alt="" /></a>
          <span class="contactinfo"><a href="tel:0884481120"><i class="fa fa-phone"></i>08 8448 1120</a></span>
        </div>


       <?php
        wp_nav_menu( array(
                'menu'              => 'primary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'navbar-collapse collapse',
                'menu_class'        => 'nav navbar-nav  pull-right',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
        ?>







      </div><!-- /.container-fluid -->
    </nav>
</div><!-- #nav -->


       

    <?php
    //$header_search = grand_popo_get_proper_value($grand_popo_options, 'opt-enable-header-search', 1);
    if ($header_search == 1 && function_exists('grand_popo_advanced_product_search')) {
        echo grand_popo_advanced_product_search($atts = array('all' => true, 'categories' => ''));
    }

    $page_id = get_the_ID();
    if (function_exists('is_shop') && is_shop())
        $page_id = get_option('woocommerce_shop_page_id');
    $page_metas = get_post_meta($page_id, 'grand_popo_page_options', true);
    $page_layout = grand_popo_get_proper_value($page_metas, 'page-layout', 'boxed');
    ?>
                <?php grand_popo_get_page_title(); ?>

           

            <div id="site-content" class="site-content <?php echo esc_attr($page_layout); ?>-layout">      
            <?php
            if (function_exists('is_shop') && (is_shop() || is_product_category())) {
                ?>
                    <div class="shop-wrap">
                <?php
            } else {
                ?>
                        <div class="site-wrap">
                    <?php

                }
                
