<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://github.com/MakiOmar
 * @since      1.0.0
 *
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/includes
 * @author     Mohammad Omar <maki3omar@gmail.com>
 */
class Anony_Wc_Checkout_Uploads_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'anony-wc-checkout-uploads',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
