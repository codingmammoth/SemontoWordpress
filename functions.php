<?php

const SEMONTO_HEALTH_MONITOR_SETTINGS_PAGE = 'settings_page_semonto_health_monitor_settings';

function is_semonto_health_monitor_hook ($hook) {
    return $hook == SEMONTO_HEALTH_MONITOR_SETTINGS_PAGE;
}

function semonto_health_monitor_enqueue_styles($hook) {
    if (!is_semonto_health_monitor_hook($hook)) {
        return;
    }
    wp_enqueue_style('style.css', plugins_url('semonto-health-monitor.css', __FILE__));
}

function semonto_health_monitor_enqueue_script($hook) {
    if (!is_semonto_health_monitor_hook($hook)) {
        return;
    }
    wp_enqueue_script('semonto_health_monitor_script', plugin_dir_url(__FILE__) . 'semonto-health-monitor.js');
}

function semonto_health_monitor_save_settings() {
    register_setting('semonto_health_monitor_settings', 'semonto_secret_key', [
        'type' => 'string'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_enable_now_test', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_now', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_warning_threshold_now', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_5m', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_warning_threshold_5m', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_15m', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_warning_threshold_15m', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_now', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_error_threshold_now', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_5m', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_error_threshold_5m', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_15m', [
        'type' => 'number',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_load_test_threshold('semonto_error_threshold_15m', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_enable_5m_test', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_enable_15m_test', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_enable_wpdb_test', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_wpdb', [
        'type' => 'integer',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_threshold_percentage('semonto_error_threshold_wpdb', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_wpdb', [
        'type' => 'integer',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_threshold_percentage('semonto_warning_threshold_wpdb', $new_value);
        }
    ]);

    // Memory usage
    register_setting('semonto_health_monitor_settings', 'semonto_enable_memory_usage_test', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_memory_usage', [
        'type' => 'integer',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_threshold_percentage('semonto_warning_threshold_memory_usage', $new_value);
        }
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_memory_usage', [
        'type' => 'integer',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_threshold_percentage('semonto_error_threshold_memory_usage', $new_value);
        }
    ]);

    // DiskSpace
    register_setting('semonto_health_monitor_settings', "semonto_enable_disk_space_test");
    register_setting('semonto_health_monitor_settings', "semonto_config_disk_space", [
        'type' => 'object',
        'sanitize_callback' => 'semonto_sanitize_disk_space_config'
    ]);

    // DiskSpaceInode
    register_setting('semonto_health_monitor_settings', "semonto_enable_disk_space_inode_test");
    register_setting('semonto_health_monitor_settings', "semonto_config_disk_space_inode", [
        'type' => 'object',
        'sanitize_callback' => 'semonto_sanitize_disk_space_inode_config'
    ]);

    // Caching
    register_setting('semonto_health_monitor_settings', 'semonto_enable_caching', [
        'type' => 'boolean'
    ]);

    register_setting('semonto_health_monitor_settings', 'semonto_cache_lifespan', [
        'type' => 'integer',
        'sanitize_callback' => function($new_value) {
            return semonto_sanitize_cache_lifespan($new_value);
        }
    ]);
}

// generates the config to be passed tot the config.php file
function semonto_generate_config() {
    $config = [
        'db' => [
            'connect' => false,
            'db_host' => 'localhost',
            'db_user' =>'root',
            'db_pass' => '',
            'db_port' => 3306,
        ],
        'cache' => [
            'location' => sys_get_temp_dir(),
            'life_span' => (int) get_option('semonto_cache_lifespan', 45),
            'enabled' => (bool) get_option('semonto_enable_caching', true)
        ],
        'tests' => semonto_generate_tests_config()
    ];

    $secret_key = get_option('semonto_secret_key');
    if(strlen($secret_key) > 0){
        $config['secret_key'] = trim($secret_key);
    }

    return $config;
}

