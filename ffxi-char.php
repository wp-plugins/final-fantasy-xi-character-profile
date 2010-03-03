<?php
/*
Plugin Name: Final Fantasy XI Character Profile
Plugin URI: http://wp.rakhama.com/projects/ffxi-character-profile/
Description: Adds a widget to your WordPress site which displays details of your Final Fantasy XI character.
Author: Phil Watson
Version: 1
Author URI: http://www.rakhama.com
*/

/*  Copyright 2009  Phil Watson  (email : phil@rakhama.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*	
	Character images and nation flags are from FFXIclopedia
	http://wiki.ffxiclopedia.org/
*/

REQUIRE('functions.php');
REQUIRE('edit-dash.php');
REQUIRE('edit-page.php');
REQUIRE('widget.php');

add_action('admin_menu', 'ffxi_char_profile_menu');
add_action('wp_dashboard_setup', 'ffxi_char_profile_dash' );

register_sidebar_widget('Final Fantasy XI Character Profile', 'widget_ffxi_char_profile');

function ffxi_char_profile_menu() {
  add_theme_page("Configure Final Fantasy XI Character Profile", "FFXI Character Profile", "administrator", "?page=ffxi_char_profile_edit_page", "ffxi_char_profile_edit_page"); 
}

function widget_ffxi_char_profile($args) {
    extract($args);
	$charinfo = get_option("ffxi_char_profile");
	echo $before_widget;
		echo $before_title			
			    . stripslashes($charinfo["title"])
                . $after_title;
            show_ffxi_char();
       echo $after_widget;
}

function ffxi_char_profile_dash() {
	wp_add_dashboard_widget('ffxi_char_profile_dash', 'FFXI Character Profile Quick Update', 'ffxi_char_profile_dash_display');	
}
?>