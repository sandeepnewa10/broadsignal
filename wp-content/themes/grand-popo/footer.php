<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grand-Popo
 */
?>
</div>
</div>


<footer class="footer">
    <div class="footer-top">
<div id="colophon"  class="container" role="contentinfo">
  <div class="row">
    

        
      <?php if ( is_active_sidebar( 'footer2' ) ) : ?>
          <div class="col-sm-6 col-md-5">
              <?php dynamic_sidebar( 'footer2' ); ?>
            </div>
        <?php endif; ?>
         <?php if ( is_active_sidebar( 'footer1' ) ) : ?>
          <div class="col-sm-6 col-md-3">
              <?php dynamic_sidebar( 'footer1' ); ?>
            </div>
        <?php endif; ?>

        <div class="col-sm-6 col-md-4"> <div class="row">
      <div class="footer-logo pull-right">
      <img src="<?php bloginfo('stylesheet_directory'); ?>/images/sa.jpg" class="img-responsive"></div>
    </div>
    <?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>
          <div class="row">
              <div class="footer-nav"><?php dynamic_sidebar( 'footer-menu' ); ?></div>
            </div>
        <?php endif; ?>

    
  </div>





</div>

  </div>
</div>


<div class="footer-bottom">
<div class="container">
  <div class="row">


  <div class="col-md-5 pull-left col-sm-12">
  <div class="site-info">
    <?php do_action( 'upbootwp_credits' ); ?>
    &copy; <?php bloginfo('name'); ?> <?php the_time('Y') ?> ABN 95 149 641 207  . All rights reserved


  </div><!-- .site-info -->

</div>
</div></div></div>


</footer>

<?php wp_footer(); ?>

</body>
</html>
