<?php
/**
 * 
 * Plugin Name: BroadSignal WideBand API Plug-in
 * Description: Plugin to connect with WideBand API
 * Version:     0.1
 * Author:      Dinkar Prajapati
 * License:     GPL2
 * Text Domain: bswb
 * 
*/

defined( 'ABSPATH' ) or die( 'No script editing!' );
define( 'BSWB__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BSWB__API_USER', 'gerry.travers' );
define( 'BSWB__API_PWD', 'ovation62@' );
define( 'BSWB__API_CREATE_REFRESH_TOKEN', 'https://api.wideband.net.au/prod/v1/token' );
define( 'BSWB__API_AUTOCOMPLETE_GNAF', 'https://api.wideband.net.au/prod/v1/nbn/address/autocomplete' );


add_action( 'wp_enqueue_scripts', 'bswb_add_enqueue_script' );
add_action( 'wp_enqueue_scripts', 'bswb_add_enqueue_script2' );
add_action('wp_footer', 'bswb_add_enqueue_footer_script');
add_action( 'wp_enqueue_scripts', 'bswb_add_styles' );

function bswb_add_enqueue_script() {
	wp_enqueue_script( 'js1', '//code.jquery.com/jquery-1.7.1.js', false );
}

function bswb_add_enqueue_script2() {
	wp_enqueue_script( 'js2', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js', false );
}

function bswb_add_styles() {
	wp_enqueue_style( 'p-custom-stylsheet', BSWB__PLUGIN_DIR . 'css/bswb-styles.css' );
}

function bswb_add_enqueue_footer_script() {
	$bswbwidget = new Bswb_Widget();
	$bswbwidget->checkAuthToken('');
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".address_field").autocomplete({
				source: function(request, response){
				var suggestURL = '<?php echo BSWB__API_AUTOCOMPLETE_GNAF; ?>';
				//suggestURL = suggestURL.replace('%QUERY', encodeURIComponent(request.term)); 
				$.ajax({
					url : suggestURL,
					delay : 300,
					dataType : "json",
					type : "POST",
					headers : {'Authorization' : 'Bearer <?php echo $bswbwidget->authtoken; ?>',
								'Content-Type' : 'application/json'},
					data : '{"search" : "1 test avenue testville" }',
					success : function (data) {
						var transformed = $.map(data.hits , function (el) {
							return {
							label : el.address,
							value : el.address,
							id : el.gnafId,
							};
						});
						response(transformed);
					},
					error: function () {
					response([]);
					}
				});
				}
			});
		});
	</script>
	<?php
}



// Register and load the widget
function bswb_load_widget() {
    register_widget( 'bswb_widget' );
}
add_action( 'widgets_init', 'bswb_load_widget' );
 

class Bswb_Widget extends WP_Widget {

	protected $authtoken = '';
	public $authtokenexp = '';
 
	function __construct() {
		parent::__construct( 'bswb_widget', __('BroadSignal Address Checking', 'bswb_widget_domain'), 		array( 'description' => __( 'BroadSignal NBN Address Checker', 'bswb_widget_desc' ), ) 
		);
	}

	public function __get($property) {
        switch ($property)
        {
            case 'authtoken':
                return $this->authtoken;
        }
    }
 
    public function __set($property, $value) {
        switch ($property)
        {
            case 'authtoken':
                $this->authtoken = $value;
                break;
        }
    }
	 
	// Creating widget front-end	 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		 
		include(BSWB__PLUGIN_DIR . 'views/address-checker.php');
		//$this->generateForm();

		

		echo $args['after_widget'];
	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'bswb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	// API CONNECTION TO GATHER ADDRESSES FROM THE INPUT VALUE
	public function listGnafAddress($useradd) {
		$this->checkAuthToken($this->authtoken);
		if( empty($this->authtoken) ) {
			return "Something went wrong";
		}

		$url = BSWB__API_AUTOCOMPLETE_GNAF;
		$response = wp_remote_post( $url, array(
						'method' => 'POST',
						'timeout' => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array('Authorization' => 'Bearer '.$this->authtoken,
										'Content-Type' => 'application/json'),
						'body' => json_encode(array( 'search' => $useradd )),
						'cookies' => array()
					    )
					);
		if ( is_wp_error( $response ) ) {
		   	$error_message = $response->get_error_message();
		   	return "Something went wrong: $error_message";
		} else {
			$clean_response = json_decode( wp_remote_retrieve_body( $response ), true) ;
			if(wp_remote_retrieve_response_code( $response ) == '200') {					
				$listarr = $clean_response['hits'];
				for($i=0; $i<count($listarr); $i++) {
					//echo $listarr[$i]['address'];
					if( $useradd == $listarr[$i]['address']) { //'106 WELWYN AVENUE, SALTER POINT WA'
						$gnafid = $listarr[$i]['gnafId'];
						return "Congratulations ... ". $gnafid;
					}
				}
				return "Address not found";
			} else {
				return $clean_response['error'];
			}

		   	// get status and then check for errors
		   	//echo $this->dropForm($clean_response['hits']);
		}
	}

	// GET GNAF ADDRESS
	public function checkAuthToken($autok='') {
		if( !empty($autok) ) {
			$this->getRefreshedToken($autok);
		} else {
			$this->getAuthToken();
		}
	}

	// CREATE TOKEN
	public function getAuthToken() {
		$url = BSWB__API_CREATE_REFRESH_TOKEN;
		$response = wp_remote_post( $url, array(
						'method' => 'POST',
						'timeout' => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array('Content-Type' => 'application/json'),
						'body' => json_encode(array( 'username' => BSWB__API_USER, 'password' => BSWB__API_PWD )),
						'cookies' => array()
					    )
					);
		if ( is_wp_error( $response ) ) {
		   	$error_message = $response->get_error_message();
		   	//$this->authtoken = '';
		   	$this->authtoken = '';
		   	return "Something went wrong: ". $error_message;
		} else {
			$clean_response = json_decode( wp_remote_retrieve_body( $response ) );
			if(wp_remote_retrieve_response_code( $response ) == '200') {					
				$this->authtoken = $clean_response->token;
		   		return $this->authtoken;
			} else {
		   		$this->authtoken = '';
				return $clean_response->error;
			}
		}
	}

	// REFRESH TOKEN
	public function getRefreshedToken($token) {
		$url = BSWB__API_CREATE_REFRESH_TOKEN; 
		$response = wp_remote_post( $url, array(
						'method' => 'PUT',
						'timeout' => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array('Authorization' => 'Bearer '.$token,
											'Content-Type' => 'application/json'),
						'body' => json_encode(array( 'username' => BSWB__API_USER, 'password' => BSWB__API_PWD )),
						'cookies' => array()
					    )
					);
		if ( is_wp_error( $response ) ) {
		   	$error_message = $response->get_error_message();
		   	$this->authtoken = '';
		   	return "Something went wrong: ". $error_message;
		} else {
			$get_put_response = json_decode( wp_remote_retrieve_body( $response ) );
			if(wp_remote_retrieve_response_code( $response ) == '200') { // STATUS OK
			   	if($get_put_response->refreshed == true) { // CHECK IF THE TOKEN IS REFRESHED
			   		$this->authtoken = $get_put_response->token;
			   	} else {
			   		$this->getAuthToken();
			   	}
		   	} else {
		   		$this->authtoken = '';
				return $get_put_response->error;
			}
		}
	}
} // Class bswb_widget ends here