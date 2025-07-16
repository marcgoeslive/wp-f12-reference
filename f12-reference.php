<?php
/**
 * Plugin Name: Forge12 Referenzen
 * Plugin URI: https://www.forge12.com
 * Description: Create a simple Reference list
 * Version: v1.01
 * Author: Forge12 Interactive GmbH
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( plugin_dir_path( __FILE__ ) . "core/f12-reference-utils.php" );
require_once( plugin_dir_path( __FILE__ ) . "core/f12-reference-shortcode.php" );
require_once( plugin_dir_path( __FILE__ ) . "admin/f12-reference-admin.php" );
