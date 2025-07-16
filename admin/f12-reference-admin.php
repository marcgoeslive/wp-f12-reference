<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Includes
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-options.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-group.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-cpt.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-cpt-group.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-metabox.php" );
require_once( plugin_dir_path( __FILE__ ) . "/core/f12-reference-metabox-group.php" );

/**
 * Class F12ReferenceAdmin
 */
class F12ReferenceAdmin{
	// Custom Post Types
	private $F12CPT;
	private $F12MetaBox;
	private $F12CPTGroup;
	private $F12MetaBoxGroup;

	public function __construct() {
		$this->F12CPT = new F12ReferenceCPT();
		$this->F12CPTGroup = new F12ReferenceCPTGroup();
		$this->F12MetaBox = new F12ReferenceMetaBox();
		$this->F12MetaBoxGroup = new F12ReferenceMetaBoxGroup();
		$this->F12Options = new F12ReferenceOptions();

		// Actions
		add_action( "admin_menu", array( &$this, "admin_menu" ) );
	}

	public function admin_menu() {
		add_submenu_page( "edit.php?post_type=f12r_reference_group", "Einstellungen", "Einstellungen", "manage_options", "f12r_reference_settings", array(
			&$this->F12Options,"render") );
	}
}

new F12ReferenceAdmin();