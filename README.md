=== Custom WP Registration Form ===
Contributors: adamcarter
Tags: registration, registration form, secure, custom, WordPress plugin
Requires at least: 3.0.1
Tested up to: 4.4.1
Stable tag: 4.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a custom WordPress registration form with an array that automatically logs in user. Define your own input types, attributes, classes & IDs

== Description ==

Create a custom user registration form with an associative array. Use HTML form element attributes as array keys to create a form. Any custom array values are automatically added to new area of a user's profile page in the WordPress admin. Arrays containing values that match WordPress user meta syntax will have those input values automatically added to those premade values in the default WordPress profile page. 

Custom WP Registration Form comes with built in security and validation such as wp_nonce_field verification and spam honey pot. It also automatically escapes attributes and html outputs and sanitizes user input values. 

User must create a "CWRF Form" array. This array will need to be passed as an argument to the a new 'CWRF_Form' object. The CWRF Form array can currently take HTML form types: text, email, file, radio, select, and textarea as values to the key 'type'. More coming soon... also, I always welcome pull requests. 

**Development of this plugin is done [on GitHub](https://github.com/Magnacarter/custom-wp-registration-form). Pull requests welcome. Please see [issues](https://github.com/Magnacarter/custom-wp-registration-form/issues) reported there before going to the plugin forum.**

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/custom-wp-registration-form` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Create a form object in a .php file where you would like the form to appear. Example: page-register.php
	A. the CWRF_Form object takes three arguments
		1. string `$form_name` - default is "".
		2. array `$fields` - pass your array of input fields 
		3. string `$submit_text` - This is the text that appears on the submit button. Default is 'Submit'.

		Example : `$form = new CWRF_Form( $form_name, $fields, $submit_text );`
	B. Build the array. Here is the array used to build the form in the screenshots section.
		1. assign classes and ID's to retain full style control of all inputs. 
		2. each input field and textarea is wrapped in a `<div class="your-class">`. ID's are assigned to the input and textarea tags themselves.

			`$fields = array(
				'First Name' => array(
					'name'        => 'first_name',
					'type'        => 'text',
					'id'          => 'first_name',
					'class'       => '',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'First Name',
					'required'    => true
				),
				'Last Name' => array(
					'name'        => 'last_name',
					'type'        => 'text',
					'id'          => 'last_name',
					'class'       => '',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'Last Name',
					'required'    => true
				),
				'Username' => array(
					'name'        => 'user_login',
					'type'        => 'text',
					'id'          => 'user_login',
					'class'       => '',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'User Login',
					'rows'        => '',
					'cols'        => '',
					'required'    => true
				),
				'Password' => array(
					'name'        => 'user_pass',
					'type'        => 'password',
					'id'          => 'user_pass',
					'class'       => '',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'Password',
					'rows'        => '',
					'cols'        => '',
					'required'    => true
				),
				'Email Address' => array(
					'name'        => 'user_email',
					'type'        => 'email',
					'id'          => 'user_email',
					'class'       => '',
					'minlength'   => 1,
					'maxlength'   => 50,
					'placeholder' => 'jon@mail.com',
					'required'    => false
				),
				'Options' => array(
					'name'        => 'favorite_fruit',
					'type'        => 'select',
					'id'          => 'favorite_fruit',
					'class'       => '',
					'options'     => array( 'apple', 'cherry', 'pear' ),
					'required'    => false
				),
				'Gender' => array(
					'name'        => 'gender',
					'type'        => 'radio',
					'id'          => 'gender',
					'class'       => '',
					'value'       => array( 'male', 'female' ),
					'required'    => false
				),
				'Bio' => array(
					'name'        => 'description',
					'type'        => 'textarea',
					'id'          => 'description',
					'class'	      => '',
					'minlength'   => 1,
					'maxlength'   => 500,
					'placeholder' => 'Add your bio',
					'rows'        => 5,
					'cols'        => 50,
					'required'    => false
				)
			);

			$form = new CWRF_Form( 'Test Form', $fields, 'Sign Up!' );`

	C. Note, the array values that match the WordPress syntax for insertion to the default WordPress profile page in the admin panel. When you don't use this syntax, values will be added below the premade profile meta section. Refer to screenshots to see how this form is rendered in the default WordPress user profile page.

	D. Form is set to `method = 'POST'`

== Screenshots ==

1. Form the example array in the docs renders.
2. Example of predefined user fields rendered in the default user WordPress profile.
3. Example of custom user fields rendered in the default user WordPress profile.

== Changelog ==

= 1.0.0 - January 14, 20116 =

Initial release!

Props [Magnacarter](https://github.com/Magnacarter)