=== Plugin Name ===
Contributors: sgrayban
Donate link: https://www.paypal.me/SGrayban
Tags: ESN, ESBN, electronic serial numbers, numly
Requires at least: 3.0
Tested up to: 4.4
Stable tag: 2.6

The plugin registers your copyright with Numly and returns the Numly Number (ESN), barcode,
and verification links to your blog post automatically.

== Description ==
numly Numbers was born from a very old plugin called wp-numly which was originally called wp-esbn that was
coded by Cal Evans. But over the years his plugin stopped working and he no longer worked on it. I took the
old plugin and chopped out what wasn’t needed and fixed what was broken which gave birth to numly Numbers.

Electronic Standard Number (numly) is the unique identifier of electronic content and media. numlys are
recognized worldwide by electronic publishing companies and electronic content providers. They serve as branded
identifier or copyright for individuals or companies developing electronic content and media. numlys are
assigned and managed by <a href="http://www.numly.com">numly.com</a>.

The plugin registers your copyright with Numly and returns the Numly Number (electronic serial number), barcode,
and verification links to your blog post automatically.

I hope you enjoy numly numbers as much as I do.

<strong>*** NOTE ***</strong> You must have a active subscription at <a href="http://www.numly.com">numly.com</a> for this addon to work.

If you like this plugin please <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NAL594NVVW8AU">donate</a>.

Visit our Firefox <a href="http://home.savannah.borgnet.us/numly/">addon</a> for numly Numbers.

== Installation ==

1. Copy the entire folder numly-numbers/ into wp-content/plugins/ folder on your blog.
1. Activate the plugin by going to your blog's Plugin tab and clicking Activate.
1. Then go to the Settings menu and you'll see numly numbers listed. Enter your numly username,
   chose the license you want to use, and whether you want to show the barcode or not.
1. Some where in the post loop such as in the single.php page paste the following where you want it
to show `<?php if (function_exists('numly_output')) _e('<strong>ESN Copyright:</strong>'); numly_output($id); ?>`

== Frequently Asked Questions ==

= I found a bug, have a question or the plugin doesn't work anymore. What should I do ? =

Go <a href="http://wordpress.org/tags/numly-numbers?forum_id=10">here</a> to report it.

= Will this plugin generate a ESN for pages. =

No. You will have manually create a number at numly.com or install the <a href="http://home.savannah.borgnet.us/numly/">FF addon</a> and add that number to the Custom Field "numly_key" for the page.

== Screenshots ==

1. Screen shot of numly.
2. Screen shot of the settings page.

== Changelog ==

= 2.5 =
* Upped the version to support WP 3.3

= 2.4 =
* Upped the version to support WP 3.2.1
* New pot file

= 2.3 =
* Upped the CC versions from 2.5 to 3.0
* Better licensing code - PD license displays correctly now

= 2.2.1 =
* Changed abbr ESBN to ESN in the install section and description due to Copyright issues

= 2.2 =
* added bug reporting link under the settings section

= 2.1 =
* new URI's
* added screen shot

= 2.0 =
* Code re-write to support wp 3.x

= 1.0 =
* original code by - Cal Evans

== Upgrade Notice ==

= 2.1 =
Remove the old 2.0 numly plugin if you still have it and install this version.

= 2.0 =
Remove the old wp-numly plugin if you still have it and upload this version.
