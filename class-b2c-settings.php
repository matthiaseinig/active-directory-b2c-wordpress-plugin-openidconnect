<?php

class B2C_Settings {
	
	// These settings are configurable by the admin
	public static $login_tenant = "";
	public static $tenant = "";
	public static $clientID = "";
	public static $generic_policy = "";
	public static $admin_policy = "";
	public static $edit_profile_policy = "";
	public static $password_reset_policy = "";
	public static $redirect_uri = "";
	public static $verify_tokens = 1;
	public static $wp_role = "";
	public static $show_admin_bar = "";
	
	// These settings define the authentication flow, but are not configurable on the settings page
	// because this plugin is made to support OpenID Connect implicit flow with form post responses
	public static $response_type = "id_token"; 
	public static $response_mode = "form_post"; 
	public static $scope = "openid%20profile"; // openid
	
	function __construct() {
			
		// Get the inputs from the B2C Settings Page
		$config_elements = get_option('b2c_config_elements');
			
		if (isset($config_elements)) {
		
			// Parse the settings entered in by the admin on the b2c settings page
			self::$login_tenant = $config_elements['b2c_login_tenant'];
			self::$tenant = $config_elements['b2c_aad_tenant'];
			self::$scope = urlencode($config_elements['b2c_scope']);
			self::$clientID = $config_elements['b2c_client_id'];
			self::$generic_policy = $config_elements['b2c_subscriber_policy_id'];
			self::$admin_policy = $config_elements['b2c_admin_policy_id'];
			self::$edit_profile_policy = $config_elements['b2c_edit_profile_policy_id'];
			self::$password_reset_policy = $config_elements['b2c_password_reset_policy_id'];
			self::$redirect_uri = home_url().'/'; 

			if (isset($config_elements['b2c_verify_tokens']) && $config_elements['b2c_verify_tokens']) self::$verify_tokens = 1;
			else self::$verify_tokens = 0;
			
			self::$wp_role = $config_elements['b2c_default_role'];

			if (isset($config_elements['b2c_show_admin_bar']) && $config_elements['b2c_show_admin_bar']) self::$show_admin_bar = 1;
			else self::$show_admin_bar = 0;
		}
	}
	static function metadata_endpoint_begin() {
		return 'https://'.self::$login_tenant.'.b2clogin.com/'.self::$tenant.'/v2.0/.well-known/openid-configuration?p=';
	}
}