// generates an array with the enabled tests 
function semonto_generate_tests_config() {
    $features = semonto_check_available_features();
    $config = [];

    $default_disk_config = [];
    if ($features['df_command']) {
        $default_disk_config = semonto_get_default_disk_config();
    }
    $available_disks = array_keys($default_disk_config);

    if ($features['sys_getloadavg_function'] && get_option('semonto_enable_now_test', true)) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 
                'type' => 'current', 
                'warning_threshold' => get_option('semonto_warning_threshold_now', 5), 
                'error_threshold' =>  get_option('semonto_error_threshold_now', 15)
            ]
        ];
    }

    if ($features['sys_getloadavg_function'] && get_option('semonto_enable_5m_test', true)) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 
                'type' => 'average_5_min', 
                'warning_threshold' => get_option('semonto_warning_threshold_5m', 5), 
                'error_threshold' => get_option('semonto_error_threshold_5m', 15)
            ]
        ];
    }

    if ($features['sys_getloadavg_function'] && get_option('semonto_enable_15m_test', true)) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 
                'type' => 'average_15_min', 
                'warning_threshold' => get_option('semonto_warning_threshold_15m', 5), 
                'error_threshold' => get_option('semonto_error_threshold_15m', 5)
            ]
        ];
    }

    if (get_option('semonto_enable_wpdb_test', true)) {
        $config[] = [
            'test' => 'WPCheckConnection',
            'config' => [], 
        ];
        $config[] = [
            'test'=>'WPMaxDatabaseConnections',
            'config' => [ 
                'warning_percentage_threshold' => get_option('semonto_warning_threshold_wpdb', 75), 
                'error_percentage_threshold' =>get_option('semonto_error_threshold_wpdb', 90)
            ]
        ];
    }

    if ($features['vmstat_command'] && get_option('semonto_enable_memory_usage_test', true)) {
        $config[] = [
            'test' => 'MemoryUsage',
            'config' => [
                'warning_percentage_threshold' => (int) get_option('semonto_warning_threshold_memory_usage', 90),
                'error_percentage_threshold' => (int) get_option('semonto_error_threshold_memory_usage', 95)
            ]
        ];
    }

    if ($features['df_command'] && get_option('semonto_enable_disk_space_test', true)) {
        $test_config = [
            'test' => 'DiskSpace',
            'config' => [
                'disks' => []
            ]
        ];

        $configured_disks = get_option('semonto_config_disk_space', $default_disk_config);
        foreach ($configured_disks as $configured_disk => $disk_config) {
            if (isset($disk_config['enabled']) && (int) $disk_config['enabled'] && in_array($configured_disk, $available_disks)) {
                $test_config['config']['disks'][] = [
                    'name' => $configured_disk,
                    'warning_percentage_threshold' => $disk_config['warning_percentage_threshold'],
                    'error_percentage_threshold' => $disk_config['error_percentage_threshold']
                ];
            }
        }

        $config[] = $test_config;
    }

    if ($features['df_command'] && get_option('semonto_enable_disk_space_inode_test', true)) {
        $test_config = [
            'test' => 'DiskSpaceInode',
            'config' => [
                'disks' => []
            ]
        ];

        $configured_disks = get_option('semonto_config_disk_space_inode', $default_disk_config);
        foreach ($configured_disks as $configured_disk => $disk_config) {
            if (isset($disk_config['enabled']) && (int) $disk_config['enabled'] && in_array($configured_disk, $available_disks)) {
                $test_config['config']['disks'][] = [
                    'name' => $configured_disk,
                    'warning_percentage_threshold' => (int) $disk_config['warning_percentage_threshold'],
                    'error_percentage_threshold' => (int) $disk_config['error_percentage_threshold']
                ];
            }
        }

        $config[] = $test_config;
    }

    return $config;
}

function semonto_health_monitor_rewrite_rules() {
    add_rewrite_rule("^health$", "index.php?semonto_health_check=true", "top");
    flush_rewrite_rules();
}

/**
 * Hook the parse_request action and serve the health endpoint when custom query variable is set to 'true'.
 *
 * @since    1.0.0
 * @param WP $wp Current WordPress environment instance
 */
function semonto_health_check_request($wp) {
    if (isset($wp->query_vars["semonto_health_check"]) && "true" === $wp->query_vars["semonto_health_check"]) {
        require_once __DIR__."/SemontoFramework/index.php";
        exit();
    }
}

/**
 * Filter the list of public query vars in order to allow the WP::parse_request to register the query variable.
 *
 * @since    1.0.0
 * @param array $public_query_vars The array of public query variables.
 * @return array
 */
