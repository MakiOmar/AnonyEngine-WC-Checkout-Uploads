<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/MakiOmar
 * @since      1.0.0
 *
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Anony_Wc_Checkout_Uploads
 * @subpackage Anony_Wc_Checkout_Uploads/public
 * @author     Mohammad Omar <maki3omar@gmail.com>
 */
class Anony_Wc_Checkout_Uploads_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/anony-wc-checkout-uploads-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/anony-wc-checkout-uploads-public.js', array( 'jquery' ), $this->version, false );
		$this->uploads_enqueue_scripts();
	}
	/**
	 * Add custom fields
	 *
	 * @return void
	 */
	public function add_custom_checkout_field() {
		echo '<div class="woocommerce-additional-fields__field-wrapper">';

		woocommerce_form_field(
			'national_id_front',
			array(
				'type'       => 'file',
				'class'      => array( 'form-row-wide' ),
				'label'      => esc_html__( 'National ID (Front)', 'woocommerce' ),
				'required'   => false,
				'max_size'   => '1024', // in ko (here 3 Mo size limit).
				'data-label' => esc_html__( 'National ID (Front)', 'woocommerce' ),
				'accept'     => '.jpg,jpeg,png', // text documents and pdf.
			),
			''
		);
		woocommerce_form_field(
			'national_id_back',
			array(
				'type'       => 'file',
				'class'      => array( 'form-row-wide' ),
				'label'      => esc_html__( 'National ID (Back)', 'woocommerce' ),
				'required'   => false,
				'max_size'   => '1024', // in ko (here 3 Mo size limit).
				'data-label' => esc_html__( 'National ID (Back)', 'woocommerce' ),
				'accept'     => '.jpg,jpeg,png', // text documents and pdf.
			),
			''
		);

		echo '</div>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function uploads_enqueue_scripts() {
		if ( is_checkout() && ! is_wc_endpoint_url() ) {
			wp_enqueue_script(
				'checkout-uploads',
				plugin_dir_url( __FILE__ ) . 'js/checkout_upload.js',
				array( 'jquery' ),
				time(),
				true
			);

			wp_localize_script(
				'checkout-uploads',
				'checkout_uploads_params',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php?action=checkout_upload&security=' . wp_create_nonce( 'checkout_upload' ) ),
				)
			);
		}
	}
	/**
	 * Validate checkout uploads
	 *
	 * @return void
	 */
	public function checkout_required_upload_validation() {
		$checkout_upload = WC()->session->get( 'checkout_upload' );

		if ( empty( $checkout_upload ) ) {
			wc_add_notice( esc_html__( 'Uploading your file is required in order to checkout.', 'woocommerce' ), 'error' ); // Displays an error notice.
		}
	}
	/**
	 * Form field filter
	 *
	 * @param string $field Field output.
	 * @param string $key Key.
	 * @param mixed  $args Arguments.
	 * @return void|string
	 */
	public function woocommerce_form_input_field_type_file( $field, $key, $args ) {
		if ( 'file' === $args['type'] ) {
			if ( $args['required'] ) {
				$args['class'][] = 'validate-required';
				$required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
			} else {
				$required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
			}
			$field           = '';
			$label_id        = $args['id'];
			$sort            = $args['priority'] ? $args['priority'] : '';
			$field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p>';
			$max_size        = isset( $args['max_size'] ) ? 'data-max_size="' . intval( $args['max_size'] ) . '" ' : '';
			$accept          = isset( $args['accept'] ) ? 'accept="' . esc_attr( $args['accept'] ) . '" ' : '';

			$field .= sprintf(
				'<input type="%s" class="input-file anony-checkout-upload %s" name="%s" id="%s" %s data-label="%s"/>',
				esc_attr( $args['type'] ),
				esc_attr( implode( ' ', $args['input_class'] ) ),
				esc_attr( $key ),
				esc_attr( $args['id'] ),
				$max_size . $accept,
				wp_kses_post( $args['label'] )
			);

			if ( ! empty( $field ) ) {
				$field_html  = '<label for="' . esc_attr( $label_id ) . '" class="anony-checkout-upload-label ' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">';
				$field_html .= '<span class="anony-upload-icon">';
				$field_html .= '<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.25806 13.7742V20.5478C2.26488 21.9921 2.86354 23.3747 3.92225 24.3911C4.98098 25.4077 6.41302 25.9747 7.90322 25.9677H19.1935C20.6837 25.9747 22.1158 25.4077 23.1745 24.3911C24.2332 23.3747 24.8319 21.9921 24.8387 20.5478V13.7742C24.8319 12.3298 24.2332 10.9473 23.1745 9.93083C22.1158 8.91436 20.6837 8.34725 19.1935 8.35432C18.4108 8.25369 17.7421 7.75791 17.4371 7.05211C16.9369 6.18112 15.9881 5.64226 14.9597 5.64517H12.1371C11.1087 5.64226 10.1598 6.18112 9.65967 7.05211C9.3546 7.75791 8.6859 8.25369 7.90322 8.35432C6.41302 8.34725 4.98098 8.91436 3.92225 9.93083C2.86354 10.9473 2.26488 12.3298 2.25806 13.7742Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M13.5155 20.3225C11.6491 20.3044 10.149 18.7798 10.1613 16.9132C10.1736 15.0466 11.6937 13.5418 13.5602 13.5484C15.4268 13.555 16.9362 15.0704 16.9354 16.937C16.9309 17.8395 16.568 18.7031 15.9267 19.3381C15.2854 19.973 14.418 20.3271 13.5155 20.3225Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
				$field_html .= '</span>';
				$field_html .= '<span class="anony-upload-lable-text">';
				$field_html .= wp_kses_post( $args['label'] );
				$field_html .= $required;
				$field_html .= '</span>';
				$field_html .= '<span class="anony-success-icon anony-upload-response-icon">&#10004;</span>';
				$field_html .= '<span class="anony-failure-icon anony-upload-response-icon">&#x2717;</span>';
				$field_html .= '</label>';
				$field_html .= '<span class="woocommerce-input-wrapper">' . $field;

				if ( $args['description'] ) {
					$field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
				}
				$container_class = esc_attr( implode( ' ', $args['class'] ) );
				$container_id    = esc_attr( $args['id'] ) . '_field';
				$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
			}
		}
		if ( $args['return'] ) {
			return $field;
		} else {
			//phpcs:disable
			echo $field;
			//phpcs:enable.
		}
	}

	/**
	 * Checkout uploads ajax calback.
	 *
	 * @return void
	 */
	public function checkout_ajax_file_upload() {
		check_ajax_referer( 'checkout_upload', 'security' );

		global $current_user;

		$files = $_FILES;

		if ( isset( $files['uploads'] ) && isset( $files['uploads']['name'] ) ) {
			$checkout_uploads = WC()->session->get( 'checkout_upload' );
			$requested        = wp_unslash( $_POST );
			if ( ! $current_user->ID && isset( $requested['email'] ) && ! empty( $requested['email'] ) ) {
				// Generating a sub / subfolder (path) from billing email in '000000' guest directory.
				$user_path = '000000/' . substr( sanitize_title( wp_unslash( $requested['email'] ) ), 0, 10 ); // For Guests.
			} else {
				$user_path = str_pad( $current_user->ID, 6, '0', STR_PAD_LEFT ); // For logged in users.
			}
			$upload_dir  = wp_upload_dir();
			$user_path   = '/wc_checkout_uploads/' . $user_path;
			$user_folder = $upload_dir['basedir'] . $user_path;
			$user_url    = $upload_dir['baseurl'] . $user_path;

			if ( ! is_dir( $user_folder ) ) {

				wp_mkdir_p( $user_folder );

				chmod( $user_folder, 0777 );

			}
			$file_path = $user_folder . '/' . basename( $files['uploads']['name'] );
			$file_url  = $user_url . '/' . basename( $files['uploads']['name'] );

			if ( move_uploaded_file( $files['uploads']['tmp_name'], $file_path ) ) {
				$field_data = array(
					'data_label' => $requested['data_label'],
					'file_url'   => $file_url,
					'file_name'  => $files['uploads']['name'],
				);
				if ( $checkout_uploads ) {
					$checkout_uploads[ $requested['input_id'] ] = $field_data;
				} else {
					$checkout_uploads = array( $requested['input_id'] => $field_data );
				}
				// Save the file URL and the file name to WC Session.
				WC()->session->set(
					'checkout_upload',
					$checkout_uploads
				);
				wp_send_json( array( 'status' => 'success' ) );
			} else {
				wp_send_json( array( 'status' => 'failure' ) );
			}
		}
		die();
	}

	/**
	 * Save checkout uploads
	 *
	 * @param object $order Order object.
	 * @return void
	 */
	public function save_checkout_uploaded_file( $order ) {
		$checkout_upload = WC()->session->get( 'checkout_upload' );
		if ( $checkout_upload ) {
			foreach ( $checkout_upload as $key => $value ) {
				$order->update_meta_data( '_' . $key, $value ); // Save.
			}
		}
		WC()->session->__unset( 'checkout_upload' ); // Remove session variable.
	}
}
