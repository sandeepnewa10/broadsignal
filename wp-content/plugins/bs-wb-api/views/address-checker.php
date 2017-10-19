<?php

if(isset($_POST['submit'])) {
	if(trim($_POST['address_check']) === '') {
		$addError = 'Please enter a valid address to check';
		$hasError = true;
	} else {
		$address = trim($_POST['address_check']);
		//echo Bswb_Widget::listGnafAddress('1 test avenue testville');
	}

	// Call API and list another form
	
	
}
?>
<div class="row">
	<div class="kc-title-wrap"><h2>check my address</h2></div>
</div>
<div class="row">
<form method="post" action="<?php echo the_permalink(); ?>" >
<div class="col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
<div class="input-group">
 
  <input type="text" class="address_field form-control" name="address_check" value="<?php echo esc_attr($_POST['address_check']); ?>">
  <div class="input-group-btn">
  	<button type="submit" class="btn btn-default" value="Check Address Eligibility" name="submit">Check Address Eligibility</button>
  
  </div>
</div></div>
    </form></div>