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
    register_setting('semonto_health_monitor_settings', 'semonto_secret_key');
    register_setting('semonto_health_monitor_settings', 'semonto_enable_now_test');
    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_now');
    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_5m');
    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_15m');
    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_now');
    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_5m');
    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_15m');
    register_setting('semonto_health_monitor_settings', 'semonto_enable_5m_test');
    register_setting('semonto_health_monitor_settings', 'semonto_enable_15m_test');
    register_setting('semonto_health_monitor_settings', 'semonto_enable_wpdb_test');
    register_setting('semonto_health_monitor_settings', 'semonto_error_threshold_wpdb');
    register_setting('semonto_health_monitor_settings', 'semonto_warning_threshold_wpdb');
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
            'tests' => semonto_generate_tests_config()
        ];

        $secret_key = get_option('semonto_secret_key');
        if(strlen($secret_key)>0){
            $config['secret_key'] = trim($secret_key);
        }
    return $config;
}

// generates an array with the enabled tests 
function semonto_generate_tests_config() {
    $config = [];
    if (get_option('semonto_enable_now_test')) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 'type' => 'current', 'warning_threshold' => get_option('semonto_warning_threshold_now'), 'error_threshold' =>  get_option('semonto_error_threshold_now')]
        ];
        
    }
    if (get_option('semonto_enable_5m_test')) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 'type' => 'average_5_min', 'warning_threshold' => get_option('semonto_warning_threshold_5m'), 'error_threshold' => get_option('semonto_error_threshold_5m') ]
        ];
    }
    if (get_option('semonto_enable_15m_test')) {
        $config[] = [
            'test' => 'ServerLoad',
            'config' => [ 'type' => 'average_15_min', 'warning_threshold' => get_option('semonto_warning_threshold_15m'), 'error_threshold' => get_option('semonto_error_threshold_15m') ]
        ];
    }
    if (get_option('semonto_enable_wpdb_test')) {
        $config[] = [
            'test' => 'WPcheckConnection',
            'config' => [], 
        ];
        $config[] = [
            'test'=>'WPMaxDatabaseConnections',
            'config' => [ 'warning_percentage_threshold' => get_option('semonto_warning_threshold_wpdb'), 'error_percentage_threshold' =>get_option('semonto_error_threshold_wpdb') ]
        ];
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
    add_filter("query_vars", "semonto_health_check_query_var", 10, 1);
    add_action('parse_request', 'semonto_health_check_request',10,1);
    add_action('init', 'semonto_health_monitor_rewrite_rules',10); 
}

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
