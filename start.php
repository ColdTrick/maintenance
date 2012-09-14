<?php

function maintenance_init() {
	//	return;
	if (!elgg_is_admin_logged_in() && elgg_get_plugin_setting("maintenance_active", "maintenance") == "yes") {
		elgg_register_plugin_hook_handler('index', 'system', 'maintenance_index', 1);

		// deferring forwarding so other plugins can register handlers to alter behavior
		elgg_register_event_handler('ready', 'system', 'maintenance_ready', 1);
	}
}

function maintenance_ready($event, $object_type, $object) {
	$current_url = current_page_url();

	// generate path from site URL
	$site_path = preg_replace('~^https?~', '', elgg_get_site_url());
	$current_path = preg_replace('~^https?~', '', $current_url);
	if (0 === strpos($current_path, $site_path)) {
		$current_path = ($current_path === $site_path) ? '' : substr($current_path, strlen($site_path));
	} else {
		$current_path = false;
	}

	$path_whitelist = array(
		'',
		'action/login',
		'shib_auth/login',
		'mod/shib_auth/validate/'
	);
	$allow = in_array($current_path, $path_whitelist, true);

	// allow plugins to control access for specific URLs/paths
	$params = array(
		'current_path' => $current_path,
		'current_url' => $current_url,
	);
	$allow = elgg_trigger_plugin_hook('maintenance:allow', 'url', $params, $allow);

	if (!$allow) {
		admin_gatekeeper();
	}
}

function maintenance_index() {
	$file = dirname(__FILE__) . '/index.php';

	if ($file_from_config = elgg_get_config('maintenance:index_script')) {
		$file = $file_from_config;
	}

	if (!@include_once($file)) {
		return false;
	}
	return true;
}

// Initialise plugin
elgg_register_event_handler('init', 'system', 'maintenance_init');
