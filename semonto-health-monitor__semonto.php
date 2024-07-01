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
                Hi, thank you for installing the Semonto plug in.
            </p>
        </div>
    </div>

    <div class="semonto-health-monitor__hero-content-wrapper">
        <div class="semonto-health-monitor__hero-content">
            <div>
                <h2>With semonto you can monitor</h2>
                <ol>
                    <li>
                        <a href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'website_monitoring' ) )?>">
                            <strong>The health of your website</strong>
                        </a>

                        <ul class="semonto-health-monitor__hero-content-list">
                            <li>Uptime</li>
                            <li>Broken links</li>
                            <li>SSL</li>
                            <li>Mixed content</li>
                            <li>Domain expiration</li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'server_health_monitoring' ) )?>">
                            <strong>The health of your server</strong>
                        </a>

                        <ul class="semonto-health-monitor__hero-content-list">
                            <li>Server load</li>
                            <li>Database</li>
                            <li>Disk space</li>
                        </ul>
                    </li>
                </ol>

                <h2>How to get started</h2>

                <p>You need a semonto account to get started</p>

                <p>
                    Visit
                    <a 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        href="https://supervisor.semonto.com/signup?url=<?php echo esc_url(get_site_url()) ?>"
                    >semonto.com</a>
                    to get a free 14-day trial.
                </p>

            </div>
        </div>

        <div class="semonto-health-monitor__hero-image-wrapper">
            <div>
                <img 
                    class="semonto-health-monitor__hero-image" 
                    src="<?php echo esc_url(plugins_url( 'images/semonto-dashboard.png', __FILE__ )) ?>" 
                    alt="Semonto" 
                />
            </div>
        </div>

    </div>

</div>
