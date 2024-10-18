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
                Hi, thank you for installing the Semonto plug-in.
            </p>
        </div>
    </div>

    <div class="semonto-health-monitor__hero-content-wrapper">
        <div class="semonto-health-monitor__hero-content">
            <div>
                <h2>With semonto you can monitor</h2>
                <ol>
                    <li>
                        <strong>The health of your website</strong>
                        <ul class="semonto-health-monitor__hero-content-list">
                            <li>Uptime</li>
                            <li>Broken links</li>
                            <li>Lighthouse monitoring</li>
                            <li>SSL</li>
                            <li>Mixed content</li>
                            <li>Domain expiration</li>
                        </ul>
                    </li>
                    <li>
                        <strong>The health of your server</strong>
                        <ul class="semonto-health-monitor__hero-content-list">
                            <li>Server load</li>
                            <li>Database</li>
                            <li>Disk space</li>
                        </ul>
                    </li>
                </ol>

                <h2>How to get started</h2>
                <ol>
                    <li>
                        Create a Semonto account. Visit 
                        <a 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            href="https://supervisor.semonto.com/signup?url=<?php echo esc_url(get_site_url()) ?>"
                        ><strong>semonto.com</strong></a>
                        to get a free 14-day trial.
                    </li>
                    <li>
                        To monitor the health of your website, click 
                        <a 
                            href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'website_monitoring' ) )?>"
                        ><strong>here</strong></a>.
                    </li>
                    <li>
                        If you also want to monitor the server in more depth, click 
                        <a 
                            href="<?php echo esc_url( add_query_arg( 'semonto_tab', 'server_health_monitoring' ) )?>"
                        ><strong>here</strong></a>.
                    </li>
                </ol>

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
