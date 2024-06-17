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
