# UM Shortcode Time Viewer
Extension to Ultimate Member for different date and time view formats.

## Shortcode
1. <code>[um_time_view meta_key="" format="" custom=""]Custom text %s with result[/um_time_view]</code>
2. UM meta_key
3. Formats:
4. <code>human</code> Time difference between the meta_key value and current time in human format like: "This user has been with us for 2 years, 5 months and 10 days."
5. <code>wp1</code>  WP Settings -> Date Format
6. <code>wp2</code>  WP Settings -> Time Format 
7. <code>wp3</code>  WP Date plus Time 
8. <code>custom</code> example <code>format="custom" custom="Y/m/d"</code>
9. Custom: PHP Date format see https://www.php.net/manual/en/datetime.format.php

## Shortcode examples
1. Human time difference <code>[um_time_view meta_key="user_registered" format="human"]This user has been with us for %s.[/um_time_view]</code>
2. WordPress date format <code>[um_time_view meta_key="_um_last_login" format="wp1"]Latest login %s[/um_time_view]</code>
3. WordPress time format <code>[um_time_view meta_key="any time" format="wp2"]Time %s[/um_time_view]</code>
4. WordPress date and time format <code>[um_time_view meta_key="_um_last_login" format="wp3"]Latest login %s[/um_time_view]</code>
5. Custom date and time format <code>[um_time_view meta_key="_um_last_login" format="custom" custom="Y/m/d"]Latest login %s[/um_time_view]</code>

## Installation
1. Install by downloading the plugin ZIP file and install as a new Plugin, which you upload in WordPress -> Plugins -> Add New -> Upload Plugin.
2. Activate the Plugin: Ultimate Member - Shortcode Time Viewer
