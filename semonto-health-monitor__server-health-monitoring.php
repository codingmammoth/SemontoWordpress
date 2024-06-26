<?php
        // TODO: Can still be disabled for security reasons.
        $exec_available = function_exists('exec');
        $shell_exec_available = function_exists('shell_exec');

        // Check if shell_exec and exec exists and are enabled.
        // https://stackoverflow.com/questions/2749591/php-exec-check-if-enabled-or-disabled

        // https://stackoverflow.com/questions/4033841/how-to-test-if-php-system-function-is-allowed-and-not-turned-off-for-security
?>

<div>
    <h2>Server monitoring</h2>
    <p>
        Semonto can monitor the health of your server: disk space, server load etc...<br>
        To start monitoring this server:
    </p>
    <ol>
        <li>Go to semonto.com</li>
        <li>Add a new server</li>
        <li>Enter the following endpoint: <b><?php echo esc_url(home_url('/health')); ?></b> </li>
        <li>Select the wordpress format as the endpoint type, hit save</li>
    </ol>
    <p>Semonto will start monitoring your server and notify you if any issues are found.</p>
    <p>
        Read more about how you can
        <a href="https://semonto.com/how-to/how-to-monitor-a-wordpress-website-with-semonto" target="_blank">
            <u>configure the settings.</u>
        </a>
    </p>

    <form method="post" action="options.php">

        <?php
            settings_fields('semonto_health_monitor_settings');
            do_settings_sections('semonto_health_monitor_settings');
        ?>

        <div class="form">

            <div class="tests">
                <br>
                <p>
                    If you want to use server health monitoring you can specify the tests below.
                </p>
            </div>

            <?php include 'semonto-health-monitor__server-load.php'; ?>

            <?php include 'semonto-health-monitor__memory-usage.php'; ?>

            <?php include 'semonto-health-monitor__disk-space.php'; ?>

            <?php include 'semonto-health-monitor__disk-space-inode.php'; ?>

            <?php include 'semonto-health-monitor__database.php'; ?>

            <?php include 'semonto-health-monitor__secret-key.php'; ?>

            <?php include 'semonto-health-monitor__caching.php'; ?>

        </div>

        <button type="submit" class="input-button overall">Save changes</button>

    </form>
</div>
