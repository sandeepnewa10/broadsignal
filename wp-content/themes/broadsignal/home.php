<?php
/*
Template Name: Front Page
*/
?>
<?php
get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <!--<header class="entry-header">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>-->
        
        <?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
          <?php upbootwp_posted_on(); ?>
        </div>
        <!-- .entry-meta -->
        <?php endif; ?>
      </header>
      <!-- .entry-header -->
      
      <?php if ( is_search() || is_home() ) : // Only display Excerpts for Search ?>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div>
      <!-- .entry-summary -->
      <?php else : ?>
      <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'upbootwp')); ?>
        <?php
        wp_link_pages( array(
        'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
        'after'  => '</div>',
        ));
        ?>
      </div>
      <!-- .entry-content -->
      <?php endif; ?>
      <footer class="entry-meta">
        <?php if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
        <?php
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', 'upbootwp' ) );
        if ( $categories_list && upbootwp_categorized_blog() ) :
        ?>
        <span class="cat-links"> <?php printf( __( 'Posted in %1$s', 'upbootwp' ), $categories_list ); ?> </span>
        <?php endif; // End if categories ?>
        <?php
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', __( ', ', 'upbootwp' ) );
        if ( $tags_list ) :
        ?>
        <span class="tags-links"> <?php printf( __( 'Tagged %1$s', 'upbootwp' ), $tags_list ); ?> </span>
        <?php endif; // End if $tags_list ?>
        <?php endif; // End if 'post' == get_post_type() ?>
        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
        <span class="comments-link">
          <?php comments_popup_link( __( 'Leave a comment', 'upbootwp' ), __( '1 Comment', 'upbootwp' ), __( '% Comments', 'upbootwp' ) ); ?>
        </span>
        <?php endif; ?>
        <?php edit_post_link( __( 'Edit', 'upbootwp' ), '<span class="edit-link">', '</span>' ); ?>
      </footer>
      <!-- .entry-meta -->
    </article>
    <!-- #post-## -->
    
    <?php endwhile; ?>
    <?php //upbootwp_content_nav('nav-below'); ?>
    <?php else : ?>
    <?php get_template_part( 'no-results', 'index' ); ?>
    <?php endif; ?>
  </main>
  <!-- #main -->
</div>
<?php
get_footer(); ?>