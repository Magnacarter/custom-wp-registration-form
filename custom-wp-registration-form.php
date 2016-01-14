<?php
/*
Plugin Name: Custom WP Registration Form
Plugin URI:  https://github.com/Magnacarter/custom-wp-registration-form
Description: Registration form with wp_nonce, spam honey pot, error handling
Version:     1.0.0
Author:      Adam Carter
Author URI:  http://adamkristopher.com
License:     GPLv2+
*/

/**
 * Class Form to build HTML forms dynamically
 *
 * Instantiate a form object and pass the build_form method an associative 
 * array of form elements and attributes. Form usees wp_non_field for security.
 * Uses a PHP callback to validate escape and sanitize user inputs before
 * adding them to the database.
 */
class CWRF_Form {
	public $form_name;
	public $method;
	public $submit_text;
	public $user_data;
	public $fields = array();
	public $message;

	/**
	 * Constructor method defines vars for our form
	 *
	 * @param string $form_name
	 * @param array  $fields Supply associative array for form building
	 * @param string $subnit_text Button text, default is 'Submit'
	 */
	function __construct( $form_name = '', $fields = array(), $submit_text = 'Submit' ) {
		$this->form_name   = $form_name;
		$this->fields      = $fields;
		$this->submit_text = $submit_text;
		$this->cwrf_build_form( $fields );
	}

	/**
	 * Build form method constructs our HTML form. 
	 * 
	 * @param array $fields Pass this method an associative array 
	 * contain attributes for the input element
	 */
	function cwrf_build_form( $fields ) {
		//build_form runs in construct with an empty $fields and runs again w/ a set $fields array
		//This stops build_form from firing if the $fields array is empty
		if ( empty( $fields ) ) {
			return;
		}

		?>

			<form name="<?php echo esc_attr( $this->form_name ) ?>" method="POST">
				<div class="form-title">
					<h2><?php echo esc_html( $this->form_name )?></h2>
				</div>

				<?php

				foreach( $fields as $input_fields ) {
					extract( $input_fields );
					if( $required === true ) {
						$req = 'required';
					} else {
						$req = '';
					}
					switch( $type ) {
						case 'text': 
							$input = sprintf( '<div class="%s"><p><input type="%s" name="%s" id="%s" minlength="%d" maxlength="%d" placeholder="%s" ' . $req . '></p></div>', 
								esc_attr( $class ), 
								esc_attr( $type ), 
								esc_attr( $name ), 
								esc_attr( $id ), 
								$minlength, 
								$maxlength, 
								esc_attr( $placeholder ) 
							);
							echo $input;
							break;

						case 'password': 
							$input = sprintf( '<div class="%s"><p><input type="%s" name="%s" id="%s" minlength="%d" maxlength="%d" placeholder="%s" ' . $req . '></p></div>', 
								esc_attr( $class ), 
								esc_attr( $type ), 
								esc_attr( $name ), 
								esc_attr( $id ), 
								$minlength, 
								$maxlength, 
								esc_attr( $placeholder )
							 );
							echo $input;
							break;

						case 'email':
							$input = sprintf( '<div class="%s"><p><input type="%s" name="%s" id="%s" minlength="%d" maxlength="%d" placeholder="%s" ' . $req . '></p></div>', 
								esc_attr( $class ), 
								esc_attr( $type ), 
								esc_attr( $name ), 
								esc_attr( $id ), 
								$minlength, 
								$maxlength, 
								esc_attr( $placeholder ) 
							);
							echo $input;
							break;

						case 'textarea':
							$input = sprintf( '<div class="%s"><p><textarea name="%s" id="%s" rows="%d" cols="%d" placeholder="%s" ' . $req . '></textarea></p></div>', 
								esc_attr( $class ), 
								esc_attr( $name ), 
								esc_attr( $id ), 
								$rows, 
								$cols, 
								esc_attr( $placeholder ) 
							);
							echo $input;
							break;

						case 'file':
							?>
								<div class="<?php echo esc_attr( $class ) ?>"><Label for="<?php echo $name ?>"><?php echo ucwords( str_replace( '_', ' ', esc_html( $name ) ) ) ?></Label>
							<?php 
							$input = sprintf('<input type="%s" name="%s" accept="%s">', esc_attr( $type ), esc_attr( $name ), esc_attr( $accept ) );
							echo $input;
							?>
							</div>
							<?php
							break;

						case 'select':
							?>
								<div class="<?php echo esc_attr( $class ) ?>"><Label for="<?php echo $name ?>"><?php echo ucwords( str_replace( '_', ' ', esc_html( $name ) ) ) ?></Label>
							<?php
							$values[] = sprintf( '<p><select name="%s" id="%s">', esc_attr( $name ), esc_attr( $id ) );
							foreach( $options as $select ) {
								$values[] .= sprintf('<option value="%s">%1$s</option>', $select );	
							}
							$values[] .= '</select></p></div>';
							$output = implode( ',', $values );
							echo $output;	
							break;

						case 'radio':
							?>
								<div class="<?php echo esc_attr( $class ) ?>"><Label for="<?php echo $name ?>"><?php echo ucwords( str_replace( '_', ' ', esc_html( $name ) ) ) ?></Label>
							<?php
							$buttons = array();	
							foreach ( $value as $input ) {
								$buttons[] .= sprintf( '<p><input type="%s" name="%s" id="%s" value="%s"> %4$s</p>', 
									esc_attr( $type ), 
									esc_attr( $name ), 
									esc_attr( $id ), 
									ucwords( str_replace( '_', ' ', esc_html( $input ) ) ) 
									);
								}
							$output = implode( ',', $buttons );	
							print_r( str_replace( ',', ' ', $output ) );
							?>
								</div>
							<?php	
							break;
					}
				}

				$registration_token = strtolower( wp_generate_password( 10, false, false ) ) ?>

				<input type="hidden" name="registration_token" value="<?php echo esc_attr( $registration_token ) ?>">

				<input id="test" type="text" name="pot" value="" style="display:none;">

				<?php wp_nonce_field( 'user_registration-' . $registration_token, 'registration_nonce' ) ?>
					<p>
						<button type="submit" id="submit-registration"><?php echo esc_html( $this->submit_text ) ?></button>
					</p>
				</div>
			</form>
		<?php
	}

