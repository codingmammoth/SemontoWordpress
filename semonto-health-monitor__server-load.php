<div class="semonto-health-monitor__test-container">
    <h3>Load tests</h3>
    <p>
        Get notified when the load of your server is too high
    </p>

    <div class="semonto-health-monitor__test-thresholds">
        <div class="semonto-health-monitor__test-threshold">Warning threshold</div>
        <div class="semonto-health-monitor__test-threshold">Error threshold</div>
    </div>

    <div class="">
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <p class="semonto-health-monitor__switch-label">Load now:</p>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input 
                            type="checkbox" 
                            name="semonto_enable_now_test" 
                            value="1" 
                            <?php checked(1, get_option('semonto_enable_now_test')); ?> 
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
                    </label>
                </div>
            </div>
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_warning_threshold_now" 
                value="<?php echo esc_attr(get_option('semonto_warning_threshold_now', 5)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_error_threshold_now" 
                value="<?php echo esc_attr(get_option('semonto_error_threshold_now', 15)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
        </div>
    </div>

    <div class="">
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <p class="semonto-health-monitor__switch-label">Load average 5 minutes:</p>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input 
                            type="checkbox" 
                            name="semonto_enable_5m_test" 
                            value="1"
                            <?php checked(1, get_option('semonto_enable_5m_test')); ?> 
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
                    </label>
                </div>
            </div>
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_warning_threshold_5m" 
                value="<?php echo esc_attr(get_option('semonto_warning_threshold_5m', 5)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_error_threshold_5m" 
                value="<?php echo esc_attr(get_option('semonto_error_threshold_5m', 15)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
        </div>
    </div>

    <div class="">
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <p class="semonto-health-monitor__switch-label"> Load average 15 minutes:</p>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input 
                            type="checkbox" 
                            name="semonto_enable_15m_test" 
                            value="1" 
                            <?php checked(1, get_option('semonto_enable_15m_test')); ?> 
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
                    </label>
                </div>
            </div>
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_warning_threshold_15m" 
                value="<?php echo esc_attr(get_option('semonto_warning_threshold_15m', 5)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
            <input 
                type="number" 
                min="0"
                step="0.01"
                name="semonto_error_threshold_15m" 
                value="<?php echo esc_attr(get_option('semonto_error_threshold_15m', 15)); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
        </div>
    </div>
</div>
