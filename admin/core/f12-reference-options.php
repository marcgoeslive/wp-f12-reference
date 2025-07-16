<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Options
 */
class F12ReferenceOptions {
	/**
	 * F12ReferenceOptions constructor.
	 */
	public function __construct() {
		// Add actions
		add_action( "admin_init", array( &$this, "register_settings" ) );
		add_action( "admin_post_f12r_reference_settings_save", array( &$this, "save" ) );
	}

	public function save() {
		wp_redirect( add_query_arg( array(
			"page"      => "f12r_reference_settings",
			"post_type" => "f12r_reference_group"
		), "edit.php" ) );

		$reference_quote_default_image = isset( $_POST["reference-quote-default-image"] ) ? $_POST["reference-quote-default-image"] : "";

		// Update Data
		update_option( "f12r_reference_settings", array(
			"reference-quote-default-image" => $reference_quote_default_image
		) );
	}

	public function register_settings() {
		// Default settings
		add_option("f12r_reference_settings", array(
			"reference-quote-default-image" => "",
		) );
	}

	/**
	 * @param $name
	 * @param string $value
	 *
	 * @return string
	 */
	public function image_uploader_field( $name, $value = "" ) {
		if ( ! is_array( $value ) ) {
			$value = array( $value );
		}

		if ( is_array( $value ) ) {
			$output = '
			<div>
				<a href="#" data-key-output=".f12l-image-galerie" data-key-id="' . $name . '" class="f12r_upload_image_button button">Upload image</a>
				<div class="f12l-image-galerie">
			';

			foreach ( $value as $key => $id ) {
				if ( ! empty( $id ) ) {
					$image = wp_get_attachment_image_src( $id );

					$output .= '
					<div data-key="' . $id . '">
						<img class="true_pre_image" src="' . $image[0] . '" style="max-width:30%;display:block;">
						<a href="#" class="f12r_remove_image_button">Bild entfernen</a>
						<input type="hidden" name="' . $name . '" value="' . $id . '">
				</div>';
				}
			}

			$output .= '</div></div>';
		}

		return $output;
	}

	/**
	 * Output the Settings page
	 */
	public function render() {
		$args = array(
			//"reference_quote_default_image"                        => get_option("f12r_reference_settings" )["reference_quote_default_image"],
			"reference-quote-default-image" => $this->image_uploader_field( "reference-quote-default-image", get_option( "f12r_reference_settings" )["reference-quote-default-image"] )
		);

		echo F12ReferenceUtils::loadAdminTemplate( "admin.php", $args );
	}
}