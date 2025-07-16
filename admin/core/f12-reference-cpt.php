<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class F12ReferenceCPT {
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
		register_post_type( "f12r_reference", array(
			'labels'          => array(
				'name'          => __( 'Referenzen' ),
				'singular_name' => __( 'Referenz' )
			),
			'public'          => true,
			'has_archive'     => true,
			'rewrite'         => array( 'slug' => 'f12r_reference' ),
			'capability_type' => 'page',
			'show_in_menu'    => "edit.php?post_type=f12r_reference_group",
			'supports'        => array(
				"title",
				"revisions"
			)
		) );

		// Add a taxonomy like tags
		$labels = array(
			'name'                       => 'Kategorie',
			'singular_name'              => 'Kategorie',
			'search_items'               => 'Kategorien',
			'popular_items'              => 'Beliebte Kategorien',
			'all_items'                  => 'Alle Kategorien',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Kategorie bearbeiten',
			'update_item'                => 'Kategorie aktualisieren',
			'add_new_item'               => 'Neue Kategorie hinzufügen',
			'new_item_name'              => 'Neue Kategorie Bezeichnung',
			'separate_items_with_commas' => 'Kategorien getrennt durch Komma',
			'add_or_remove_items'        => 'Hinzufügen oder Entfernen von Kategorien',
			'choose_from_most_used'      => 'Wähle aus den meist benutzten Kategorien',
			'not_found'                  => 'Keine Kategorien gefunden',
			'menu_name'                  => 'Kategorien',
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'reference-category' ),
		);

		register_taxonomy( 'f12r_tax_category', 'f12r_reference', $args );
	}
}