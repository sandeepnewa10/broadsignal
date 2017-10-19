<?php

/**
 * Get products on discount
 * @param int $discount_id
 * @return $products
 */
function grand_popo_get_discount_products($discount_id) {
    $discount = new WAD_Discount($discount_id);
    $product_list = $discount->products_list;
    $products = $product_list->get_products();
    return $products;
}
/**
 * Get advanced product search
 * @param array $atts
 * @return $custom_search_form
 */
function grand_popo_advanced_product_search($atts) {

    $atts = shortcode_atts(array(
        'all' => '',
        'categories' => '',
            ), $atts);


    if (isset($atts['categories']) && !empty($atts['categories'])) {
        $att_categories = explode(',', $atts['categories']);
        $attr_categories = array_map('trim', $att_categories);
    } else {
        $attr_categories = array();
    }

    ob_start();
    ?>

    <form role="search" method="get" class="woocommerce-product-search grand_popo-advanced-search" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="site-wrap">
            <select name="product_cat">
                <?php
                if (isset($atts['all']) && $atts['all'] == "true") {
                    $icon = get_template_directory_uri() . '/assets/images/all.png';
                    ?>
                    <option data-icon="<?php echo $icon ?> " value="all">
                        <?php esc_html_e('All categories', 'grand_popo') ?>
                    </option>
                    <?php
                }
                // generate list of categories
                $terms = get_categories(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => 0,
                    'parent' => 0,
                    'include' => $attr_categories,
                ));

                foreach ($terms as $term) {
                    $cat_icon = get_term_meta($term->term_id, "prod_cat_icon", true);
                    ?>
                    <option data-icon="<?php echo esc_attr($cat_icon) ?> " value="<?php echo esc_attr($term->slug) ?>">
                        <?php echo esc_html__($term->name) ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <input type="search" required="required" class="search-field" placeholder="<?php echo esc_attr_x('What are you looking for?', 'placeholder', 'grand_popo'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x('Search product', 'label', 'grand_popo'); ?>" />
            <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
            <input type="hidden" name="post_type" value="product" />

        </div>
    </form>

    <?php
    return ob_get_clean();
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_shortcode("gp-search", "grand_popo_advanced_product_search");
}

// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

/**
 * Extend Recent Posts Widget 
 * Adds different formatting to the default WordPress Recent Posts Widget
 */
Class Grand_Popo_Recent_Posts_Widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_gp_recent_entries', 'description' => __("The most recent posts on your site"));
        parent::__construct('gp-recent-posts', __('Grand-Popo Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_gp_recent_entries';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_gp_recent_posts', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = (!empty($instance['title']) ) ? $instance['title'] : __('Recent Posts');
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $number = (!empty($instance['number']) ) ? absint($instance['number']) : 10;
        if (!$number)
            $number = 10;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        

        $r = new WP_Query(apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true)));
        if ($r->have_posts()) :
            ?>
            <?php echo $before_widget; ?>
                <?php if ($title) echo $before_title . $title . $after_title; ?>
            <ul>
            <?php while ($r->have_posts()) : $r->the_post(); ?>
                    <li>
                       
                        <div>
                            <?php
                            $post = $r->post;
                            if (has_post_thumbnail()) {
                                $size = array(70, 70);
                                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
                                $url = $thumb['0'];
                                ?>
                                <img src=<?php echo esc_url($url) ?> alt="image" width="70px">
                                <?php
                            } else {
                                ?>

                                <img src="http://placehold.it/70x70" alt="placeholder">

                                <?php
                            }
                            ?>
                        </div>
                        <div>
                            <div class="recent-widget-header">
                                <a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            </div>
                            <div class="recent-widget-footer">
                                <div>
                                    <i class='fa fa-user'></i>
                                    <?php the_author(); ?>
                                </div>
                                <div>
                                    <i class='fa fa-eye'></i>
                                    <?php echo grand_popo_get_post_views($post->ID); ?>

                                </div>
                            </div>
                            <?php if ($show_date) : ?>
                                <div class="post-date-wrap">
                                    <i class='fa fa-calendar'></i>
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                            
                    </li>
                        
            <?php endwhile; ?>
            </ul>
            <?php echo $after_widget; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_recent_entries']))
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?'); ?></label></p>
        <?php
    }

}
function grand_popo_recent_widget_registration() {
    register_widget('Grand_Popo_Recent_Posts_Widget');
}
add_action('widgets_init', 'grand_popo_recent_widget_registration');
/**
 * Get post views 
 * @param int $postID
 * @return $count
 */
