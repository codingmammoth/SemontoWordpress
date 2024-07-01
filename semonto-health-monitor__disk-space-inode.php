<?php $disks = semonto_get_disk_space_inode_config(); ?>

<div class="semonto-health-monitor__test-container">
    <h3 scope="row">Disk Space Inode</h3>
    <p>
        Test the amount of free inodes on your disks.
    </p>

    <?php if($exec_available) : ?>
        <div class="semonto-health-monitor__test">
            <div class="semonto-health-monitor__switch-container">
                <label 
                    for="semonto_enable_disk_space_inode_test"
                    class="semonto-health-monitor__switch-label"
                >Check free inodes</label>
                <div class="switch-option">
                    <label class="semonto-health-monitor__test-switch">
                        <input
                        type="checkbox"
                        name="semonto_enable_disk_space_inode_test"
                        id="semonto_enable_disk_space_inode_test"
                        value="1" <?php checked(1, get_option('semonto_enable_disk_space_inode_test')); ?>
                        />
                        <span class="semonto-health-monitor__test-switch-slider"></span>
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
                        <label 
                            for="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][enabled]"
                            class="semonto-health-monitor__switch-label"
                        ><?php echo $disk_name; ?>:</label>
                        <div class="switch-option">
                            <label class="semonto-health-monitor__test-switch">
                                <input
                                    type="checkbox"
                                    name="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][enabled]"
                                    id="semonto_config_disk_space_inode[<?php echo $disk_name; ?>][enabled]"
                                    value="1" <?php checked(1, $disk_config['enabled']); ?>
                                />
                                <span class="semonto-health-monitor__test-switch-slider"></span>
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
