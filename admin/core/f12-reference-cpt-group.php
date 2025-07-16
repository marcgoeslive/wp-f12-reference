<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class F12ReferenceCPTGroup {
	/**
	 * Constructor
	 */
	public function __construct() {

		// Add actions
		add_action( "init", array( &$this, "add_custom_post_types" ) );
	}

	/**
	 * Add custom post types to wordpress
	 */
	public function add_custom_post_types() {
		register_post_type( "f12r_reference_group", array(
			'labels'             => array(
				'name'          => __( 'Referenzen Gruppen' ),
				'singular_name' => __( 'Referenz Gruppe' ),
				'menu_name'     => __( 'Referenzen' ),
				'edit_item'     => __( 'Referenzen bearbeiten' ),
			),
			'menu_icon'          => 'dashicons-format-quote',
			'public'             => true,
			'publicly_queryable' => false,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'f12r_reference_group' ),
			'capability_type'    => 'page',
			'supports'           => array(
				"title",
				"revisions"
			)
		) );
	}
}