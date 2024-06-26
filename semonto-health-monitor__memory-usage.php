<div class="input-tests">
    <h3 scope="row">Memory Usage</h3>
    <p>
        Get notified when the memory usage on your server is too high
    </p>

    <?php if($exec_available) : ?>
        <div class="warning-error">
            <div class="warning one">Warning threshold</div>
            <div class="warning">Error threshold</div>
        </div>

        <div class="input-fields">
            <div class="input-fields-text">
                <p class="title-test">Memory usage:</p>
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
                <input
                    type="number"
                    min="0"
                    max="100"
                    name="semonto_warning_threshold_memory_usage"
                    value="<?php echo esc_attr(intval(get_option('semonto_warning_threshold_memory_usage', 90))); ?>"
                    class="semonto_serverload"
                />
                <input
                    type="number"
                    min="0"
                    max="100"
                    name="semonto_error_threshold_memory_usage"
                    value="<?php echo esc_attr(intval(get_option('semonto_error_threshold_memory_usage', 95))); ?>"
                    class="semonto_serverload"
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