function grand_popo_get_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 0);
        return "0 View";
    }
    return $count . ' Views';
}
/**
 * Count post views 
 * @param int $postID
 */
function grand_popo_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == '') {
        $count = 0;

        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 0);
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
/**
 * Get post share html 
 * @param string $type
 * @return $grand_popo_post_share_html
 */
function grand_popo_get_post_share_html($type) {
    global $grand_popo_post_id;
    if($type=="post")
        $type_class=$type;
    else{
        $type_class="product";
    }
    
    $grand_popo_post_share_html = "
    
    <div  class='". $type_class ." rs-container'>
      <span>
        <a href='" . esc_url(grand_popo_get_facebook_share_url($grand_popo_post_id)) . "'><i class='fa fa-facebook'></i></a>
      </span>
      <span>
        <a href='" . esc_url(grand_popo_get_twitter_share_url($grand_popo_post_id)) . "''><i class='fa fa-twitter'></i></a>
      </span>
      <span>
        <a href='" . esc_url(grand_popo_get_google_share_url($grand_popo_post_id)) . "'><i class='fa fa-google-plus'></i></a>
      </span>
      <span>
        <a href='" . esc_url(grand_popo_get_pinterest_share_url($grand_popo_post_id)) . "'><i class='fa fa-pinterest-p'></i></a>
      </span>
                
    </div>";
    echo  $grand_popo_post_share_html;
}
/**
 * Get post share url for facebook 
 * @param int $grand_popo_post_id
 * @return $post_share_facebook_url
 */
function grand_popo_get_facebook_share_url($grand_popo_post_id) {
    $url = get_permalink($grand_popo_post_id);
    return "https://www.facebook.com/sharer/sharer.php?u=$url";
}
/**
 * Get post share url for twitter 
 * @param int $grand_popo_post_id
 * @return $post_share_twitter_url
 */
function grand_popo_get_twitter_share_url($grand_popo_post_id) {
    $url = get_permalink($grand_popo_post_id);
    $title = get_the_title($grand_popo_post_id);
    return "https://twitter.com/home?status=Check%20out%20this%20article:%20" . urlencode($title) . "%20-%20$url";
}
/**
 * Get post share url for pinterest 
 * @param int $grand_popo_post_id
 * @return $post_share_pinterest_url
 */
function grand_popo_get_pinterest_share_url($grand_popo_post_id) {
    $url = get_permalink($grand_popo_post_id);
    $img_id = get_post_thumbnail_id($grand_popo_post_id);
    $featured_img = wp_get_attachment_image_src($img_id, "full");
    $title = get_the_title($grand_popo_post_id);
    return "https://pinterest.com/pin/create/button/?url=$url&media=$featured_img[0]&description=" . urlencode($title);
}
/**
 * Get post share url for google 
 * @param int $grand_popo_post_id
 * @return $post_share_google_url
 */
function grand_popo_get_google_share_url($grand_popo_post_id) {
    $url = get_permalink($grand_popo_post_id);
    return "https://plus.google.com/share?url=$url";
}
// Display grand_popo_get_post_share_html on single product summary
if (class_exists('WooCommerce')){
    add_action( 'woocommerce_single_product_summary', 'grand_popo_get_post_share_html', 50, 1 );
}
