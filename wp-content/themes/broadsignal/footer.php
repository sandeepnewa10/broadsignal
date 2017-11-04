<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 1.1
 */
?>

<footer class="footer">
    <div class="footer-top">
<div id="colophon"  class="container" role="contentinfo">
  <div class="row">
    <div class="col-md-3">
      <div class="footer-logo">
      <img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo2.png" class="img-responsive"></div></div>

<!--
		<?php if ( is_active_sidebar( 'footer1' ) ) : ?>
		    <div class="col-md-4">
						<?php dynamic_sidebar( 'footer1' ); ?>
					</div>
		  <?php endif; ?>-->
      <?php if ( is_active_sidebar( 'footer2' ) ) : ?>
          <div class="col-md-4 pull-right">
              <?php dynamic_sidebar( 'footer2' ); ?>
            </div>
        <?php endif; ?>
  </div>

</div>
</div>


<div class="footer-bottom">
<div class="container">
  <div class="row">

  <?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>
    <div class="col-md-7 pull-right  col-sm-12">
        <?php dynamic_sidebar( 'footer-menu' ); ?>
      </div>
  <?php endif; ?>

  <div class="col-md-5 pull-left col-sm-12">
  <div class="site-info">
    <?php do_action( 'upbootwp_credits' ); ?>
    &copy; <?php bloginfo('name'); ?> <?php the_time('Y') ?>. All rights reserved


  </div><!-- .site-info -->

</div>
</div></div></div>


</footer>


<?php wp_footer(); ?>

</body>
</html>
