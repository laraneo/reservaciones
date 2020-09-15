<?php

return [

    /**
     *
     * Shared translations.
     *
     */
    'title' => 'Bookify Setup Utility',
    'next' => 'Next Step',
    'back' => 'Previous',
    'finish' => 'Finish Setup',
    'forms' => [
        'errorTitle' => 'The Following errors occurred:',
    ],

    /**
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Let\'s Setup Bookify',
        'title'   => 'Let\'s Setup Bookify',
        'message' => 'It\'s very easy and straight forward. In case of any issue please refer to documentation
        for complete setup guidelines. You can also contact our support if you are having any issue. Let\'s start
        by checking if your hosting or server setup is ready to run Bookify.',
        'next'    => 'Click Here To Start',
    ],

    /**
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Basic Requirements',
        'title' => 'Basic Requirements',
        'next'    => 'Check Permissions',
        'refresh' => 'Check Again',
    ],

    /**
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Folder Permissions',
        'title' => 'Folder Permissions',
        'next' => 'Verify Purchase',
    ],

    /**
     *
     * Verify Purchase page translations.
     *
     */
    'verifyPurchase' => [
        'templateTitle' => 'Verify Purchase',
        'title' => 'Verify Purchase',
        'next' => 'Click To Verify',
        'invalid_code' => 'Your purchase code appears to be invalid. Please try again with a valid
        purchase code.'
    ],

    /**
     *
     * Settings page translations.
     *
     */
    'settings' => [
        'templateTitle' => 'App Settings',
        'title' => 'App Settings',
        'next' => 'Finalize Settings'
    ],

    /**
     *
     * Environment page translations.
     *
     */
    'environment' => [

        'wizard' => [
            'templateTitle' => 'Configure App',
            'title' => 'Configure Your App',
            'tabs' => [
                'app' => 'App Configuration',
                'database' => 'Database Configuration',
                'mail' => 'Mailer Configuration'
            ],
            'db_connection_failed' => 'Database connection failed. Please check database credentials and try again.',
            'form' => [
                'name_required' => 'An environment name is required.',
                'app_name_label' => 'App Name',
                'app_name_placeholder' => 'Bookify',
                'app_environment_label' => 'App Environment',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Development',
                'app_environment_label_qa' => 'Qa',
                'app_environment_label_production' => 'Production',
                'app_environment_label_other' => 'Other',
                'app_environment_placeholder_other' => 'Enter your environment...',
                'app_debug_label' => 'App Debug',
                'app_debug_label_true' => 'True',
                'app_debug_label_false' => 'False',
                'app_log_level_label' => 'App Log Level',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Complete URL of App',
                'select_timezone' => 'Select Your Timezone',
                'app_url_placeholder' => 'App Url',
                'db_connection_label' => 'Database Connection',
                'db_connection_label_mysql' => 'MySQL',
                'db_connection_label_sqlite' => 'Sqlite',
                'db_connection_label_pgsql' => 'Pgsql',
                'db_connection_label_sqlsrv' => 'Sqlsrv',
                'db_host_label' => 'Database Host',
                'db_host_placeholder' => 'Database Host',
                'db_port_label' => 'Database Port',
                'db_port_placeholder' => 'Database Port',
                'db_name_label' => 'Database Name',
                'db_name_placeholder' => 'Database Name',
                'db_username_label' => 'Database Username',
                'db_username_placeholder' => 'Database Username',
                'db_password_label' => 'Database Password',
                'db_password_placeholder' => 'Database Password',

                'app_tabs' => [
                    'more_info' => 'More Info',
                    'broadcasting_title' => 'Broadcasting, Caching, Session, &amp; Queue',
                    'broadcasting_label' => 'Broadcast Driver',
                    'broadcasting_placeholder' => 'Broadcast Driver',
                    'cache_label' => 'Cache Driver',
                    'cache_placeholder' => 'Cache Driver',
                    'session_label' => 'Session Driver',
                    'session_placeholder' => 'Session Driver',
                    'queue_label' => 'Queue Driver',
                    'queue_placeholder' => 'Queue Driver',
                    'redis_label' => 'Redis Driver',
                    'redis_host' => 'Redis Host',
                    'redis_password' => 'Redis Password',
                    'redis_port' => 'Redis Port',

                    'mail_label' => 'Mail',
                    'mail_driver_label' => 'Mail Driver',
                    'mail_driver_placeholder' => 'Mail Driver',
                    'mail_host_label' => 'Mail Host',
                    'mail_host_placeholder' => 'smtp.your-domain.com',
                    'mail_port_label' => 'Mail Port',
                    'mail_port_placeholder' => 'Mail Port',
                    'mail_username_label' => 'Mail Username',
                    'mail_username_placeholder' => 'someone@your-domain.com',
                    'mail_password_label' => 'Mail Password',
                    'mail_password_placeholder' => '****',
                    'mail_encryption_label' => 'Mail Encryption',
                    'mail_encryption_placeholder' => 'ssl or tls',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App Id',
                    'pusher_app_id_palceholder' => 'Pusher App Id',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => 'Pusher App Key',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => 'Pusher App Secret',
                ],
                'buttons' => [
                    'setup_database' => 'Setup Database',
                    'setup_application' => 'Setup Application',
                    'install' => 'Install Application',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Step 3 | Environment Settings | Classic Editor',
            'title' => 'Classic Environment Editor',
            'save' => 'Save .env',
            'back' => 'Use Form Wizard',
            'install' => 'Save and Install',
        ],
        'success' => 'Your .env file settings have been saved.',
        'errors' => 'Unable to save the .env file, Please create it manually.',
    ],

    'install' => 'Install',

    /**
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Bookify is successfully installed on ',
    ],

    /**
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installation Completed',
        'templateTitle' => 'Installation Completed',
        'finished' => 'Bookify has been successfully installed.',
        'migration' => 'Migration &amp; Seed Console Output:',
        'console' => 'Application Console Output:',
        'log' => 'Installation Log Entry:',
        'env' => 'Final .env File:',
        'text' => 'Installation is completed and everything is good to go. After login, please visit settings page for more advanced
        settings for bookings and payments. Thank you for choosing Bookify. Click on login button below to login now.',
        'login_btn' => 'Click here to Login',
        'home_btn' => 'Take Me To Homepage',
    ],

    /**
     *
     * Update specific translations
     *
     */
    'updater' => [
        /**
         *
         * Shared translations.
         *
         */
        'title' => 'Laravel Updater',

        /**
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Welcome To The Updater',
            'message' => 'Welcome to the update wizard.',
        ],

        /**
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Overview',
            'message' => 'There is 1 update.|There are :number updates.',
            'install_updates' => "Install Updates"
        ],

        /**
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finished',
            'finished' => 'Application\'s database has been successfully updated.',
            'exit' => 'Click here to exit',
        ],

        'log' => [
            'success_message' => 'Laravel Installer successfully UPDATED on ',
        ],
    ],
];
