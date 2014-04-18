<?php

/* Load and verify config     */
/* called from inc/loader.php */

if (! class_exists('Spyc')) {
	require_once('lib/spyc/Spyc.php');
}

class GreybeardConfig {

	// Default config dir
	private static $default_config_dir = 'config';

	// Default config file
	private static $default_config_file = 'default.yaml';

	// Config file needs to contain these keys at a minimum
	private static $required_config_keys = array(
		'FILE__CFG__GLOBAL',
		'FILE__CFG__WANTED',
		'FILE__CFG__OFFERS'
	);

	// Stored config values
	private $config_values = array();

	private static function getDefaultConfigFile() {
		return static::$default_config_dir . '/' . static::$default_config_file;
	}

	private function getConfigFile() {
		return static::getDefaultConfigFile();
	}

	private function loadConfig() {
		$config_file = $this->getConfigFile();
		if ($config_file && file_exists($config_file)) {
			// Load config file
			echo "Using config file: " . $config_file . "\n";
			$default_config = Spyc::YAMLLoad($config_file);	
			if ($default_config) {
				$this->config_values = $default_config;
			}

		} else {
			if ($config_file) {
				echo "Couldn't find config file: " . $config_file;
			} else {
				echo "Config file not defined.";
			}
			exit;
		}

	}

	private function validateLoadedConfig() {

		$config_ok = true;

		foreach (static::$required_config_keys as $required_key) {
			if (! array_key_exists($required_key, $this->config_values)) {
				echo "Missing required config key: " . $required_key . "\n";
				$config_ok = false;
			}
		}

		if (! $config_ok) {
			exit; // Time to go
		}
		
	}

	public static function init() {
		$greybeard_config = new GreybeardConfig();
		$greybeard_config->loadConfig();
		$greybeard_config->validateLoadedConfig();
		return $greybeard_config;
	}

	public function get($config_key) {
		return $this->config_values[$config_key];
	}

}

