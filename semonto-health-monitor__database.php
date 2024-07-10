<div class="semonto-health-monitor__test-container">
    <h3>Wordpress Database Test</h3>
    <p>
        Get notified if there are issues with your database. Semonto will also
        check how many current database connections are in use and what your
        limit is.
    </p>

    <div class="semonto-health-monitor__test-thresholds">
        <div class="semonto-health-monitor__test-threshold">Warning percentage</div>
        <div class="semonto-health-monitor__test-threshold">Error percentage</div>
    </div>

    <div class="">
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <label 
                    for="semonto_enable_wpdb_test" 
                    class="semonto-health-monitor__switch-label"
                >Enable database test</label>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input 
                            type="checkbox" 
                            name="semonto_enable_wpdb_test" 
                            id="semonto_enable_wpdb_test" 
                            value="1" <?php checked(1, get_option('semonto_enable_wpdb_test', true)); ?> 
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
                    </label>
                </div>
            </div>
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_warning_threshold_wpdb" 
                value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_wpdb', 75))); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_error_threshold_wpdb" 
                value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_wpdb', 90))); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
        </div>
    </div>
</div>
