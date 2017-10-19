<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.orionorigin.com/
 * @since      1.0.0
 *
 * @package    Grand_popo
 * @subpackage Grand_popo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Grand_popo
 * @subpackage Grand_popo/public
 * @author     Bel <bellarmin.zinsou@orionorigin.com>
 */
class Grand_popo_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_shortcode("gp-recently-viewed-products", array($this, "grand_popo_recently_viewed_products"));
            add_shortcode("gp-products-grid", array($this, "grand_popo_category_products_shortcode"));
            add_shortcode("gp-product-categories", array($this, "grand_popo_product_categories"));
        }
        add_shortcode("gp-category-title", array($this, "grand_popo_get_section_title"));
        
        if (class_exists('Wad_Activator')){ 
            add_shortcode("gp-discount-products", array($this, "grand_popo_get_discount_products_shortcode"));
            add_shortcode("gp-display-discount", array($this, "grand_popo_display_discount"));
        }
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Grand_popo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Grand_popo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/grand_popo-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Grand_popo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Grand_popo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script('PageScroll2id-js', plugin_dir_url(__FILE__) . 'js/jquery.malihu.PageScroll2id.min.js', array('jquery'));
       
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/grand_popo-public.js', array('jquery'), $this->version, false);
    }
    /**
     * Display grand_popo section title
     * @param      array    $atts  
     * @atts      string $title
     * @atts      string $bg-color
     * @atts      string $icon   
     * @atts      string $link
     * @atts      string $link_open (true or false)
     * @return    section_title_html
     */
    public function grand_popo_get_section_title($atts) {

        $title_attr = shortcode_atts(array(
            'title' => '',
            'bg-color' => '',
            'icon' => '',
            'link'=>'',
            'link-open'=>'',
                ), $atts);

        $img = wp_get_attachment_image_src($title_attr["icon"], "full");
        $title_attr["icon"] = $img[0];
        if ($title_attr['bg-color'] != "")
            $bg_color = "style='background-color:" . $title_attr['bg-color'] . ";'";
        else
            $bg_color = "";


        if ($title_attr['icon'] != "") {
            $title_icon = "<img src='" . $title_attr['icon'] . "' alt='section-title'>";
            $title_pad = "";
        } else {
            $title_icon = "";
            $title_pad = "style='padding:10px;'";
        }
        if(!empty($title_attr['title']) && !empty($title_attr['link']) && $title_attr['link-open']==true){
            $section_title="<a href='". $title_attr['link'] ."' target='_blank'>". $title_attr['title'] ."</a>";
        }
        elseif(!empty($title_attr['title']) && !empty($title_attr['link'])){
            $section_title="<a href='". $title_attr['link'] ."'>". $title_attr['title'] ."</a>";
        }
        else{
            $section_title=$title_attr['title'];
        }
         ob_start();
        ?>

        <div class="grand_popo-section-title wpb_content_element" <?php echo $bg_color; ?> >
            <?php echo $title_icon; ?>

            <span <?php echo $title_pad; ?>><?php echo $section_title ?></span>
        </div>
        <?php
        return ob_get_clean() ;
    }

    /**
     * Display product of specific category 
     * @global    $atts $woocommerce_loop
     * @param     array  $atts  
     * @atts      string $per_page
     * @atts      string $columns
     * @atts      string $orderby   
     * @atts      string $order (asc or desc)
     * @atts      string $category
     * @atts      string $ids (liste of id separate with comma)
     * @return    category_products_html
     */
    public function grand_popo_category_products_shortcode($atts) {
        global $woocommerce_loop;

        $atts = shortcode_atts(array(
            'per_page' => '12',
            'columns' => '4',
            'orderby' => 'menu_order title',
            'order' => 'asc',
            'category' => '',
            'ids' => '',
            'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ), $atts, 'product_category');

        if (!$atts['category'] && !$atts['ids']) {
            return '';
        }

        if (isset($atts['ids'])) {
            $att_ids = explode(',', $atts['ids']);
            $attr_ids = array_map('trim', $att_ids);
        } else {
            $attr_ids = array();
        }

        // Default ordering args
        $ordering_args = WC()->query->get_catalog_ordering_args($atts['orderby'], $atts['order']);
        $meta_query = WC()->query->get_meta_query();
        $category = ( $atts['category'] != "" ) ? $atts['category'] : "";
        $operator = $atts['operator'];

        if ($category == "") {
            $tax_query = array();
        } else {
            $tax_query = array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms' => array_map('sanitize_title', explode(',', $category)),
                    'operator' => $operator
                )
            );
        }

        if (!empty($atts['ids'])) {

            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby' => $ordering_args['orderby'],
                'order' => $ordering_args['order'],
                'posts_per_page' => $atts['per_page'],
                'meta_query' => $meta_query,
                'post__in' => $attr_ids
            );

        // Ignore catalog visibility
            $query_args['meta_query'] = array_merge($query_args['meta_query'], WC()->query->stock_status_meta_query());
        }
        if (!empty($atts['category'])) {

            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby' => $ordering_args['orderby'],
                'order' => $ordering_args['order'],
                'posts_per_page' => $atts['per_page'],
                'meta_query' => $meta_query,
                'tax_query' => $tax_query,
            );
            if (isset($ordering_args['meta_key'])) {
                $query_args['meta_key'] = $ordering_args['meta_key'];
            }
        }

        ob_start();

        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $query_args, $atts, 'product_cat'));
        $columns = absint($atts['columns']);
        $woocommerce_loop['columns'] = $columns;

        if ($products->have_posts()):

            if ($columns == 1) {
                $columns_medium = 1;
            } else {
                $columns_medium = 2;
            }
            $product_item_class = "col xl-1-" . $columns . " lg-1-" . $columns_medium . " md-1-" . $columns_medium . " sm-1-1 grand_popo-products";
            ?>
            <div class="o-wrap products">
                <?php
                while ($products->have_posts()) :

                    $products->the_post();
                    ?>
                    <div class="<?php echo $product_item_class; ?>">
                        <?php
                        wc_get_template_part('content', 'product-shortcode');
                        ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
            <?php
        endif;

        woocommerce_reset_loop();
        wp_reset_postdata();
        // Remove ordering query arguments
        WC()->query->remove_ordering_args();

        return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
    }
    
    /**
     * Get product advanced search functionality 
     * @param     objet  $query 
     * @return    $query
    */
    public function grand_popo_advanced_search_query($query) {
        if ($query->is_search()) {
            if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                $categ = esc_attr($_GET['product_cat']);
                $query->set('tax_query', array(array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($categ))
                ));
            }
            return $query;
        }
    }
    /**
     * Display recently viewed products
     * @global    $woocommerce
     * @param     array  $atts  
     * @atts      int $per_page (default 5)
     * @atts      int $columns (default 4)  
     * @return    $recently_viewed_products_html
     */
    public function grand_popo_recently_viewed_products($atts) {

        // Get shortcode parameters
        extract(shortcode_atts(array(
            'per_page' => 5,
            'columns' => 4
                        ), $atts));

        // Get WooCommerce Global
        global $woocommerce;

        // Get recently viewed product cookies data
        $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', $_COOKIE['woocommerce_recently_viewed']) : array();
        $viewed_products = array_filter(array_map('absint', $viewed_products));

        // If no data, quit
        if (empty($viewed_products))
            return esc_html__('You have not viewed any product yet!', 'grand_popo');

        // Create the object
        ob_start();

        // Get products per page
        if (!isset($per_page) ? $number = 5 : $number = $per_page);   
        $number = !empty($atts['per_page']) ? absint($atts['per_page']) : 10;
        $columns = !empty($atts['columns']) ? absint($atts['columns']) : 4;
        //$columns = absint($atts['columns']);
        // Create query arguments array
        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
            'orderby' => 'rand'
        );

        // Add meta_query to query args
        $query_args['meta_query'] = array();

        // Check products stock status
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query'] = array_filter($query_args['meta_query']);

        // Create a new query
        $r = new WP_Query($query_args);

        // If query return results
        if ($r->have_posts()):

            if ($columns == 1) {
                $columns_medium = 1;
                $product_wrap_class = "o-wrap  products";
            } else {
                $columns_medium = 2;
                $product_wrap_class = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-24 sm-gutter-0 products";
            }
            $product_item_class = "col xl-1-" . $columns . " lg-1-" . $columns . " md-1-" . $columns_medium . " sm-1-1 grand_popo-products";
            ?>
            <div class="<?php echo $product_wrap_class; ?>">
            <?php
            while ($r->have_posts()) :

                $r->the_post();
                ?>
                    <div class="<?php echo $product_item_class; ?>">
                    <?php
                    wc_get_template_part('content', 'product-shortcode');
                    ?>
                    </div>
                        <?php
                    endwhile;
                    ?>
            </div>
                <?php
            endif;

            woocommerce_reset_loop();
            wp_reset_postdata();
            return '<div class="woocommerce wpb_content_element columns-' . $columns . '">' . ob_get_clean() . '</div>';
        }
    
    /**
     * Display product categories 
     * @global    $woocommerce
     * @param     array  $atts  
     * @atts      int $number 
     * @atts      string $order (asc or desc)  
     * @atts      string $columns (default 4)
     * @atts      int $hide_empty (0 or 1)
     * @atts      string $orderby 
     * @atts      int $show_count (0 or 1)
     * @atts      string $ids (liste of id separate with comma)
     * @return    $product_categories_html
     */
    public function grand_popo_product_categories($atts) {
            global $woocommerce_loop;

            $atts = shortcode_atts(array(
                'number' => null,
                'order' => 'ASC',
                'columns' => '4',
                'hide_empty' => 1,
                'orderby' => 'name',
                'show_count' => 1,
                'ids' => ''
                    ), $atts);

            if (isset($atts['ids'])) {
                $ids = explode(',', $atts['ids']);
                $ids = array_map('trim', $ids);
            } else {
                $ids = array();
            }

            $hide_empty = ( $atts['hide_empty'] == true || $atts['hide_empty'] == 1 ) ? 1 : 0;

            $taxonomy = 'product_cat';
            $show_count = absint($atts['show_count']);

            $args = array(
                'taxonomy' => $taxonomy,
                'orderby' => $atts['orderby'],
                'order' => $atts['order'],
                'include' => $ids,
                'pad_counts' => true,
                'show_count' => $show_count,
                'hierarchical' => 1,
                'hide_empty' => $hide_empty,
                'child_of' => 0,
                'number' => absint($atts['number']),
            );


            $all_categories = get_categories($args);

            $columns = absint($atts['columns']);
            if ($columns == 1) {
                $wrapper_class = "grand_popo-product-cat o-wrap ";
                $columns_medium = 1;
            } else {

                $wrapper_class = "grand_popo-product-cat o-wrap xl-gutter-24 lg-gutter-24 md-gutter-24 sm-gutter-0 ";
                $columns_medium = 2;
            }
            ob_start();
            if ($all_categories) {
                echo '<div class="' . $wrapper_class . '" >';

                foreach ($all_categories as $cat) {


                    if ($cat->category_parent == 0) {
                        ?>
                    <div class="col xl-1-<?php echo $columns; ?> lg-1-<?php echo $columns; ?> md-1-<?php echo $columns_medium; ?>  sm-1-1 grand_popo-cat-item ">
                        <div class="product-category product">
                    <?php
                    $category_id = $cat->term_id;
                    $category_link = get_term_link($cat, 'product_cat');
                    $count = $cat->count;

                    if ($show_count == 1) {
                        $display_count = "(" . $count . ")";
                    } else {
                        $display_count = "";
                    }
                    echo "<ul class='category'><li><a href='$category_link'>" . $cat->name . $display_count . "</a>";
                    $args2 = array(
                        'taxonomy' => $taxonomy,
                        'child_of' => 0,
                        'parent' => $category_id,
                        'orderby' => $atts['orderby'],
                        'order' => $atts['order'],
                        'show_count' => $show_count,
                        'pad_counts' => 1,
                        'hierarchical' => 1,
                        'hide_empty' => $hide_empty
                    );

                    $sub_cats = get_categories($args2);
                    if ($sub_cats) {

                        foreach ($sub_cats as $sub_category) {
                            echo "<ul class='subcategory'>";

                            if ($sub_category) {
                                $sub_category_link = get_term_link($sub_category, 'product_cat');
                                $count = $sub_category->count;

                                if ($show_count == 1) {
                                    $display_count = "(" . $count . ")";
                                } else {
                                    $display_count = "";
                                }
                                echo "<li><a href='$sub_category_link'>" . $sub_category->cat_name . $display_count . "</a></li>";
                            } 
                            echo "</ul>";
                        }
                    } 
                    ?>
                    </li>
                </ul>
                <?php
                wp_reset_query();
                ?>
                </div>
            </div>
                            <?php
        }
    }
    ?>
</div>
    <?php
        }
        return '<div class="woocommerce wpb_content_element columns-' . $columns . '">' . ob_get_clean() . '</div>';
    }
    /**
     * Display product on discount
     * @global    $woocommerce
     * @param     array  $atts  
     * @atts      int $columns (default 4) 
     * @atts      string $discount_id  
     * @return    $discount_products_html
     */
    public function grand_popo_get_discount_products_shortcode($atts) {
        $atts = shortcode_atts(array(
            'discount_id' => '',
            'columns' => 4,
                ), $atts);

        if (isset($atts['discount_id'])) {
            $discount = $atts['discount_id'];
            $products = grand_popo_get_discount_products($discount);
        }

        // Get WooCommerce Global
        global $woocommerce;

        // If no data, quit
        if (empty($products))
            return;

        // Create the object
        ob_start();

        $columns = !empty($atts['columns']) ? absint($atts['columns']) : 4;

        // Create query arguments array
        $query_args = array(
            'posts_per_page' => "1000",
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $products,
            'orderby' => 'rand'
        );

        // Add meta_query to query args
        $query_args['meta_query'] = array();

        // Check products stock status
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query'] = array_filter($query_args['meta_query']);

        // Create a new query
        $r = new WP_Query($query_args);

        // If query return results
        if ($r->have_posts()):

            if ($columns == 1) {
                $columns_medium = 1;
                $product_wrap_class = "o-wrap  products";
            } else {
                $columns_medium = 2;
                $product_wrap_class = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-24 sm-gutter-0 products";
            }
            $product_item_class = "col xl-1-" . $columns . " lg-1-" . $columns . " md-1-" . $columns_medium . " sm-1-1 grand_popo-products";
            ?>
            <div class="<?php echo $product_wrap_class; ?>">
            <?php
            while ($r->have_posts()) :

                $r->the_post();
                ?>
                    <div class="<?php echo $product_item_class; ?>">
                <?php
                wc_get_template_part('content', 'product-shortcode');
                ?>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
                    <?php
                endif;

                woocommerce_reset_loop();
                wp_reset_postdata();


                return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
            }
    /**
     * Display all discount
     * @param     array  $atts  
     * @atts      string $url 
     * @atts      string $discount_id  
     * @atts      string $color
     * @return    $discount_html
     */
    public function grand_popo_display_discount($atts) {
        $atts = shortcode_atts(array(
            'discount_id' => '',
            'url' => '',
            'color' => '',
                ), $atts);

        $discount_id = (($atts['discount_id'])) ? $atts['discount_id'] : 0;
        $discount_color = (($atts['color']) || !empty($atts['color'])) ? "color: ".$atts['color'] .";" : "";
        if ($atts['discount_id']) {
            $discount_url = $atts['discount_id'];
        } else {
            $discount_url = "";
        }
        $discounts = get_post($discount_id);
        if ($discounts) {
            if (!empty($discount_url)) {
                ?>
            <a href="<?php echo $discount_url; ?>" style="<?php echo $discount_color; ?>" alt="<?php echo $discounts->post_title; ?>">
            <?php
            }
            echo $discounts->post_title;

            if (!empty($discount_url)) {
                ?>
                </a>
                <?php
            }
        }
    }
            
            
}
