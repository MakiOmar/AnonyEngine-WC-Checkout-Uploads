<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/MakiOmar
 * @since             1.0.0
 * @package           Anony_Wc_Checkout_Uploads
 *
 * @wordpress-plugin
 * Plugin Name:       AnonyEngine WC Checkout Uploads
 * Plugin URI:        https://makiomar.com
 * Description:       Add upload inputs to WooCommerce checkout form.
 * Version:           1.0.011
 * Author:            Mohammad Omar
 * Author URI:        https://https://github.com/MakiOmar/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       anony-wc-checkout-uploads
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ANONY_WC_CHECKOUT_UPLOADS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-anony-wc-checkout-uploads-activator.php
 */
function activate_anony_wc_checkout_uploads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anony-wc-checkout-uploads-activator.php';
	Anony_Wc_Checkout_Uploads_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-anony-wc-checkout-uploads-deactivator.php
 */
function deactivate_anony_wc_checkout_uploads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anony-wc-checkout-uploads-deactivator.php';
	Anony_Wc_Checkout_Uploads_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_anony_wc_checkout_uploads' );
register_deactivation_hook( __FILE__, 'deactivate_anony_wc_checkout_uploads' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anony-wc-checkout-uploads.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

/**
 * Holds plugin's slug
 *
 * @const
 */
define( 'ANCUP_PLUGIN_SLUG', plugin_basename( __FILE__ ) );

/**
 * Holds plugin PATH
 *
 * @const
 */
define( 'ANCUP_DIR', wp_normalize_path( plugin_dir_path( __FILE__ ) ) );

require ANCUP_DIR . 'plugin-update-checker/plugin-update-checker.php';

$anonyengine_checkout_uploads = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/MakiOmar/AnonyEngine-WC-Checkout-Uploads',
	__FILE__,
	ANCUP_PLUGIN_SLUG
);

// Set the branch that contains the stable release.
$anonyengine_checkout_uploads->setBranch( 'master' );

function run_anony_wc_checkout_uploads() {

	$plugin = new Anony_Wc_Checkout_Uploads();
	$plugin->run();
}
run_anony_wc_checkout_uploads();
