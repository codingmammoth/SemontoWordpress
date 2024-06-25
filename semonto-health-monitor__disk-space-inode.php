<?php $disks = semonto_get_disk_space_inode_config(); ?>

<div class="input-tests">
    <h3 scope="row">Disk Space Inode</h3>
    <p>
        Ut officiis amet est labore et et itaque suscipit. Quas dicta pariatur doloremque voluptas accusamus.
    </p>

    <div class="input-fields-text">
        <p class="title-test">Disk space</p>
        <div class="switch-option">
            <label class="switch">
                <input
                type="checkbox"
                name="semonto_disk_space_inode_enable"
                value="1" <?php checked(1, get_option('semonto_disk_space_inode_enable')); ?>
                />
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="warning-error">
        <div class="warning one">Warning percentage</div>
        <div class="warning">Error percentage</div>
    </div>

    <?php foreach ($disks as $disk_name => $disk_config ): ?>
        <div class="input-fields">
            <div class="input-fields-text">
                <p class="title-test"><?php echo $disk_name; ?>:</p>
                    <div class="switch-option">
                        <label class="switch">
                            <input
                                type="checkbox"
                                name="semonto_disk_space_inode_config[<?php echo $disk_name; ?>][enabled]"
                                value="1" <?php checked(1, $disk_config['enabled']); ?>
                            />
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <input
                        type="number"
                        min="1"
                        max="100"
                        name="semonto_disk_space_inode_config[<?php echo $disk_name; ?>][warning_percentage_threshold]"
                        value="<?php echo esc_attr(intval($disk_config['warning_percentage_threshold'])); ?>"
                        class="semonto_serverload"
                    />
                    <input
                        type="number"
                        min="1"
                        max="100"
                        name="semonto_disk_space_inode_config[<?php echo $disk_name; ?>][error_percentage_threshold]"
                        value="<?php echo esc_attr(intval($disk_config['error_percentage_threshold'])); ?>"
                        class="semonto_serverload"
                    />
            </div>
        </div>
    <?php endforeach; ?>

</div>
