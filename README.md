=== Custom WP Registration Form ===
Contributors: adamcarter
Tags: registration, form, secure form, custom form
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a custom user registration form with an array. Comes with wp_nonce verification, spam honey pot and various form validation features built in. 

== Description ==

Create a custom user registration form with an associative array. Use HTML form element attributes as array keys to create a form. Any custom input values are automatically added to new area of a user's profile page in the WordPress admin. Array containing values that match WordPress user meta syntax will have those input values automatically added to those premade values in the default WordPress profile page. 

Form comes with built in security and validation such as wp_nonce verification and spam honey pot.

Array can currently take form types: text, email, file, radio, select, and textarea. More coming soon... also, always welcome pull requests. 

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/custom-wp-registration-form` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Create a form object in a .php file where you would like the form to appear. Example: page-contact.php
	A. the form object takes three arguments
		1. string `$form_name` - default is "".
		2. array `$fields` - pass your array of input fields 
		3. string `$submit_text` - This is the text that appears on the submit button. Default is 'Submit'.

		Example : `$form = new Form( $form_name, $fields, $submit_text );`
	B. Build the array. Here is an example of a form array and then passing it to the form object. 
		1. assign classes and ID's to retain full style control of all inputs. 
		2. each input field and textarea is wrapped in a `<div class="your-class">`. ID's are assigned to the input and textarea tags themselves.

			`$fields = array(
				'First Name' => array(
					'name'        => 'first_name',
					'type'        => 'text',
					'id'          => 'first_name',
					'class'       => 'col-md-4',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'First Name',
					'required'    => true
				),
				'Last Name' => array(
					'name'        => 'last_name',
					'type'        => 'text',
					'id'          => 'last_name',
					'class'       => 'col-md-4',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'Last Name',
					'required'    => true
				),
				'Username' => array(
					'name'        => 'user_login',
					'type'        => 'text',
					'id'          => 'user_login',
					'class'       => 'col-md-4',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'User Login',
					'required'    => true
				),
				'Password' => array(
					'name'        => 'user_pass',
					'type'        => 'text',
					'id'          => 'user_pass',
					'class'       => 'col-md-4',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'Password',
					'required'    => true
				),
				'Email Address' => array(
					'name'        => 'user_email',
					'type'        => 'email',
					'id'          => 'user_email',
					'class'       => 'col-md-4',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'jon@mail.com',
					'required'    => false
				),
				'Options' => array(
					'name'        => 'favorite_fruit',
					'type'        => 'select',
					'id'          => 'favorite_fruit',
					'class'       => 'col-md-4',
					'options'     => array( 'apple', 'cherry', 'pear' ),
					'required'    => false
				),
				'Gender' => array(
					'name'        => 'gender',
					'type'        => 'radio',
					'id'          => 'gender',
					'class'       => 'col-md-12',
					'value'       => array( 'male', 'female' ),
					'required'    => false
				),
				'Bio' => array(
					'name'        => 'description',
					'type'        => 'textarea',
					'id'          => 'description',
					'class'	      => 'col-lg-1',
					'minlength'   => 1,
					'maxlength'   => 500,
					'placeholder' => 'Add your bio',
					'rows'        => 5,
					'cols'        => 50,
					'required'    => false
				)
			);

			$form = new Form( 'Test Form', $fields, 'Sign Up' );`

	C. Note that the array values match the WordPress syntax for insertion to the default WordPress profile page in the admin panel. When you don't use this syntax, values will be added below the premade profile meta section. 

	D. Form is set to `method = 'POST'`



== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.0.0 =
Initial Release