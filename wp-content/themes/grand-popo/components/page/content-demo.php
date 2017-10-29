<?php
$column_class_array = array(
5 => 'col2-column',
2 => 'col-xs-10 col-xs-push-1  col-sm-8  col-sm-push-2  col-md-6 col-md-push-0',
1 => ''
);
$step_no = 1;
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
        <div class="personal"  id='internet-plan'>
            <h2 class="textcenter">
            <?php echo $step_no++; ?>. <?php the_sub_field('step_title'); ?>
            </h2>
            <?php $column_class = $column_class_array[get_sub_field('no_of_column')]; ?>
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
                                <div class="content-box">
                                    <?php the_sub_field('content_box'); ?>
                                </div>
                                <div class="meta-box">
                                    <a class="btn btn-default scrollable-btn" data-action="plan"  data-value="<?php the_sub_field('price'); ?>" data-type="<?php  the_sub_field('title') . ' ' .the_sub_field('price'); ?>">
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
                <?php endwhile;?>
            </div>
            <div class="push" style="height:10px">
            </div>
        </div>
    </div>
    <div class="sep">
    </div>
    <?php endwhile;?>
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
                <div class="left-side col-md-6">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Selected Plan:
                        </label>
                        <div class="col-sm-8">
                            <span id="selected-plan">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Monthly:
                        </label>
                        <div class="col-sm-8">
                            <span id="selected-contract">
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Total Initial Cost:
                        </label>
                        <div class="col-sm-8">
                            <span id="">
                                $
                                <span id="initial-cost">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">
                            Ongoing monthly fee:
                        </label>
                        <div class="col-sm-8">
                            <span id="">
                                $
                                <span id="ongoing-fee">
                                </span>
                                / month
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label" id="order-total">
                            Modem $169 + Freight  $9:
                        </label>
                        <div class="col-sm-8">
                            <span id="">
                                $
                                <span id="cost-today">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="order-right-side col-md-6" id="order-button">
                    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" id="form" method="post">
                        <input name="action" type="hidden" value="order_form">
                        <input class="form-control" id="orderdetails" name="orderdetails" type="hidden">
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
                            <input class="form-control" id="password" name="password" required="" type="email">
                            </input>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label for="mobile">
                                Mobile Number
                            </label>
                            <input class="form-control" id="repassword" name="repassword" required="" type="mobile">
                            </input>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label for="phone-area">
                                Phone Number
                            </label>
                            <div class="row">
                                <div class="form-group col-sm-4 col-md-4">
                                    <input class="form-control" id="repassword" name="phone-area-number" required="" type="phone-area-number">
                                    <label for="phone-area-number" style="font-size: 12px; font-weight:400;">
                                        Area Code
                                    </label>
                                    </input>
                                </div>
                                <div class="form-group col-sm-8 col-md-18">
                                    <input class="form-control" id="repassword" name="phone-line-number" required="" type="phone-line-number">
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
                            <input class="form-control" id="address1" name="Address1" required="" type="text">
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
                        </div>
                        </input>
                        </input>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="sep">
    </div>
    <?php endif; ?>
    
</div>
<script type="text/javascript">
var bill = {
plan:{price:0, type:''},
modem:{price:0, type:''},
phone:{price:0, type:''},
contract:{price:0, type:''}
};
jQuery(document).ready(function(){
$('.scrollable-btn').click(function(){
html = $(this).closest('.row').find('.price-outer-wrapper').each(function(){
$(this).removeClass('selected');
});
$(this).closest('.price-outer-wrapper').addClass('selected');
//data-action="modem"  data-value="199" data-type="NETCOMM NF17ACV"
action = $(this).attr('data-action');
price = $(this).attr('data-value');
type = $(this).attr('data-type');
console.log(action + price + type);
if(action=='plan'){
bill.plan.price = price;
bill.plan.type = type;
}else if(action=="modem"){
bill.modem.price = price;
bill.modem.type = type;
}else if(action =="phone"){
bill.phone.price = price;
bill.phone.type = type;
}else if(action =="contract"){
bill.contract.price = price;
bill.contract.type = type;
}
console.log(bill);
$('#selected-plan').html(bill.plan.type);
$('#selected-contract').html(bill.contract.type);
$('#selected-addons').html(bill.modem.type + ' ' + bill.phone.type );
$('#initial-cost').html( Number(bill.modem.price) + Number (bill.contract.price));
$('#ongoing-fee').html(  Number(bill.phone.price) +  Number(bill.plan.price));
$('#cost-today').html( Number(bill.modem.price) + Number (bill.contract.price) +  Number(bill.phone.price) +  Number(bill.plan.price));
$('#cost-monthly').html(  Number(bill.phone.price) +  Number(bill.plan.price));
//offset to the next div
// next wrapper
var step = $(this).closest('.step-wrapper');
var next = $(step).next();
console.log($(next).html());
$('html,body').animate({
scrollTop: $(next).offset().top},
'slow');
});
$('#form').submit(function (e) {
e.preventDefault();
var actionurl = $(this).attr('action');
$('#orderdetails').html($('#order-summary').html());
//do your own request an handle the results
$.ajax({
url: actionurl,
type: 'post',
dataType: 'application/json',
data: $("#form").serialize(),
success: function(data) {
console.log(data);
console.log('hello');
}
});
});
});
</script>