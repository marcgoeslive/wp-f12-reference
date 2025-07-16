<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class F12ReferenceMetaBox {
	/**
	 * Constructor
	 */
	public function __construct() {
		// actions
		add_action( "admin_init", 'wp_enqueue_media' );
		add_action( "admin_enqueue_scripts", array( &$this, "enqueue_scripts" ) );
		add_action( "add_meta_boxes", array( &$this, "add_meta_box_reference" ) );
		add_action( 'save_post', array( &$this, "save_meta_box_reference" ) );
		add_action( 'trashed_post', array( &$this, "trashed_post" ) );

		add_filter("wp_handle_upload_prefilter",array($this,"image_upload_filter"));
	}

	/**
	 * Validate the size of the image (803x500px). If the dimensions of the images do not fit, we
	 * return an error and cancel the upload.
	 *
	 * @param $file
	 *
	 * @return array
	 */
	public function image_upload_filter($file){
		if(!isset($_POST["post_id"])){
			return $file;
		}

		$post_id = $_POST["post_id"];
		$tmp_post = get_post($post_id);

		// test if the post type is assigned to this plugin.
		if($tmp_post->post_type != "f12r_reference"){
			return $file;
		}

		$img = getimagesize($file['tmp_name']);
		$minimum = array('width' => '803', 'height' => '500');
		$width = $img[0];
		$height = $img[1];

		if ($width < $minimum['width'] )
			return array("error" => "Bild ist zu klein. Bitte erhöhen Sie die Breite Ihres Bildes zu {$minimum['width']}px. Die Breite des Bildes beträgt $width px");
		elseif ($height <  $minimum['height'])
			return array("error" => "Bild ist zu klein. Bitte erhöhen Sie die Höhe Ihres Bildes zu {$minimum['height']}px. Die Höhe des Bildes beträgt $height px");
		else
			return $file;
	}

	/**
	 * Enqueue Scripts
	 */
	public function enqueue_scripts() {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_enqueue_script( 'f12r_reference_uploadscript', plugin_dir_url( __FILE__ ) . "../assets/js/f12-reference-image-picker.js", array( "jquery" ), null, false );
	}

	public function trashed_post() {
		$group_id = isset( $_GET["f12r-reference-group-id"] ) ? $_GET["f12r-reference-group-id"] : - 1;
		if ( $group_id !== - 1 ) {
			$redirect = get_edit_post_link( $group_id, "intern" );
			wp_redirect( $redirect );
			exit;
		}
	}

	/**
	 * Hooked into add_meta_boxes to create
	 * an additional metabox for the Slider
	 */
	public function add_meta_box_reference() {
		add_meta_box(
			"f12r_meta_box_reference_content",
			"Informationen",
			array( &$this, "add_meta_box_reference_content_html" ),
			"f12r_reference"
		);
	}


	/**
	 * Save the content of the metabox slider
	 */
	public function save_meta_box_reference() {
		global $post;

		if ( isset( $post ) ) {
			$post_id = $post->ID;

			$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST['f12r_reference_nonce'] ) && wp_verify_nonce( $_POST['f12r_reference_nonce'], basename( __FILE__ ) ) ) ? true : false;

			// Exit script depending on status
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			$f12r_reference_group         = isset( $_POST['f12r-reference-group'] ) ? $_POST['f12r-reference-group'] : - 1;
			$f12r_reference_text          = isset( $_POST["f12r-reference-text"] ) ? $_POST["f12r-reference-text"] : - 1;
			$f12r_reference_image         = isset( $_POST["f12r-reference-image"] ) ? $_POST["f12r-reference-image"] : "";
			$f12r_reference_display_quote = isset( $_POST["f12r-reference-display-quote"] ) ? $_POST["f12r-reference-display-quote"] : - 1;
			$f12r_reference_quote_author  = isset( $_POST["f12r-reference-quote-author"] ) ? $_POST["f12r-reference-quote-author"] : "";
			$f12r_reference_link          = isset( $_POST["f12r-reference-link"] ) ? $_POST["f12r-reference-link"] : - 1;
			$f12_sort                     = isset( $_POST["f12-sort"] ) ? $_POST["f12-sort"] : 0;

			update_post_meta( $post_id, "f12r-reference-group", $f12r_reference_group );
			update_post_meta( $post_id, "f12r-reference-text", $f12r_reference_text );
			update_post_meta( $post_id, "f12r-reference-image", $f12r_reference_image );
			update_post_meta( $post_id, "f12r-reference-display-quote", $f12r_reference_display_quote );
			update_post_meta( $post_id, "f12r-reference-quote-author", $f12r_reference_quote_author );
			update_post_meta( $post_id, "f12r-reference-link", $f12r_reference_link );
			update_post_meta( $post_id, "f12-sort", $f12_sort );

			wp_redirect( "post.php?post=" . $f12r_reference_group . "&action=edit" );
			exit;
		}
	}

	/**
	 * @param $name
	 * @param string $value
	 *
	 * @return string
	 */
	public function image_uploader_field( $name, $value = "" ) {
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
	 * The output for the Metabox as HTML
	 */
	public function add_meta_box_reference_content_html() {
		global $post;

		$stored_meta_data = get_post_meta( $post->ID );

		$group_id = F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-group", - 1 );

		if ( isset( $_GET['f12r-reference-group-id'] ) && $group_id == - 1 ) {
			$group_id = $_GET["f12r-reference-group-id"];
		}


		$f12r_images = $this->image_uploader_field( "f12r-reference-image", explode( ",", F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-image" ) ) );


		$args = array(
			"wp_nonce_field"               => wp_nonce_field( basename( __FILE__ ), "f12r_reference_nonce" ),
			"f12r-reference-group"         => F12ReferenceGroup::get_option_list( $group_id ),
			"f12r-reference-text"          => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-text" ),
			"f12r-reference-image"         => $f12r_images,
			"f12r-reference-quote-author"  => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-quote-author" ),
			"f12r-reference-display-quote" => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-display-quote" ),
			"f12r-reference-link"          => F12ReferenceUtils::get_option_list_pages( F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-link" ) ),
			"f12-sort"                     => F12ReferenceUtils::get_field( $stored_meta_data, "f12-sort", 0 )

		);

		F12ReferenceUtils::loadAdminTemplate( "meta-box-reference.php", $args );
	}
}