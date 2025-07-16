<?php
if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class F12Reference {
	/**
	 * Get all References by group id and return an multi array with all Reference items
	 * array(
	 *      array(
	 *          [0] => {id}
	 *          [1] => {title}
	 *          [2] => {text}
	 *          [3] => {image}
	 *          [4] => {author]
	 *      )
	 * );
	 *
	 * @param $group_id
	 *
	 * @return array
	 */
	public static function get_reference_by_group_id( $group_id ) {
		$data = array();

		$args = array(
			"post_type"      => "f12r_reference",
			"nopaging"       => "true",
			"posts_per_page" => - 1,
			"meta_query"     => array(
				array(
					"key"   => "f12r-reference-group",
					"value" => $group_id
				)
			),
			"orderby" => "meta_value_num",
			"meta_key" => "f12-sort",
			"order" => "ASC"
		);

		$query = new WP_Query( $args );
		$posts = $query->get_posts();
		foreach ( $posts as $item ) {
			/* @var $item WP_Post */

			$stored_meta_data = get_post_meta( $item->ID );

			$display_quote = F12ReferenceUtils::get_field($stored_meta_data, "f12r-reference-display-quote");

			if($display_quote == 1) {
				$image = get_option("f12r_reference_settings")["reference-quote-default-image"];
			}else{
				$image = F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-image" );
			}


			$data[] = array(
				$item->ID,
				$item->post_title,
				F12ReferenceUtils::get_field( $stored_meta_data, "f12r-reference-text" ),
				$image,
				F12ReferenceUtils::get_field($stored_meta_data, "f12r-reference-quote-author")
			);
		}

		return $data;
	}
}