	/**
	 * Process form method is a callback function that listens for a post request 
	 * and then processes and sanitizes user input from our form
	 * 
	 * @return void
	 */
	public function cwrf_process_form() {
		//Check to see if 'POST' exists and verify nonce.
		if ( 
			'POST' !== $_SERVER['REQUEST_METHOD']
			||
			! isset( $_POST['registration_token'] )
			||
			! isset( $_POST['registration_nonce'] )
			||
			false === wp_verify_nonce( $_POST['registration_nonce'], 'user_registration-' . $_POST['registration_token'] )
			) {
				return;
			}

		if ( ! empty( $_POST['pot'] ) ) {
			wp_die( 'Hello, Mr. Roboto. No form for you.' );
		}

		//Check to see if user is logged in
		if ( is_user_logged_in() ) {
			wp_die( 'You are already logged in as a user.' );
		} else {
			foreach ( $_POST as $key => $value ) {
				//Validate email if it exists
				if ( false !== is_email( $value ) && email_exists( $value ) !== false ) {
					wp_die( 'That email address is associated with another user.' );
				} 
				//Sanitize email
				if ( false !== is_email( $value ) ) {
					$clean_email = sanitize_email( $value );
					$user_data[ $key ] = $clean_email;
				//Make sure value exists and sanitize it
				} elseif ( $key !== 'pot' && empty( $value ) ) {
					wp_die( 'Please enter a value for the <i><b>' . ucwords( str_replace( '_', ' ', $key ) ) . '</b></i> field.' );
				} else {
					$clean_input = sanitize_text_field( $value );
					$user_data[$key] = $clean_input;
				}
			}
		}

		if ( ! empty( $user_data ) ) {
			extract( $user_data );

			//Create new WP user and return new ID
			$user_meta_fields = array_diff_key( $user_data, array( 
				'registration_nonce' => null, 
				'_wp_http_referer'   => null, 
				'registration_token' => null, 
				'pot'                => null 
			) );

			$user_id = wp_insert_user( $user_meta_fields );

			//Add the rest of the fields to user meta in your WordPress db
			foreach ( $user_meta_fields as $meta_key => $meta_value ) {
				add_user_meta( $user_id, $meta_key, $meta_value );
			}

			$creds = array(
				'user_login'    => $user_login,
				'user_password' => $user_pass,
				'remember'      => true,
			);

			$user = wp_signon( $creds, false );

			if ( is_wp_error( $user ) ) {
				wp_die( $user->get_error_message() );
			}

		} else {
			wp_die( "Required fields are missing. Please fill out form." );
		}

		wp_redirect( home_url() );
		exit;
	}

	/**
 	 * Show custom user meta in user admin panel
 	 *
     * @param object $user is WP_User object. Gets passed at hook 
     */
    public function cwrf_user_details( $user ) {

  		$all_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user->ID ) );

    	//meta_keys to exclude from adding to profile page
    	//because they have been added in the premade fields or aren't relevant
    	//The values in this array are irrelevant
    	$custom_meta = array_diff_key( $all_meta, array(
			'nickname'             => null, 
			'first_name'           => null, 
			'last_name'            => null, 
			'user_email'           => null, 
			'user_pass'            => null, 
			'user_login'           => null, 
			'test_user_level'      => null, 
			'test_capabilities'    => null, 
			'show_admin_bar_front' => null, 
			'use_ssl'              => null, 
			'admin_color'          => null, 
			'comment_shortcuts'    => null, 
			'rich_editing'         => null,
			'description'          => null 
    	 ) );

    	 ?>

    	<h3><?php echo $user->first_name ?>'s Details</h3>
    	<table class="form-table">
    	<?php 
	    	foreach ( $custom_meta as $key => $value ) {
	    		?>
	    		<tr>
	    			<th><label><?php echo esc_html( ucwords( str_replace( '_', ' ', $key ) ) ) ?></label></th>
	    			<td><input type="text" value="<?php echo $value ?>" class="regular-text"/></td>
	        	</tr>
	        	<?php
	        }
        ?>
        </table>
        <?php
	}	
}

/**
 * Hook our methods into WordPress
 *
 * @add_action wp
 * @add_action show_user_profile
 * @add_action edit_user_profile
 */
$form = new CWRF_Form;
add_action( 'wp', array( $form, 'cwrf_process_form' ) );
add_action( 'show_user_profile', array( $form, 'cwrf_user_details' ), 999 );
add_action( 'edit_user_profile', array( $form, 'cwrf_user_details' ), 999 );