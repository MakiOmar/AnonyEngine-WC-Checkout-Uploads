<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/MakiOmar
 * @since      1.0.0
 *
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/admin
 * @author     Mohammad Omar <maki3omar@gmail.com>
 */
class Anony_Wc_Checkout_Uploads_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anony_Wc_Checkout_Uploads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anony_Wc_Checkout_Uploads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/anony-wc-checkout-uploads-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anony_Wc_Checkout_Uploads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anony_Wc_Checkout_Uploads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/anony-wc-checkout-uploads-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Admin notices
	 */
	public function admin_notices() {
		// Make sure that WooCommerce plugin is active.
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Plugin AnonyEngine WC Checkout Uploads requires WooCommerce plugin activated.' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Render order upload.
	 *
	 * @param string $meta_key Meta key.
	 * @param object $order Order object.
	 * @return void
	 */
	protected function render_order_upload( $meta_key, $order ) {
		$meta_value = $order->get_meta( $meta_key );
		if ( $meta_value ) {
			printf(
				'<p>%s <br><a href="%s">%s</a></p>',
				esc_html( $meta_value['data_label'] ),
				esc_url( $meta_value['file_url'] ),
				esc_html( $meta_value['file_name'] )
			);
		}
	}

	/**
	 * Display uploads in order
	 *
	 * @param object $order Order.
	 * @return void
	 */
	public function display_uploaded_file_in_admin_orders( $order ) {
		$this->render_order_upload( '_national_id_front', $order );
		$this->render_order_upload( '_national_id_back', $order );
	}
}
