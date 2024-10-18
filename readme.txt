=== Semonto - Uptime monitoring, Broken Links, SSL and Lighthouse ===
Contributors: CodingMammoth
Tags: uptime, broken links, SSL, server health, Semonto
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Semonto watches the health of your website and server. Get notified when 
something is wrong, so you can fix the issue before anyone notices.

== Description ==

Semonto watches your website 24/7 and alerts you if there is a problem.
This way, you can fix the issue before anyone notices.

With Semonto, you can be sure that:
* Your website is up
* Pages are loading fast enough
* All links and buttons are working
* The security certificate is valid (HTTPS)
* Your server is healthy

This WordPress plugin connects your website to Semonto.
An active [Semonto account](https://semonto.com) is required. 

The results are displayed in the Semonto dashboard.

You will also receive a monthly uptime report with a detailed 
performance of your website.

### Features

- Uptime monitoring:
    - Know if your website is reachable.
- Broken link monitoring
    - Know if all buttons and links are working.
- Lighthouse Monitoring
    - Instead of manually performing Lighthouse tests, automate your testing
      and receive a notification if a website or page is not performing well.
- HTTPS and SSL monitoring
    - Make sure the connection is secure (the green padlock).
- Mixed content monitoring
    - Monitor if all the elements on your website are secure
- Server Health monitoring
    - Test whether your server is healthy (load, database, etc.).
- Content checks
    - Check whether your website is not returning a blank page or if 
      someone has not accidentally deleted something important from 
      your code.

### Other cool things you can do in Semonto

- Generate a PDF performance report
- Add team members to your account
- Create your own server tests

### Credits

This plugin is officially developed by Semonto.

### Questions and Support

Find more info, help pages and our contact details 
on [Semonto](https://semonto.com/)

Links:
- [Terms Of Service](https://semonto.com/service)
- [Privacy Policy](https://semonto.com/privacy)


### Development and issues

Feel free to file issues, or suggest code changes in our  [Github Repo](https://github.com/codingmammoth/SemontoWordpress)

== Installation ==

The installation and configuration of the plugin is straightforward

- Get the plugin
- Install and activate the plugin in WordPress.  
- If you don’t have a Semonto account yet, Go 
  to [Semonto](https://semonto.com/), and create an account.
- If you want to monitor the health of a website:
    - Go to Semonto, add a new Website and enter the URL of your website.
    - Done! Semonto will notify you of downtime, broken links, security 
      issues and more. 
- If you want to monitor the health of your WordPress server in more depth:
    - Go to Semonto, go to Server Health
    - Hit Add Server 
    - Enter the Health endpoint as shown in the plugin page, and create 
      a server health endpoint. Select WordPress as Framework.
    - Create the server

== Frequently Asked Questions ==

= What do I need to use this plugin? =

An active [Semonto account](https://semonto.com/) is required.

= How will I be notified of issues? =

There are plenty of notification options to choose from:

- E-mail (default)
- SMS
- Voice call
- Webhooks
- Push notifications (download the app)
- Message in your Slack channel

= Can I keep the server health data private? =

If you want to keep the health data secret, enter the Secret key you 
get from Semonto in the plugin settings. You can revoke or change this 
at any time.

== Screenshots ==

1. Plugin settings page
2. Monitor status
3. Load test result

== Changelog ==

#### Version 1.0.1 (Feb 23rd, 2024)
- Initial release

#### Version 1.1.0 (Jul 4th, 2024)
- Improved layout
- Caching of results added
- Disk space test added
- Disk space inode test added
- Memory usage test added

#### Version 1.1.1 (Jul 31th, 2024)
- Adds support for WordPress 6.6
- Prevents crash when saving settings

#### Version 1.1.2 (Oct 17th, 2024)
- Corrects calculation of memory usage percentage
