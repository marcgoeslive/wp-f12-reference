<?php
if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class F12ReferenceGroup {
	/**
	 * Return all Options for the select group
	 *
	 * @param int $selected
	 *
	 * @return string
	 */
	public static function get_option_list( $selected = - 1 ) {
		$options = "<option value=\"-1\">Bitte wählen</option>";

		$args = array(
			'post_type'      => "f12r_reference_group",
			'nopaging'       => true,
			'posts_per_page' => - 1
		);

		$query = new WP_Query( $args );
		$posts = $query->get_posts();

		foreach ( $posts as $item ) {
			/* @var $item WP_Post */
			if ( $selected == $item->ID) {
				$options .= "<option value=\"" . $item->ID . "\" selected=\"selected\">" . $item->post_title . "</option>";
			} else {
				$options .= "<option value=\"" . $item->ID . "\">" . $item->post_title . "</option>";
			}
		}


		return $options;
	}
}