<div class="semonto-health-monitor__test-container">
    <h3 scope="row">Memory Usage</h3>
    <p>
        Get notified when the memory usage on your server is too high
    </p>

    <?php if($exec_available) : ?>
        <div class="semonto-health-monitor__test-thresholds">
            <div class="semonto-health-monitor__test-threshold">Warning threshold</div>
            <div class="semonto-health-monitor__test-threshold">Error threshold</div>
        </div>

        <div class="">
            <div class="semonto-health-monitor__test">
                <div class="semonto-health-monitor__switch-container">
                    <p class="semonto-health-monitor__switch-label">Memory usage:</p>
                    <div class="switch-option">
                        <label class="switch">
                            <input
                                type="checkbox"
                                name="semonto_enable_memory_usage_test"
                                value="1" <?php checked(1, get_option('semonto_enable_memory_usage_test')); ?>
                            />
                            <span class="slider round"></span>
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
            This test is not available due to your server setup.
        </p>
    <?php endif; ?>

</div>