function semonto_health_check_query_var($public_query_vars) {
    $public_query_vars[] = "semonto_health_check";
    return $public_query_vars;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this point in the file does not affect the page life cycle.
 *
 * @since    1.0.0
 */
function semonto_run_health_endpoint() {
    add_filter('plugin_action_links_' . plugin_basename(__DIR__) . '/semonto-health-monitor.php', 'semonto_add_plugin_page_settings_link');
    add_filter("query_vars", "semonto_health_check_query_var", 10, 1);
    add_action('parse_request', 'semonto_health_check_request',10,1);
    add_action('init', 'semonto_health_monitor_rewrite_rules',10); 
}

function semonto_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=semonto_health_monitor_settings' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

// Not used anymore.
function semonto_df_error_notice() {
    ?>
    <div class="error">
        <p><?php echo "Error executing 'df' command. Please check server configuration."; ?></p>
    </div>
    <?php
}

function semonto_show_account_notice () {
    $admin_page = get_current_screen();
    if ($admin_page->base == SEMONTO_HEALTH_MONITOR_SETTINGS_PAGE) {
        $user_id = get_current_user_id();
        if (!get_user_meta($user_id, 'semonto_notice_dismissed')) {
            $dismiss_url = add_query_arg('action', 'dismiss-account-notice');
            ?>
                <div class="notice notice-info is-dismissible"> 
                    <p>
                        <strong>
                            In order to use this plugin, you need a 
                            <a href="https://semonto.com/" target="_blank">Semonto</a>
                            account
                        </strong>
                    </p>
                    <a href="<?php echo esc_url($dismiss_url); ?>" class="notice-dismiss" style="text-decoration: none">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </a>
                </div>
            <?php
        }
    }
}

function semonto_notice_dismissed () {
    if (isset( $_GET['page'] ) && isset( $_GET['action'] )) {
        $page = sanitize_text_field( $_GET['page'] );
        $action = sanitize_text_field( $_GET['action'] );

        if ($page === 'semonto_health_monitor_settings' && $action === 'dismiss-account-notice') {
            $user_id = get_current_user_id();
            add_user_meta( $user_id, 'semonto_notice_dismissed', 'true', true );
            wp_redirect( remove_query_arg("action") );
            exit();
        }
    }
}

function semonto_check_available_features ()
{
    $features = [
        'exec_function' => true,
        'shell_exec_function' => true,
        'sys_getloadavg_function' => true,
        'df_command' => true,
        'vmstat_command' => true
    ];

    $disabled = explode(',', ini_get('disable_functions'));

    if (in_array('exec', $disabled)) {
        $features['exec_function'] = false;
    }

    if (!function_exists('exec')) {
        $features['exec_function'] = false;
    }

    if (in_array('shell_exec', $disabled)) {
        $features['shell_exec_function'] = false;
    }

    if (!function_exists('shell_exec')) {
        $features['shell_exec_function'] = false;
    }

    if (in_array('sys_getloadavg', $disabled)) {
        $features['sys_getloadavg_function'] = false;
    }

    if (!function_exists('sys_getloadavg')) {
        $features['sys_getloadavg_function'] = false;
    }

    if ($features['exec_function'] && $features['shell_exec_function']) {
        try {
            $df_command = exec('which df');
            if (!$df_command) {
                $features['df_command'] = false;
            }
        } catch (\Throwable $th) {
            $features['df_command'] = false;
        }

        try {
            $vmstat_command = exec('which df');
            if (!$vmstat_command) {
                $features['vmstat_command'] = false;
            }
        } catch (\Throwable $th) {
            $features['vmstat_command'] = false;
        }
    } else {
        $features['df_command'] = false;
        $features['vmstat_command'] = false;
    }

    return $features;
}

function semonto_get_available_disks ()
{
    $disks = [];

    $output = shell_exec('df -h');
    $lines = explode("\n", $output);
    for ($i = 1; $i < count($lines); $i++) {
        if (trim($lines[$i]) != '') {
            $cols = preg_split('/\s+/', $lines[$i]);
            if (preg_match('/^\/dev\//', $cols[0])) {
                $disks[$cols[0]] = [
                    "warning_percentage_threshold" => 75,
                    "error_percentage_threshold" => 90,
                    "enabled" => 0
                ];
            }
        }
    }

    return $disks;
}

function semonto_get_default_disk_config ()
{
    $available_disks = semonto_get_available_disks();
    $default_disk_config = [];
    foreach ($available_disks as $disk_name => $disk_config) {
        $disk_config['enabled'] = 1;
        $default_disk_config[$disk_name] = $disk_config;
    }

    return $default_disk_config;
}

function semonto_get_disk_space_config ()
{
    $disk_space_config = semonto_get_available_disks();
    $available_disks = array_keys($disk_space_config);

    $configured_disks = get_option('semonto_config_disk_space', semonto_get_default_disk_config());
    if ($configured_disks || !empty($configured_disks)) {
        foreach ($configured_disks as $disk_name => $disk_config) {
            if (in_array($disk_name, $available_disks)) {
                $disk_space_config[$disk_name] = array_merge($disk_space_config[$disk_name], $disk_config);
            }
        }
    }

    return $disk_space_config;
}

function semonto_get_disk_space_inode_config ()
{
    $disk_space_config = semonto_get_available_disks();
    $available_disks = array_keys($disk_space_config);

    $configured_disks = get_option('semonto_config_disk_space_inode', semonto_get_default_disk_config());
    if ($configured_disks || !empty($configured_disks)) {
        foreach ($configured_disks as $disk_name => $disk_config) {
            if (in_array($disk_name, $available_disks)) {
                $disk_space_config[$disk_name] = array_merge($disk_space_config[$disk_name], $disk_config);
            }
        }
    }

    return $disk_space_config;
}

function semonto_sanitize_disk_config($setting, $new_settings)
{
    $previous_settings = get_option($setting);

    if (!$new_settings || !empty($new_settings)) {
        return $previous_settings;
    }

    try {
        foreach ($new_settings as $disk => $config) {
            if (!isset($config['warning_percentage_threshold']) || !isset($config['error_percentage_threshold'])) {
                add_settings_error($setting, "$setting-$disk", 'Please provide a warning and an error threshold.');
                return $previous_settings;
            } else if ($config['warning_percentage_threshold'] === '' || $config['warning_percentage_threshold'] === null || $config['error_percentage_threshold'] === '' || $config['error_percentage_threshold'] === null) {
                add_settings_error($setting, "$setting-$disk", 'Please provide a warning and an error threshold.');
                return $previous_settings;
            } else if ((int) $config['warning_percentage_threshold'] >= (int) $config['error_percentage_threshold']) {
                add_settings_error($setting, "$setting-$disk", 'The warning threshold should be lower than the error threshold.');
                return $previous_settings;
            } else if ((int) $config['warning_percentage_threshold'] < 0 || (int) $config['warning_percentage_threshold'] > 100 || (int) $config['error_percentage_threshold'] < 0 || (int) $config['error_percentage_threshold'] > 100) {
                add_settings_error($setting, "$setting-$disk", 'The warning thresholds should be a number 0 to 100.');
                return $previous_settings;
            }
        }
    } catch (\Throwable $th) {
        return $previous_settings;
    }

    return $new_settings;
}

function semonto_sanitize_disk_space_config($new_value)
{
    return semonto_sanitize_disk_config('semonto_config_disk_space', $new_value);
}

function semonto_sanitize_disk_space_inode_config($new_value)
{
    return semonto_sanitize_disk_config('semonto_config_disk_space_inode', $new_value);
}

function semonto_sanitize_load_test_threshold($setting, $new_value)
{
    if ((float) $new_value < 0) {
        add_settings_error($setting, $setting, 'The threshold should be a positive number.');
        return get_option($setting);
    }

    return $new_value;
}

function semonto_sanitize_threshold_percentage($setting, $new_value)
{
    if ((int) $new_value < 0 || (int) $new_value > 100) {
        add_settings_error($setting, $setting, 'The threshold should be a number from 0 to 100.');
        return get_option($setting);
    }

    return $new_value;
}

function semonto_sanitize_cache_lifespan($new_value)
{
    if ((int) $new_value < 0) {
        add_settings_error('semonto_cache_lifespan', 'semonto_cache_lifespan', 'The cache expiration should be a positive number.');
        return get_option('semonto_cache_lifespan');
    }

    return $new_value;
}
