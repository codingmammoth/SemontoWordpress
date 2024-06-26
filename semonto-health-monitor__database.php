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
                        value="1" <?php checked(1, get_option('semonto_enable_wpdb_test')); ?> 
                    />
                    <span class="slider round"></span>
                </label>
            </div>
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_warning_threshold_wpdb" 
                value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_wpdb', 75))); ?>" 
                class="semonto_serverload" 
            />
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_error_threshold_wpdb" 
                value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_wpdb', 90))); ?>" 
                class="semonto_serverload" 
            />
        </div>
    </div>
</div>
