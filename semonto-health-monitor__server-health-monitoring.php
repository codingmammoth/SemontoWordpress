<?php
    $exec_available = function_exists('exec');
    $shell_exec_available = function_exists('shell_exec');
?>

<div class="semonto-health-monitor__hero">

    <div class="semonto-health-monitor__hero-banner">
        <div class="semonto-health-monitor__hero-icon-wrapper">
            <img 
                class="semonto-health-monitor__hero-icon" 
                width="32" 
                height="32" 
                src="<?php echo esc_url(plugins_url( 'images/semonto-logo.png', __FILE__ )) ?>" 
            />
        </div>
        <div>
            <p>
                Semonto can monitor the health of your server: disk space, server load etc..
            </p>
        </div>
    </div>

    <div class="semonto-health-monitor__hero-content-wrapper">
    <div class="semonto-health-monitor__hero-content">
            <div>
                <h2>To start monitoring this server</h2>

                <ol>
                    <li>
                        Go to 
                        <a target="_blank" rel="noopener noreferrer" href="https://supervisor.semonto.com">supervisor.semonto.com</a> 
                        and login
                    </li>
                    <li>Add a new server</li>
                    <li>Enter the following endpoint:<br><strong><?php echo esc_url(home_url('/health')); ?></strong>
                    </li>
                    <li>Select the Craft CMS format as the endpoint type, hit save.</li>
                </ol>

                <p>
                    Semonto will start monitoring your server and notify you if any issues are found.
                </p>
                <p>
                    Read more about how you can 
                    <a 
                        target="_blank"
                        rel="noopener noreferrer"
                        href="https://semonto.com/how-to/how-to-monitor-server-health-with-semonto"
                    >configure the settings</a>.
                </p>

            </div>
        </div>

        <div class="semonto-health-monitor__hero-image-wrapper">
            <div>
                <img 
                    class="semonto-health-monitor__hero-image" 
                    src="<?php echo esc_url(plugins_url( 'images/semonto-health-monitor-server-monitoring.png', __FILE__ )) ?>" 
                    alt="Semonto" 
                />
            </div>
        </div>

    </div>

    <form class="semonto-health-monitor__form" method="post" action="options.php">

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
