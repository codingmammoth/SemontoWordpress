<div class="input-tests">
    <h3 scope="row">Memory Usage</h3>
    <p>
        Get notified when the memory usage on your server is too high
    </p>

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
                        name="semonto_memory_usage_enable"
                        value="1" <?php checked(1, get_option('semonto_memory_usage_enable')); ?>
                    />
                    <span class="slider round"></span>
                </label>
            </div>
            <input
                type="number"
                min="1"
                max="100"
                name="semonto_memory_usage_enable_warning_threshold"
                value="<?php echo esc_attr(intval(get_option('semonto_memory_usage_enable_warning_threshold', 90))); ?>"
                class="semonto_serverload"
            />
            <input
                type="number"
                min="1"
                max="100"
                name="semonto_memory_usage_enable_error_threshold"
                value="<?php echo esc_attr(intval(get_option('semonto_memory_usage_enable_error_threshold', 95))); ?>"
                class="semonto_serverload"
            />
        </div>
    </div>
</div>
