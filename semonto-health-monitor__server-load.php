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
                        <?php checked(1, get_option('semonto_enable_now_test')); ?> 
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
                        <?php checked(1, get_option('semonto_enable_5m_test')); ?> 
                    />
                    <span class="slider round"></span>
                </label>
            </div>
            <input 
                type="number" 
                min="1" 
                max="100" 
                name="semonto_warning_threshold_5m" 
                value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_5m', 5))); ?>" 
                class="semonto_serverload" 
            />
            <input 
                type="number" 
                min="1" 
                max="100" 
                name="semonto_error_threshold_5m" 
                value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_5m', 15))); ?>" 
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
                        value="1" 
                        <?php checked(1, get_option('semonto_enable_15m_test')); ?> 
                    />
                    <span class="slider round"></span>
                </label>
            </div>
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_warning_threshold_15m" 
                value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_15m', 5))); ?>" 
                class="semonto_serverload" 
            />
            <input 
                type="number" 
                min="0" 
                max="100" 
                name="semonto_error_threshold_15m" 
                value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_15m', 15))); ?>" 
                class="semonto_serverload" 
            />
        </div>
    </div>
</div>
