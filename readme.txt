=== Climbing Cardboard === 
Plugin Name: Climbing Cardboard
Plugin URI: https://github.com/rlabrovi/climbing-card 
Tags: sport, climbing, routes, logbook, stats
Author: Roko Labrovic
Author URI: https://github.com/rlabrovi
Contributors: gardelin
Current version: 1.0.9
Stable tag: 1.0.9
Requires at least: 6.1.1
Tested up to: 6.1.1
Requires PHP: 7.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Wordpress plugin which let registered users create climbing card/logbook.

== Description ==
The ideal plugin for rock climbing lovers which allows registered users to create and add climbed routes to own climbing card/logbook. Also, the plugin calculates statistics for every user individually and all users too.

= Wiki =
You can find [Wiki](https://github.com/rlabrovi/climbing-card/wiki)

= Shortcodes =
[last_climbed_routes number="10" show-route-in-header="0|1" show-date-in-header="0|1"]
[stats_counter]
[top_users_by_number_of_climbed_routes number="10"]
[stats]

= Privacy notices =
This plugin does not:

* track users by stealth;
* write any user personal data to the database;
* send any data to external servers;
* use cookies.

= Translations =
Currently only English and Croatian language are supported.

== Installation ==
Installing the plugin is easy. Just follow these steps:

1. From the dashboard of your site, navigate to Plugins –> Add New.
2. Select the Upload option and hit “Choose File.”
3. When the popup appears select the climbing-card.zip file from your computer. (For example: climbing-card-v1.0.7.zip).
4. Follow the on-screen instructions and wait as the upload completes.
5. When it’s finished, activate the plugin via the prompt. A message will show confirming activation was successful. And you will redirect to the Welcome page.

Installation is complete! You will find **Climbing Card** menu in your WordPress admin screen.

== Frequently Asked Questions == 

= Does it work with any WordPress theme? =

Yes, it will work with any standard WordPress theme.

= Is this plugin for free? =

This plugin is for free and licensed to GPL. It's open source following the GPL policy.

== Screenshots ==
1. Plugin "Climbing Cardboard" page template
2. Plugin dashboard screen
3. Plugin statistics screen
4. Plugin settings screen

== Changelog ==

= 1.0.9 - November 25 2022 =
* Removing users that have 'is_climbing_card_public' set to false from shortcodes calculations
* Fixing bug with not able to more than one route without reloading page
* Adding adminer in docker-compose
* Readme update
* Dockerization
* Adding Pie chart to Admin > Statistics screen
* Requires at least wordpress 6.1

= 1.0.8 - November 25 2022 =
* Creating Admin screen to manage all DB entries in wp_climbing_cards table, data pagination
* Creating api route /users/me to get data about current user (to get roles)
* Adding getPaginatedFilteredData so it can be used to paginate api requests
* Adding is_administrator helper function
* Adding not allowed page for some routes
* Installing illuminate/paginator:8.0.0 to paginate cards api responses
* Cards search improvement
* Changing DELETE and UPDATE to POST because of web hosting disable DELETE and PUT
* Fixing boolean value for user metadata
* Removing local skeletons and using vue-spinner for loading animation.
* Renaming views folder to pages.
* Moving all api calls to vuex
* Breaking store into modules

= 1.0.7 - September 8 2022 =
* Removing Controller class (no need it for now) and abort method in ApiController class
* Fixing echo left overs
* Update README.md

= 1.0.6 - September 6 2022 =
* Sanitize and validate first and last name fields in registration form
* Allow only one page with template "Climbing Cards"
* Adding svg log
* Escaping echoed data in views
* Adding link to user cartboard in top-users-by-number-of-climbed-routes shortcode

= 1.0.5 - August 30 2022 =
* fixed graph render on "Climbing Card" page template
* Adding LICENCE.md
* Adding readme.txt
* Translation update

 == Upgrade Notice ==
