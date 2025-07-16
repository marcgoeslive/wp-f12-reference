<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( "f12-validation-object.php" );
require_once( "f12-validation-string.php" );

/**
 * Check if the class exists
 */
if ( ! class_exists( "F12Validation" ) ) {
	class F12Validation {
		/**
		 * Validate a field
		 *
		 * @param $args
		 * array(
		 *      value => {value},
		 *      type => string | array | int | bool,
		 *      compare => array(
		 *          "minlength" => {int},
		 *          "maxlength" => {int},
		 *          "empty" => false,
		 *          "isset" => {string} // Array test
		 *          "not" => {string|int} // Compare if not
		 *          "equals" => {string|int|bool} // Compare
		 *          "numeric" => {mixed} // if numerice
		 *      )
		 *
		 * @return bool
		 */
		public static function validate( $args ) {
			if ( ! isset( $args["value"] ) || ! isset( $args["type"] ) || ! isset( $args["compare"] ) ) {
				return false;
			}

			switch ( $args["type"] ) {
				case 'string':
					$Validation = new F12ValidationString($args);
					return $Validation->fire();
				case 'bool':
					$Validation = new F12ValidationString($args);
					return $Validation->fire();
					break;
				case 'array':
					$Validation = new F12ValidationString($args);
					return $Validation->fire();
					break;
				case 'int':
					$Validation = new F12ValidationString($args);
					return $Validation->fire();
					break;
				default:
					return false;
			}
		}
	}
}

