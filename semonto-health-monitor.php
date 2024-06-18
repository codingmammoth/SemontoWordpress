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
    ?>
        <div class="semonto-health-monitor">

            <?php
                $activation_message_shown = get_option('semonto_activation_message_shown', false);
                if (!$activation_message_shown) {
                    ?>
                    <div class="instal-succes-message">Good job! The Semonto plugin has been activated.</div>
                    <?php
                    update_option('semonto_activation_message_shown', true);
                }
            ?>

            <div class="semontosetting">
                <h1 class="titles">Semonto Health Monitor Settings</h1>
            </div>

            <div class="semontolink">
                <div id="semontotext">To get the status of your website, please go to</div>
                <a id="semontobutton" href="https://supervisor.semonto.com/" target="_blank" >semonto.com</a>
            </div>

            <h2>Website monitoring</h2>
            <p>
                Semonto will notify you if something is wrong with your website: uptime, ssl, etc
                <br>
                To start monitoring this website:
            </p>
            <ol>
                <li>Go to semonto.com</li>
                <li>Add a new website</li>
                <li>Enter the url of your website and save</li>
            </ol>
            <p>
                Semonto will start monitoring your website and notify you if any issues are found.
            </p>
            <p>
                Read more about how you can 
                <a href="https://semonto.com/how-to/how-to-monitor-your-website" target="_blank"><u>configure the settings.</u></a>
            </p>

            <h2>Server monitoring</h2>
            <p>
                Semonto can monitor the health of your server: disk space, server load etc...<br>
                To start monitoring this server:
            </p>
            <ol>
                <li>Go to semonto.com</li>
                <li>Add a new server</li>
                <li>Enter the following endpoint: <b><?php echo esc_url(home_url('/health')); ?></b> </li>
                <li>Select the wordpress format as the endpoint type, hit save</li>
            </ol>
            <p>Semonto will start monitoring your server and notify you if any issues are found.</p>
            <p>
                Read more about how you can 
                <a href="https://semonto.com/how-to/how-to-monitor-your-website"  target="_blank"><u>configure the settings.</u></a>
            </p>

            <form method="post" action="options.php">

                <?php
                    settings_fields('semonto_health_monitor_settings');
                    do_settings_sections('semonto_health_monitor_settings');
                ?>

                <div class="form">

                    <div class="tests">
                        <br>
                        <p>
                            If you want to use server health monitoring you can specify the tests below.
                        </p>
                    </div>

                    <?php include 'semonto-health-monitor__server-load.php';?>

                    <?php include 'semonto-health-monitor__memory-usage.php';?>

                    <?php include 'semonto-health-monitor__disk-space.php';?>

                    <?php include 'semonto-health-monitor__database.php';?>

                    <?php include 'semonto-health-monitor__secret-key.php';?>

                    <?php include 'semonto-health-monitor__caching.php';?>

                </div>

                <button type="submit" class="input-button overall">Save changes</button>

            </form>
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
