<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class F12ReferenceMetaBoxGroup
 */
class F12ReferenceMetaBoxGroup {
	/**
	 * F12SliderMetaBoxGroup constructor.
	 */
	function __construct() {
		add_action( "add_meta_boxes", array( &$this, "add_meta_boxes" ) );
		add_action( "admin_enqueue_scripts", array( &$this, "enqueue_scripts" ) );
		add_action( "wp_ajax_f12r_reference_sort", array( &$this, "sort_values" ) );
		add_action( 'save_post', array( &$this, "save_meta_box_reference_group" ) );
	}

	/**
	 * Updating sort order
	 */
	public function sort_values() {

		$ids = explode( ",", $_POST["order"] );

		$i = 0;
		foreach ( $ids as $id ) {
			update_post_meta( $id, "f12-sort", $i );
			$i ++;
		}

		wp_die();
	}

	/**
	 * Save the content of the metabox slider
	 */
	public function save_meta_box_reference_group() {
		global $post;

		if ( isset( $post ) ) {
			$post_id = $post->ID;

			$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST['f12r_reference_group_nonce'] ) && wp_verify_nonce( $_POST['f12r_reference_group_nonce'], basename( __FILE__ ) ) ) ? true : false;

			// Exit script depending on status
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			$f12r_reference_group_option_title = isset( $_POST["f12r-reference-group-option-title"] ) ? $_POST["f12r-reference-group-option-title"] : 0;
			$f12r_reference_group_description  = isset( $_POST["f12r-reference-group-description"] ) ? $_POST["f12r-reference-group-description"] : "";

			update_post_meta( $post_id, "f12r-reference-group-option-title", $f12r_reference_group_option_title );
			update_post_meta( $post_id, "f12r-reference-group-description", $f12r_reference_group_description );
		}
	}

	/**
	 * Adding scripts
	 */
	public function enqueue_scripts() {
		global $typenow;

		if ( $typenow == "f12r_reference_group" ) {
			if ( ! wp_script_is( "reorder-js" ) ) {
				wp_enqueue_script( 'reorder-js', plugins_url( '../assets/js/f12-reorder.js', __FILE__ ), array(
					'jquery',
					'jquery-ui-sortable'
				) );
			}

			if ( ! wp_style_is( "f12r_reference_admin" ) ) {
				wp_enqueue_style( 'f12r_reference_admin', plugins_url( '../assets/css/reference-admin.css', __FILE__ ) );
			}
		}
	}

	/**
	 * Add metabox for Group
	 */
	public function add_meta_boxes() {
		add_meta_box(
			"f12r_reference_meta_box_group",
			"Referenzen Gruppe",
			array( &$this, "add_meta_boxes_html" ),
			"f12r_reference_group"
		);
	}

	/**
	 * HTML of the meta box
	 */
	public function add_meta_boxes_html() {
		global $post;

		$stored_meta_data = get_post_meta( $post->ID );

		$args = array(
			"wp_nonce_field"                    => wp_nonce_field( basename( __FILE__ ), "f12r_reference_group_nonce" ),
			"f12r-reference-group"              => F12Reference::get_reference_by_group_id( $post->ID ),
			"f12r-reference-group-id"           => $post->ID,
			"f12r-reference-group-option-title" => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-group-option-title", 0 ),
			"f12r-reference-group-description"  => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-group-description", "" ),
		);

		F12ReferenceUtils::loadAdminTemplate( "meta-box-reference-group.php", $args );
	}
}