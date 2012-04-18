<?php
	
	function maintenance_init(){
	
		if(get_plugin_setting("maintenance_active","maintenance")=="yes" && !isadminloggedin()){
			register_plugin_hook('index','system','maintenance_index');
			if($_SERVER["REQUEST_URI"] != "/" && $_SERVER["REQUEST_URI"] != "/action/login"){
				
				admin_gatekeeper();
			}
		}
	}
	
	function maintenance_index() {
		
		if (!@include_once(dirname(__FILE__) . "/index.php")) return false;
		return true;
	}
	
	// Initialise plugin
	register_elgg_event_handler('init','system','maintenance_init');
?>