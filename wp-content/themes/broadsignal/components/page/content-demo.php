<?php
//global $wp_session;
$wp_session = WP_Session::get_instance();

$column_class_array = array(
    5 => 'col2-column',
    2 => 'col-xs-12  col-sm-6  col-md-6',
    1 => ''
);
$step_no = 1;
$terms = get_the_terms( get_the_ID(), 'nbntype' );
                         
$nbntype_class = '';
if ( $terms && ! is_wp_error( $terms ) ) : 
    foreach ($terms as $term):
        $nbntype_class .= strtolower($term->name) . ' ';
    endforeach;
endif;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>  aria-hidden="false">
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages( array(
        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'grand-popo' ),
        'after'  => '</div>',
        ) );
        ?>

        <?php  if(isset($wp_session['nbn_product_message'])): ?>
        <div class="message">
            <?php echo $wp_session['nbn_product_message'] ; ?>
            <?php unset($wp_session['nbn_product_message']); ?>
        </div>
        <?php endif; ?>
    </div>
    <footer class="entry-footer">
        <?php
        edit_post_link(
        sprintf(
        /* translators: %s: Name of current post */
        esc_html__( 'Edit %s', 'grand-popo' ),
        the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<span class="edit-link">',
        '</span>'
        );
        ?>
    </footer>
    <?php while (have_rows('steps')):  the_row(); ?>
    <div class="row has-price step-wrapper">
        <div class="<?php echo $nbntype_class; ?>" >
            <h2 class="textcenter">
            <?php echo $step_no; ?>. <?php the_sub_field('step_title'); ?>
            </h2>
            <?php 
                $column_class = $column_class_array[get_sub_field('no_of_column')]; 
                $step_type = get_sub_field('step_type');
            ?>
            <div class="clearfix">
                <?php while (have_rows('items')):  the_row(); ?>
                <!--- START OF <?php echo the_sub_field('title'); ?>  -->
                <div class="<?php echo $column_class; ?>">
                    <div class="price-outer-wrapper option-S <?php echo strtolower(get_sub_field('title')); ?>">
                        <div class="price-wrapper">
                            <div class="price price-S inner-wrap" style="text-align:justify">
                                <div class="value-box value-box-S">
                                    <h3 class="price-title price-title-S">
                                    <?php the_sub_field('title'); ?>
                                    </h3>
                                    <div class="value-box-content">
                                        <?php the_sub_field('value_box'); ?>
                                    </div>
                                </div>
                                <div class="content-box small">
                                    <?php the_sub_field('content_box'); ?>
                                </div>
                                <div class="meta-box">
                                    <a class="btn btn-default scrollable-btn" data-step="<?php echo $step_no; ?>" data-interval="<?php the_sub_field('interval');  ?>" data-value="<?php the_sub_field('price');  ?>" data-description = "<?php the_sub_field('short_description'); ?>"  data-type="<?php  echo $step_type; ?>">
                                        <span class="btext">
                                            Select
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- END OF <?php echo the_sub_field('title'); ?>  -->
                <?php 
                
                endwhile;?>
            </div>
            <div class="push" style="height:10px">
            </div>
        </div>
    </div>
    <div class="sep">
    </div>
    <?php
    $step_no++;
    endwhile;?>
    <?php  if($step_no > 1): ?>
    <div class="row  step-wrapper">
        <div class="inner-wrap nobdr"" id="terms">
            <h2 class="textcenter">
            <?php echo $step_no; ?>. Confirm order
            </h2>
            <div id="terms-wrapper">
            </div>
        </div>
    </div>
 
    <div class="row step-wrapper ">
        <div "="" class="inner-wrap nobdr" id="order-summary">
            <h2 style="text-align: center;">
            Your Order
            </h2>
            <div class="mgt25" id="order-summary-wrapper">
                <div class="left-side col-md-6" id ="order-details">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Selected Plan:
                        </label>
                        <div class="col-sm-8">
                            <span id="plans">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Monthly:
                        </label>
                        <div class="col-sm-8">
                            <span id="monthly-total"> $
                            <span id="monthly">
                            </span>
                            </span>
                        </div>
                    </div>
                 
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                           Modem NF18ACV
                        </label>
                        <div class="col-sm-8">
                            <span id="modem-total">
                                $
                                <span id="modem">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Setup Fee
                        </label>
                        <div class="col-sm-8">
                            <span id="setup-total">
                                $
                                <span id="setup">
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Total Initial Cost:
                        </label>
                        <div class="col-sm-8">
                            <span id="total">
                                $
                                <span id="initial-cost">
                                </span>
                            </span>
                        </div>
                    </div>
                     
                </div>
                <div class="order-right-side col-md-6" id="order-button">
                    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" id="form" method="post">
                        <input name="action" type="hidden" value="order_form">
                        <input class="form-control" id="orderdetails" name="orderdetails" type="hidden">
                        <input class="form-control" id="product" name="product" type="hidden" value="<?php the_title(); ?>">
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
                            Place Order
                            </button>
                            <input class="form-control" id="package" name="orderdetails" required="" type="hidden">
                            </input>
                        </div>
                        </input>
                        </input>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <?php endif; ?>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Order Confirmation</h4>
          </div>
          <div class="modal-body" id="myModalMessage">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
</div>
<script type="text/javascript">
var plans = [];
<?php $steps = 1; ?>
<?php while (have_rows('steps')):  the_row(); ?>

plans['<?php echo  $steps++ ?>'] = {
    price: 0,
    type:'<?php the_sub_field('step_type'); ?>',
    interval: '',
    description: '',
    selected: false
}
<?php endwhile; ?>

    
jQuery(document).ready(function() {
    $('.scrollable-btn').click(function() {
        
        
        btnvalue = $(this).find('span').html();
        btnvalue = $.trim(btnvalue);
        step = $(this).attr('data-step');

    
        description = $(this).attr('data-description');
        interval = $(this).attr('data-interval');
        price = $(this).attr('data-value');
        type = $(this).attr('data-type');


    
        if(btnvalue == 'Select') {
            btnvalue = 'Selected';

            //if selected then go to next step
            // var stephtml = $(this).closest('.step-wrapper');
            // var next = $(stephtml).next();

            // $('html,body').animate({
            //     scrollTop: $(next).offset().top
            // }, 'slow');
        } else {
            btnvalue = 'Select';
         
        }


        html = $(this).closest('.row').find('.price-outer-wrapper').each(function() {
            $(this).removeClass('selected');
            $(this).find('.btext').html('Select');
        });

        if(btnvalue == 'Selected') {
            $(this).closest('.price-outer-wrapper').addClass('selected');
        }
        $(this).find('span').html(btnvalue);

        if (btnvalue == 'Select'){
            reset_step(step);
        } else {
        
            plans[step].price = price;
            plans[step].interval = interval;
            plans[step].description = description;
            plans[step].selected = true;

        }
        

        calculate_price();
        

    });
    $('#form').submit(function(e) {
        e.preventDefault();
        var actionurl = $(this).attr('action');
        $('#orderdetails').html($('#order-summary').html());
        //do your own request an handle the results
        $.ajax({
            url: actionurl,
            type: 'post',
            //dataType: 'json',
            data: $("#form").serialize(),
            success: function(data) {
                $('#myModalMessage').html('Your Order has been sent. We will contact you by within 24-48 hours.');
                $('#myModal').modal();
            }
        });
    });
}); 


function reset_step(step) {
    plans[step].price = 0;
    plans[step].description = '';
    plans[step].interval = '';
    plans[step].selected = false;
}

function calculate_price() {
    monthly = 0;
    total = 0;
    plan = '<ul>';
    modem = 0;
    setup = 79;
    intialcost = 0;
    for (var i in plans) {
        if(plans[i].type == "plan" && plans[i].description != ''){
            plan += "<li>"+ plans[i].description + "</li>"
        }
        if(plans[i].interval == "monthly"){
            monthly += Number(plans[i].price); 
        }
        if(plans[i].type == "modem"){
            modem += Number(plans[i].price); 
        }

    }
    plan += '</ul>';

    total = Number(monthly) + Number(setup) + Number(modem);
    initialcost = Number(setup) + Number(modem);

    $('#plans').html(plan);
    $('#monthly').html(monthly);
    $('#modem').html(modem);
    $('#setup').html(setup);
    $('#initial-cost').html(initialcost);

    $('#package').val($('#order-details').html());


    


}
</script>