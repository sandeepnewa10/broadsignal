<?php
/**
* Template Name: NBN Error Template
*
*/
get_header();
global $post;
$page_layout = get_post_meta($post->ID, 'grand_popo_page_options', true);
if (is_page('wishlist') || is_page('cart') || is_page('checkout') || is_page('my-account') || is_front_page()) {
$page_layout = grand_popo_get_proper_value($page_layout, 'sidebar-position', 'no-sidebar');
} else {
$page_layout = grand_popo_get_proper_value($page_layout, 'sidebar-position', 'left');
}
$layout=$page_layout;
if ($layout == "no-sidebar") {
$gutter = "o-wrap";
$col = "col xl-1-1 lg-1-1 md-1-1 sm-1-1";
} else {
$gutter = "o-wrap xl-gutter-24 lg-gutter-24 md-gutter-0 sm-gutter-0";
$col = "col xl-3-4 lg-3-4 md-1-1 sm-1-1";
}
?>
<style type="text/css" ></style>
<div class=" <?php echo esc_attr($gutter);?>">
    <?php
    if ($layout == "left") {
    get_sidebar();
    }
    ?>
    <div id="primary" class="<?php echo esc_attr($col); ?>">
        <main id="main" class="container">
            <?php
            while (have_posts()) : the_post();
            get_template_part('components/page/content', 'page');
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
            comments_template();
            endif;
            endwhile; // End of the loop.
            ?>
            <section class="row">
            <div class="order-right-side col-md-6" id="order-button">
                <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" id="form" method="post">
                    <input name="action" type="hidden" value="nbnrequest_form">
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="firstname">
                            First Name
                        </label>
                        <input class="form-control" id="firstname" name="firstname" required="" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="lastname">
                            Last Name
                        </label>
                        <input class="form-control" id="lastname" name="lastname" required="" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label for="email">
                            Email Address
                        </label>
                        <input class="form-control" id="email" name="email" required="" type="email">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="mobile">
                            Mobile Number
                        </label>
                        <input class="form-control" id="mobile" name="mobile" required="" type="mobile">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="phone-area-number">
                            Phone Number
                        </label>
                        <div class="row">
                            <div class="form-group col-xs-4 col-sm-4 col-md-4">
                                <input class="form-control" id="phone-area-number" name="phone-area-number" type="text">
                                <label for="phone-area-number" style="font-size: 12px; font-weight:400;">
                                    Area Code
                                </label>
                                </input>
                            </div>
                            <div class="form-group col-xs-8  col-sm-8 col-md-18">
                                <input class="form-control" id="phone-line-number" name="phone-line-number" type="text">
                                <label for="phone-line-number" style="font-size: 12px; font-weight:400;">
                                    Phone Number
                                </label>
                                </input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label for="Address1">
                            Address Line 1
                        </label>
                        <input class="form-control" id="address1" name="address1" required="" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 mgt15">
                        <label for="address2">
                            Address Line2
                        </label>
                        <input class="form-control" id="address2" name="address2" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="suburb">
                            Suburb
                        </label>
                        <input class="form-control" id="suburb" name="suburb" required="" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="state">
                            Postal Code
                        </label>
                        <input class="form-control" id="postalcode" name="postalcode" required="" type="text">
                        </input>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="state">
                            State
                        </label>
                        <input class="form-control" id="state" name="state" required="" type="text">
                        </input>
                    </div>
                    <div "="" class="form-group col-sm-6 col-md-6 clearfix mgt15">
                        <button class="btn btn-default" type="submit">
                        Regisiter
                        </button>
                        
                        </input>
                    </div>
                    </input>
                    </input>
                </form>
            </div>
            
            </section><div class="sep"></div>
        </main>

        </div>
        <?php
        if ($layout == "right") {
        get_sidebar();
        }
        ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Registration Confirmation</h4>
                </div>
                <div class="modal-body" id="myModalMessage">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    
    jQuery(document).ready(function() {
    $('#form').submit(function(e) {
    e.preventDefault();
    var actionurl = $(this).attr('action');
    //do your own request an handle the results
    $.ajax({
    url: actionurl,
    type: 'post',
    //dataType: 'json',
    data: $("#form").serialize(),
    success: function(data) {
    $('#myModalMessage').html('Your New NBN Request has been sent. We will contact you by within 24-48 hours.');
    $('#myModal').modal();
    }
    });
    });
    });
    </script>
    <?php
    get_footer();