<?php $disks = semonto_get_disk_space_inode_config(); ?>

<div class="semonto-health-monitor__test-container">
    <h3 scope="row">Disk Space Inode</h3>
    <p>
        Ut officiis amet est labore et et itaque suscipit. Quas dicta pariatur doloremque voluptas accusamus.
    </p>

    <?php if($exec_available) : ?>
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <p class="semonto-health-monitor__switch-label">Disk space</p>
                <div class="switch-option">
                    <label class="switch">
                        <input
                        type="checkbox"
                        name="semonto_enable_disk_space_inode_test"
                        value="1" <?php checked(1, get_option('semonto_enable_disk_space_inode_test')); ?>
                        />
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="semonto-health-monitor__test-thresholds">
            <div class="semonto-health-monitor__test-threshold">Warning percentage</div>
            <div class="semonto-health-monitor__test-threshold">Error percentage</div>
        </div>

        <?php foreach ($disks as $disk_name => $disk_config ): ?>
            <div class="">
                <div class="semonto-health-monitor__test">
                    <div class="semonto-health-monitor__switch-container">
                        <p class="semonto-health-monitor__switch-label"><?php echo $disk_name; ?>:</p>
                        <div class="switch-option">
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    name="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][enabled]"
                                    value="1" <?php checked(1, $disk_config['enabled']); ?>
                                />
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <input
                        type="number"
                        min="0"
                        max="100"
                        name="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][warning_percentage_threshold]"
                        value="<?php echo esc_attr(intval($disk_config['warning_percentage_threshold'])); ?>"
                        class="semonto-health-monitor__test-threshold"
                    />
                    <input
                        type="number"
                        min="0"
                        max="100"
                        name="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][error_percentage_threshold]"
                        value="<?php echo esc_attr(intval($disk_config['error_percentage_threshold'])); ?>"
                        class="semonto-health-monitor__test-threshold"
                    />
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="semonto-health-monitor__not-available">
            <span>ℹ️</span>
            This test is not available due to your server setup.
        </p>
    <?php endif; ?>

</div>
