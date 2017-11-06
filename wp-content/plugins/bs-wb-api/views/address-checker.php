<?php
$wp_session = WP_Session::get_instance();


if(isset($_POST['submit'])) {
	if(trim($_POST['address_check']) === '') {
		$message = 'Please enter a valid address to check';
		$hasError = true;
	} else {
		$address = trim($_POST['address_check']);

    $response = Bswb_Widget::listGnafAddress($address); 

    if($response == 1){
      $hasError= false;
      $message = "Congratulations";
    }elseif ($response == 0) {
      # code...
      $hasError = true;
      $message  = "Address Not Found";
    }elseif($response == -1){
      $hasError = true;
      $message = "Error";
    }
}
?>



 <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body" id="myModalMessage">
              
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){


    	$('#myModalMessage').html('<?php echo $message ?>');
      <?php 
        if(!$hasError){
          $wp_session['nbn_product_message'] = "Congratulations!!! Your address has NBN Technologies available. Please select the plans";

      ?>
        window.setTimeout(function(){
          window.location.href = "<?php echo 'http://demo.broadsignal.com.au/?nbnproducts=personal-bundle'; ?>";

        }, 5000);
      <?php    
        } else {
      ?>
        window.setTimeout(function(){
          window.location.href = "<?php echo 'http://demo.broadsignal.com.au/?page_id=460'; ?>";

        }, 5000);
      <?php    
        } 
      ?>

     	$('#myModal').modal();	
    });
     </script>
<?php
		


	// Call API and list another form
	
	
}
?>
<div class="row">
	<div class="kc-title-wrap"><h2>check my address</h2></div>
</div>
<div class="row">
<form method="post" action="<?php echo the_permalink(); ?>" >
<div class="col-md-10 col-md-push-1 col-sm-12">
<div class="input-group">
 
  <input type="text" class="address_field form-control" name="address_check" value="<?php echo esc_attr($_POST['address_check']); ?>">
  <div class="input-group-btn">
  	<button type="submit" class="btn btn-default" value="Check Address Eligibility" name="submit">Check Address Eligibility</button>
  
  </div>
</div></div>
    </form></div>

