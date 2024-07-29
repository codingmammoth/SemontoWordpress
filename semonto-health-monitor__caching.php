<div class="semonto-health-monitor__test-container">
    <h3>Caching</h3>
    <p>
        If wanted, you can cache the results of the tests to ensure the tests 
        are not executed too often.
    </p>

    <div class="semonto-health-monitor__test-thresholds">
        <div class="semonto-health-monitor__test-threshold">Expiration time in seconds</div>
    </div>

    <div class="">
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <label 
                    for="semonto_enable_caching" 
                    class="semonto-health-monitor__switch-label"
                >Enable caching</label>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input 
                            type="checkbox" 
                            name="semonto_enable_caching" 
                            id="semonto_enable_caching" 
                            value="1" <?php checked(1, get_option('semonto_enable_caching', true)); ?> 
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
                    </label>
                </div>
            </div>
            <input 
                type="number" 
                min="0"
                name="semonto_cache_lifespan" 
                value="<?php echo esc_attr(intval(get_option('semonto_cache_lifespan', 45))); ?>" 
                class="semonto-health-monitor__test-threshold" 
            />
        </div>
    </div>
</div>
