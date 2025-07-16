<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( "F12ValidationObject" ) ) {
	class F12ValidationObject {
		/**
		 * Saves all validation error compares
		 * @var array
		 */
		private $m_error = array();

		/**
		 * Arguments passed to the object
		 */
		private $m_args = array();

		/**
		 * F12ValidationObject constructor.
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
		 *          "numeric" => true|false // if numerice
		 *      )
		 */
		public function __construct( $args ) {
			$this->m_args = $args;
		}

		/**
		 * Return an array with all compare checks
		 * @return array
		 */
		protected function get_compare() {
			if ( isset( $this->m_args["compare"] ) ) {
				return $this->m_args["compare"];
			}

			return array();
		}

		protected function get_value() {
			if ( isset( $this->m_args["value"] ) ) {
				return $this->m_args["value"];
			}

			return "";
		}

		public function fire() {
			$compare_list = $this->get_compare();

			foreach ( $compare_list as $compare => $definition ) {
				switch ( $compare ) {
					case "empty":
						$this->validate_empty( $this->get_value(), $definition );
						break;
					case "isset":
						$this->validate_isset( $this->get_value(), $definition );
					case "minlength":
						$this->validate_minlength( $this->get_value(), $definition );
						break;
					case "maxlength":
						$this->validate_maxlength( $this->get_value(), $definition );
						break;
					case "not":
						$this->validate_not( $this->get_value(), $definition );
						break;
					case "equals":
						$this->validate_equals( $this->get_value(), $definition );
						break;
					case "numeric":
						$this->validate_numeric( $this->get_value(), $definition );
						break;
				}
			}

			if ( empty( $this->m_error ) ) {
				return true;
			}

			return false;
		}

		protected function validate_empty( $value, $definition ) {
			if ( ! empty( $value ) && $definition == false ) {
				return true;
			} else if ( ! empty( $value ) && $definition == true ) {
				$this->m_error[] = "notempty";

				return false;
			} else if ( empty( $value ) && $definition == false ) {
				$this->m_error[] = "notempty";

				return false;
			} else {
				return true;
			}
		}

		protected function validate_isset( $value, $definition ) {
			if ( is_array( $value ) && isset( $value[ $definition ] ) ) {
				return true;
			}
			$this->m_error[] = "isset";

			return false;
		}

		protected function validate_minlength( $value, $definition ) {
			if ( strlen( $value ) >= $definition ) {
				return true;
			}
			$this->m_error[] = "minlength";

			return false;
		}

		protected function validate_maxlength( $value, $definition ) {
			if ( strlen( $value ) <= $definition ) {
				return true;
			}
			$this->m_error[] = "maxlength";

			return false;
		}

		protected function validate_not( $value, $definition ) {
			if ( strlen( $value ) != $definition ) {
				return true;
			}
			$this->m_error[] = "not";

			return false;
		}

		protected function validate_equals( $value, $definition ) {
			if ( strlen( $value ) == $definition ) {
				return true;
			}
			$this->m_error[] = "equals";

			return false;
		}

		protected function validate_numeric( $value, $definition ) {
			if ( is_numeric( $value ) == $definition) {
				return true;
			}
			$this->m_error[] = "numeric";

			return false;
		}

		protected function get_compare_values( $compare ) {
			$compare = explode( ",", $compare );

			return $compare;
		}
	}
}