<?php
if ( ! defined( "ABSPATH" ) ) {
	exit;
}

/**
 * Class F12ReferenceShortcode
 */
class F12ReferenceShortcode {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( "wp_enqueue_scripts", array( &$this, "enqueue_scripts" ) );
		add_shortcode( "f12r_reference", array( &$this, "add_shortcode" ) );
	}

	/**
	 * Scripts & Styles for the short code items
	 */
	public function enqueue_scripts() {
		if ( ! wp_style_is( "f12r_reference" ) ) {
			wp_enqueue_style( "f12r_reference", plugin_dir_url( __FILE__ ) . '../assets/css/reference.css' );
		}
	}

	/**
	 * Get Categories html by id
	 */
	private function get_categories_as_html( $post_id ) {
		$categories = get_the_terms( $post_id, "f12r_tax_category" );

		$content = "";
		foreach ( $categories as $term ) {
			/* @var $term WP_Term */
			$args    = array(
				"name" => $term->name,
				"id"   => $term->term_id
			);
			$content .= F12ReferenceUtils::loadTemplate( "shortcode-reference-item-term.php", $args );
		}

		return $content;
	}

	/**
	 * Get Items
	 */
	public function get_items_by_group_id( $id ) {
		$args = array(
			"post_type"      => "f12r_reference",
			"posts_per_page" => - 1,
			"meta_query"     => array(
				array(
					"key"   => "f12r-reference-group",
					"value" => $id
				)
			),
			"orderby"        => "meta_value_num",
			"meta_key"       => "f12-sort",
			"order"          => "ASC"
		);

		$query = new WP_Query( $args );
		$items = $query->get_posts();

		$content = "";
		foreach ( $items as $item ) {
			/* @var $item WP_Post */
			$storedmetadata = get_post_meta( $item->ID );

			$display_quote = F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-display-quote" );
			$author        = F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-quote-author" );

			if ( $display_quote == 1 ) {
				$image = get_option( "f12r_reference_settings" )["reference-quote-default-image"];
			} else {
				$image = F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-image" );
			}
			$image_data = wp_get_attachment_image_src( $image, "" )[0];

			$data = array(
				"text"   => wpautop( F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-text" ) ),
				"image"  => $image_data,
				"title"  => get_the_title( $item->ID ),
				"author" => $author,
				"link"   => get_permalink( F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-link" ) ),
				"terms"  => $this->get_categories_as_html( $item->ID )
			);

			if ( $display_quote == 1 ) {
				if ( F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-link", - 1 ) == - 1 ) {
					$content .= F12ReferenceUtils::loadTemplate( "shortcode-reference-item-quote.php", $data );
				} else {
					$content .= F12ReferenceUtils::loadTemplate( "shortcode-reference-item-quote-link.php", $data );
				}
			} else {
				if ( F12ReferenceUtils::get_field( $storedmetadata, "f12r-reference-link", - 1 ) == - 1 ) {
					$content .= F12ReferenceUtils::loadTemplate( "shortcode-reference-item.php", $data );
				} else {
					$content .= F12ReferenceUtils::loadTemplate( "shortcode-reference-item-link.php", $data );
				}
			}
		}

		return $content;
	}

	/**
	 * Shortcode galerie output
	 */
	public function add_shortcode( $atts ) {
		if ( ! isset( $atts["group-id"] ) ) {
			return;
		}

		$group = get_post( $atts["group-id"] );

		if ( ! $group ) {
			return;
		}

		$stored_meta_data = get_post_meta( $group->ID );

		$args = array(
			"title"                             => $group->post_title,
			"f12r-reference-group-option-title" => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-group-option-title", 0 ),
			"items"                             => $this->get_items_by_group_id( $atts["group-id"] ),
			"description"                       => F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-group-description", "" )
		);

		echo F12ReferenceUtils::loadTemplate( "shortcode-reference.php", $args );
	}
}

new F12ReferenceShortcode();