<?php
/*
Plugin Name: Simple On/Off Switch
Plugin URI: http://mattbuechler.com/portfolio/wordpress-plugins/simple-onoff-switch/
Description: A simple plugin that returns an "On" or "Off" value via a Dashbaord Widget. Values are displayed by the [simpleswitch] shortcode.
Version: 1.2
Author: Matthew Buechler
Author URI: http://mattbuechler.com
License: GPL2
*/

/*  Copyright 2013  Matthew Buechler  (email : matt.buechler@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_option('simpleswitch', 'on');
add_option('simpleswitch_onvalue', 'On Value');
add_option('simpleswitch_offvalue', 'Off Value');

function simpleonoffswitch_form(){ //Function for the On / Off Radio Buttons Form
	?> 
    <form name="sssubmit" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label><input name="simpleswitch" type="radio" value="simpleswitchon" <?php if(get_option('simpleswitch') == "on") { echo 'checked'; } ?>/> On</label>
	<label><input name="simpleswitch" type="radio" value="simpleswitchoff" <?php if(get_option('simpleswitch') == "off") { echo 'checked'; } ?>/> Off</label> &nbsp; 
    <input name="sssubmit" type="submit" value="Save" class="button-primary" /></form>

  <?php
}
function simpleonoffswitch_form_values() { // Function for the Values form
		$ss_onvalueset = get_option('simpleswitch_onvalue');
		$ss_offvalueset = get_option('simpleswitch_offvalue');
	?>
	   <hr />
    <form name="ssvalues" action="<?php echo $_SERVER['PHP_SELF'] ?>?ssvalues_submit" method="post">
    <label>On Value <input name="simpleswitch_onvalue" type="input" value="<?php echo $ss_onvalueset; ?>" size="60" /></label><br />
    <label>Off Value <input name="simpleswitch_offvalue" type="input" value="<?php echo $ss_offvalueset; ?>" size="60" /></label><br />
    <input type="hidden" name="values_submit" value="true" /> 
    <input name="submit" type="submit" value="Save" class="button-primary" />
    </form> 
	<?php
}

function simpleonoffswitch_dashboard_widget_function() { //show the dashboard widget and include the functions
	simpleswitch_set();
	$values_submit = $_POST['values_submit'];
	if(isset($_POST['ssvalues_submit'])); {
	simpleswitch_values_set();
	}
	echo simpleonoffswitch_form();
	echo simpleonoffswitch_form_values();
} 

function simpleswitch_set() { //set the status of the radio buttons on or off
	$switchstatus = $_POST['simpleswitch'];
	if(isset($_POST['sssubmit'])) {
	if($switchstatus == "simpleswitchon") {
		update_option('simpleswitch', 'on'); }
	if($switchstatus == "simpleswitchoff") {
		update_option('simpleswitch', 'off');
		} }
function simpleswitch_values_set() { // set the values
	if(isset($_POST['values_submit'])) {
	$on_value = $_POST['simpleswitch_onvalue'];
	$off_value = $_POST['simpleswitch_offvalue'];
	
	update_option('simpleswitch_onvalue', $on_value);
	update_option('simpleswitch_offvalue', $off_value);
		
}	}
}
function simpleswitch_shortcode() { // display value dependant on status of the switch shortcode
	if(get_option('simpleswitch') == "on") {
		return get_option('simpleswitch_onvalue');
	} 
	if(get_option('simpleswitch') == "off") {
		return get_option('simpleswitch_offvalue');
	}	
}
add_shortcode('simpleswitch', 'simpleswitch_shortcode'); //set the shortcode

// Create the function use in the action hook

function simpleonoffswitch_dashboard_widgets() {
	wp_add_dashboard_widget('simpleonoffswitch_dashboard_widget', 'Simple On/Off Switch', 'simpleonoffswitch_dashboard_widget_function');	
}
// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'simpleonoffswitch_dashboard_widgets' ); 


?>