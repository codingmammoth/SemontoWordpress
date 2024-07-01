<?php

/*
Plugin Name: Semonto Health Monitor
Version: 1.0.1
Description: Semonto health plugin for Wordpress 
Author: Coding Mammoth - Semonto
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once 'functions.php';

add_action('admin_enqueue_scripts', 'semonto_health_monitor_enqueue_styles');
add_action('admin_enqueue_scripts', 'semonto_health_monitor_enqueue_script');

function semonto_health_monitor_settings_page() {
        $current_tab = isset( $_GET['semonto_tab'] ) ? $_GET['semonto_tab'] : 'semonto';
    ?>

        <?php
            $activation_message_shown = get_option('semonto_activation_message_shown', false);
            if (!$activation_message_shown) {
                ?>
                <div class="instal-succes-message">Good job! The Semonto plugin has been activated.</div>
                <?php
                update_option('semonto_activation_message_shown', true);
            }
        ?>

        <div class="semonto-health-monitor">

            <h1 class="semonto-health-monitor__title">Semonto Health Monitor</h1>

            <nav class="semonto-health-monitor__tabs">
                <a 
                    class="semonto-health-monitor__tab <?php echo $current_tab == 'semonto' ? 'active' : '' ; ?>" 
                    href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'semonto' ) )?>"
                >
                    Semonto
                </a>
                <a 
                    class="semonto-health-monitor__tab <?php echo $current_tab == 'website_monitoring' ? 'active' : '' ; ?>" 
                    href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'website_monitoring' ) )?>"
                >
                    Website Monitoring
                </a>
                <a
                    class="semonto-health-monitor__tab <?php echo $current_tab == 'server_health_monitoring' ? 'active' : '' ; ?>" 
                    href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'server_health_monitoring' ) )?>"
                >
                    Server Health Monitoring
                </a>
            </nav>

            <div class="semonto-health-monitor__body">
                <?php
                    if ($current_tab == 'website_monitoring') {
                        include 'semonto-health-monitor__website-monitoring.php';
                    } else if ($current_tab == 'server_health_monitoring') {
                        include 'semonto-health-monitor__server-health-monitoring.php';
                    } else {
                        include 'semonto-health-monitor__semonto.php';
                    }
                ?>
            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                new SemontoHealthMonitor()
            })
        </script>
    <?php
}

semonto_run_health_endpoint();
add_action('admin_menu', function () {
    add_options_page(
        'Semonto Health Monitor Settings',
        'Semonto Health Monitor',
        'manage_options',
        'semonto_health_monitor_settings',
        'semonto_health_monitor_settings_page'
    );
});
add_action('admin_init', 'semonto_health_monitor_save_settings');
add_action('admin_notices', 'semonto_show_account_notice');
add_action('admin_init', 'semonto_notice_dismissed');
