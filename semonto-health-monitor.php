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
                    <div >
                        <div class="tests">
                            <br>
                            <p>
                                If you want to use server health monitoring you can specify the tests below.
                            </p>
                        </div>
            
                        <div class="input-tests">
                            <h3>Load tests</h3>
                            <p>Get notified when the load of your server is too high</p>
                            
                            <div class="warning-error">
                                <div class="warning one load">Warning threshold</div>
                                <div class="warning">Error threshold</div>
                            </div>

                            <div class="input-fields">
                                <div class="input-fields-text">
                                    <p class="title-test">Load now:</p>
                                    <div class="switch-option">
                                        <label class="switch">
                                            <input 
                                                type="checkbox" 
                                                name="semonto_enable_now_test" 
                                                value="1" 
                                                <?php checked(1,get_option('semonto_enable_now_test')); ?>
                                            />
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <input 
                                        type="number" 
                                        min="1" 
                                        max="100" 
                                        name="semonto_warning_threshold_now" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_now', 5))); ?>" 
                                        class="semonto_serverload" 
                                    />
                                    <input 
                                        type="number" 
                                        min="1" 
                                        max="100" 
                                        name="semonto_error_threshold_now" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_now', 15))); ?>" 
                                        class="semonto_serverload" 
                                    />
                                </div>
                            </div>

                            <div class="input-fields">
                                <div class="input-fields-text">
                                    <p class="title-test">Load average 5 minutes:</p>
                                    <div class="switch-option">
                                        <label class="switch">
                                            <input 
                                                type="checkbox" 
                                                name="semonto_enable_5m_test" 
                                                value="1" 
                                                <?php checked(1,get_option('semonto_enable_5m_test')); ?> 
                                            />
                                            <span class="slider round"></span>
                                        </label>   
                                    </div>
                                    <input 
                                        type="number"
                                        min="1" 
                                        max="100" 
                                        name="semonto_warning_threshold_5m" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_5m',5))); ?>" 
                                        class="semonto_serverload" 
                                    />
                                    <input 
                                        type="number" 
                                        min="1" 
                                        max="100" 
                                        name="semonto_error_threshold_5m" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_5m',15))); ?>" 
                                        class="semonto_serverload"
                                    />
                                </div>
                            </div>
            
                            <div class="input-fields">
                                <div class="input-fields-text">
                                    <p class="title-test"> Load average 15 minutes:</p>
                                    <div class="switch-option">
                                        <label class="switch">
                                            <input 
                                                type="checkbox" 
                                                name="semonto_enable_15m_test" 
                                                value="1" <?php checked(1,get_option('semonto_enable_15m_test')); ?>
                                            />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                     <input 
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        name="semonto_warning_threshold_15m" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_15m',5))); ?>" 
                                        class="semonto_serverload"
                                    />
                                     <input
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        name="semonto_error_threshold_15m" 
                                        value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_15m',15))); ?>" 
                                        class="semonto_serverload"
                                    />
                                </div>
                            </div>
                        </div>
                  
   
                    <div class="input-tests">
                        <h3 scope="row">Wordpress Database Test</h3>
                        <p>
                            Get notified if there are issues with your database. Semonto will also 
                            check how many current database connections are in use and what your 
                            limit is.
                        </p>

                        <div class="warning-error">
                            <div class="warning one">Warning percentage</div>
                            <div class="warning">Error percentage</div>
                        </div>

                        <div class="input-fields">
                            <div class="input-fields-text">
                                <p class="title-test">Enable database test:</p>
                                <div class="switch-option">
                                    <label class="switch">
                                        <input 
                                            type="checkbox" 
                                            name="semonto_enable_wpdb_test" 
                                            value="1" 
                                            <?php checked(1,get_option('semonto_enable_wpdb_test')); ?> 
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <input 
                                    type="number" 
                                    min="1" 
                                    max="100" 
                                    name="semonto_warning_threshold_wpdb" 
                                    value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_wpdb',75))); ?>"
                                    class="semonto_serverload" 
                                />
                                <input 
                                    type="number" 
                                    min="1" 
                                    max = "100" 
                                    name="semonto_error_threshold_wpdb" 
                                    value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_wpdb',90))); ?>" 
                                    class="semonto_serverload"  
                                />
                            </div>
                        </div>
                    </div>

                    <div class="test-field">
                        <h3 class="titles">Secret key</h3>
                        <p>
                            If you want to add an extra layer of protection, copy the secret key from the 
                            monitor settings in Semonto. This will limit exposure of your health endpoint.
                        </p>
                        <div class="options">
                            <input 
                                id="secret-key" 
                                type="text" 
                                name="semonto_secret_key" 
                                value="<?php echo esc_attr(get_option('semonto_secret_key'),); ?>" 
                                class="input-field"
                            />
                        </div>
                    </div>

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
