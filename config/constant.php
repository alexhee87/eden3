<?php
	return array(
        'default_title' => 'Eden+',
    	'system_default' => [
            'application_name' => 'Eden+',
            'timezone_id' => '266',
            'default_language' => 'en',
            'direction' => 'ltr',
            'error_display' => 1,
            'textarea_limit' => '300',
            'notification_position' => 'toast-bottom-right',
            'multilingual' => 1,
            'throttle_attempt' => 5,
            'throttle_lockout_period' => 2,
            'login' => '1',
            'lock_screen_timeout' => 1,
            'cache_lifetime' => '100',
            'credit' => 'Brought to you by GIT Elken',
            'celebration_days' => 30,
            'under_maintenance_message' => 'The system is under maitnenance.',
            'chat_refresh_duration' => 60,
            'hidden_value' => 'xxxxxxxxxxxxxxxx',
        ],
        'default_role' => 'admin',
        'item_code' => 'LARAFY0101',
        'upload_path' => [
            'backup' => 'uploads/backup/',
            'logo' => 'uploads/logo/',
            'avatar' => 'uploads/avatar/',
            'attachments' => 'uploads/attachments/',
        ],
        'ignore_var' => array('_token','config_type','ajax_submit'),
        'path' => [
            'country' => '/config/country.php',
            'timezone' => '/config/timezone.php',
            'language' => '/config/language.php',
            'lang' => '/config/lang.php',
            'verifier' => 'http://envato.wmlab.in/',
            'config' => '/config/config.php',
            'mail' => '/config/mail.php',
            'service' => '/config/services.php',
        ],
        'mail_default' => [
            'driver' => 'log',
            'from_name' => 'WM Lab',
            'from_address' => 'support@wmlab.in'
        ],
        'social_login_provider' => [
            'facebook','twitter','google','github'
        ]
	);
?>