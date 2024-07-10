<div class="semonto-health-monitor__test-container">
    <h3>Memory usage</h3>
    <p>
        Get notified when the memory usage of your server is too high.
    </p>

    <?php if ($features['vmstat_command']) : ?>
        <div class="semonto-health-monitor__test-thresholds">
            <div class="semonto-health-monitor__test-threshold">Warning threshold</div>
            <div class="semonto-health-monitor__test-threshold">Error threshold</div>
        </div>

        <div class="">
            <div class="semonto-health-monitor__test">
                <div class="semonto-health-monitor__switch-container">
                    <label
                        for="semonto_enable_memory_usage_test"
                        class="semonto-health-monitor__switch-label"
                    >Memory usage</label>
                    <div class="switch-option">
                        <label class="semonto-health-monitor__test-switch">
                            <input
                                type="checkbox"
                                name="semonto_enable_memory_usage_test"
                                id="semonto_enable_memory_usage_test"
                                value="1" <?php checked(1, get_option('semonto_enable_memory_usage_test', true)); ?>
                            />
                            <span class="semonto-health-monitor__test-switch-slider"></span>
                        </label>
                    </div>
                </div>
                <input
                    type="number"
                    min="0"
                    max="100"
                    name="semonto_warning_threshold_memory_usage"
                    value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_memory_usage', 90))); ?>"
                    class="semonto-health-monitor__test-threshold"
                />
                <input
                    type="number"
                    min="0"
                    max="100"
                    name="semonto_error_threshold_memory_usage"
                    value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_memory_usage', 95))); ?>"
                    class="semonto-health-monitor__test-threshold"
                />
            </div>
        </div>
    <?php else : ?>
        <p class="semonto-health-monitor__not-available">
            <span>ℹ️</span>
            This test is not available due to your server setup. See
            <a 
                target="_blank"
                rel="noopener noreferer"
                href="https://semonto.com/how-to/how-to-monitor-a-wordpress-website-with-semonto"
            >our docs</a>
            for the server requirements.
        </p>
    <?php endif; ?>

</div>
