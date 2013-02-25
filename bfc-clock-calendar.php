<?php
/*
	Plugin Name: Bfcshop Wordpress Clock Calendar
	Plugin URI: http://www.spletne-kode.si/bfcshop-wordpress-clock-calendar.rar
	Description: Bfcshop Wordpress Clock Calendar for WordPress
	Version: 1.0
	Author: Saso Pogorelc
	Author URI: 
	Copyright 2012, bfcshop d.o.o.
*/

// check for WP context

if ( !defined('ABSPATH') ){ die(); }

//set install options

function bfc_clock_calendar_install () {
	$newoptionsclockcountdown = get_option('bfcclockcalendar_options');
	$newoptionsclockcountdown['numberMargin'] = '0';
	$newoptionsclockcountdown['scaleSize'] = '1';		
	$newoptionsclockcountdown['ContainerX'] = '0';	
	$newoptionsclockcountdown['ContainerY'] = '0';	
	$newoptionsclockcountdown['positionY'] = '65';			
	$newoptionsclockcountdown['reflection'] = '1';
	$newoptionsclockcountdown['width'] = '250';
	$newoptionsclockcountdown['height'] = '100';	
	$newoptionsclockcountdown['imageBackground'] = 'true';	
	$newoptionsclockcountdown['dateShown'] = 'true';	
	add_option('bfcclockcalendar_options', $newoptionsclockcountdown);

}


// add the admin page

function bfc_clock_calendar_add_pages() {
	add_options_page('Bfcshop Wordpress Clock Calendar', 'Bfcshop Wordpress Clock Calendar', 8, __FILE__, 'bfc_clock_calendar_options');
}



/*if (isset($_GET['page']) && $_GET['page'] == 'bfcshop-wordpress-clock-calendar/bfc-clock-calendar.php'){
	wp_enqueue_script('jquery');
	wp_register_script('drag', plugins_url("bfcshop-wordpress-clock-calendar/jquery-ui-1.7.1.custom.min.js"), array('jquery','media-upload','thickbox'));
	wp_enqueue_script('drag');		
	wp_register_script('my-upload', plugins_url("bfcshop-wordpress-clock-calendar/script.js"), array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
	wp_enqueue_style('thickbox');
	wp_register_style('myStyleSheets', plugins_url("bfcshop-wordpress-clock-calendar/style.css"));
    wp_enqueue_style( 'myStyleSheets');
}
*/


function bfc_clock_calendar_xmlURLpath($file){

	//path for xml file
	$blogUrl  = explode('/', get_bloginfo('home'));
	$urlServer = str_replace($blogUrl[3],"",$_SERVER['DOCUMENT_ROOT']);
	$urlPlugin = str_replace("http://".$blogUrl[2],"", plugins_url('bfcshop-wordpress-clock-calendar/'));
	$url = $urlServer.$urlPlugin.$file;
	return $url;

}







function widgetbfcclockcalendar($wNumber, $name, $customOption, $positionX , $positionY ,$width , $height){

	//$flashtag .= '';

	$mainoptions = get_option('bfcclockcalendar_options');

	if($customOption == '1')

		$xmlpath  = plugins_url("bfcshop-wordpress-clock-calendar/xml_option_".$wNumber.".xml");

		$positionXN = $positionX;

		$positionYN = $positionY;			

	if($customOption == '0'){

		$xmlpath  = plugins_url("bfcshop-wordpress-clock-calendar/xml_option_".$wNumber.".xml");

		$positionXN = $mainoptions['ContainerX'];

		$positionYN = $mainoptions['ContainerY'];		

		}


	$widthIn = (int)$width;

	$heightIn = $widthIn ;

	$aut_url = 'http://www.bfcshop.com';	

	$flashtag = '<div style = "position:relative; width:'.$widthIn.'px; height:'.$heightIn.'px; margin-left:'.$positionXN.'px; margin-top:'.$positionYN.'px; text-align:center;"><script type="text/javascript" src="'.plugins_url("bfcshop-wordpress-clock-calendar/swfobject/swfobject.js").'" charset="utf-8"></script><script type="text/javascript" src="'.plugins_url("bfcshop-wordpress-clock-calendar/swfobject/swfaddress.js").'" charset="utf-8"></script><script type="text/javascript">

								var clockcalenarvars = {

								xmlPath:          "'.$xmlpath.'",	

								cssPath:          "'.plugins_url("bfcshop-wordpress-clock-calendar/css/style.css").'",

								fontPath:          "'.plugins_url("bfcshop-wordpress-clock-calendar/fonts/Font.swf").'"};			

								var params = {};

								var attributes = {};

								params.wmode = "transparent";

								swfobject.embedSWF("'.plugins_url("bfcshop-wordpress-clock-calendar/counter_v2_reflect_noMask.swf").'", "'.$name.'-'.$wNumber.'", "'.$widthIn.'px", "'.$heightIn.'px", "9.0.0", "'.plugins_url("bfcshop-wordpress-clock-calendar/swfobject/expressInstall.swf").'", clockcalenarvars, params, attributes);

							</script>

							<div id="'.$name.'-'.$wNumber.'"></div>

                                          <p>Powered By: <a href="'.$aut_url.'" target="_blank">Spletna trgovina</a></p>

							</div>';

							

	return	$flashtag;						

}

	

function XMLbfcclockcalendar($wNumber,$scalesize,$containerx ,$containery  ,$numbermargin ,$reflection , $imagebackground , $dateshow){

		$xml = '';

		$xml .= "<?xml version='1.0' encoding='utf-8'?>";

		$xml .= "<?xml-stylesheet type='text/css' href='text.css'?>";

		$xml .=  "<menu ";

		$xml .= " scaleSize = '1'

			ContainerX= '".$containerx ."'

			ContainerY = '".$containery ."'

			numberMargin = '0'

			reflection = '".$reflection ."'	

			reflectionAlpha = '60' 

			reflectionDistance = '0' 

			reflectionRatio = '250'

			imageBackground = '".$imagebackground ."'

			dateShown = '".$dateshow."'>";

		$xml .=  "</menu>";

		

		$file =  bfc_clock_calendar_xmlURLpath("xml_option_".$wNumber.".xml");

		$fh = fopen($file, 'w');

		fwrite($fh, $xml);

		fclose($fh);



}

// create banner widget

function bfc_clock_calendar_createflashcode( $widget=false, $wNumber, $height, $width, $addSettings ,$scalesize ,$containerx ){

	$mainoptions = get_option('bfcclockcalendar_options');

	// write flash 

	if($addSettings == '0'){

	$flashtag = widgetclockcountdown($wNumber, 'clock', $addSettings, $mainoptions['ContainerX'], $mainoptions['ContainerY'] , $width, $height );	

	}

	if($addSettings == '1'){

	$flashtag = widgetbfcclockcalendar($wNumber, 'clock', $addSettings, $containerx , $containery  , $width, $height );	

	}

	

	return $flashtag;

}





//shortcode function

function bfc_clock_calendar_short($atts){

// use [bfcshop-wordpress-clock-calendar id=1 width=300 height=300] 

//      id must be unique value

//      width and height without px only number

	$mainoptions = get_option('bfcclockcalendar_options');

	extract(shortcode_atts(array(

	'id' => 1,

	'height' => $mainoptions['height'],

	'width' => $mainoptions['width'],

	'scalesize' => 1,

	'containerx' => $mainoptions['ContainerX'],

	'containery' => $mainoptions['ContainerY'],

	'custom_widget' => '0',

	'numbermargin' => 0,

	'reflection' => $mainoptions['reflection'],

	'imagebackground' => $mainoptions['imagebackground'],

	'dateshow' =>  $mainoptions['dateshow'],	

	), $atts));

	if($custom_widget == '0'){

		XMLbfcclockcalendar($id, $scalesize, $containerx , $containery  , $numbermargin , $reflection, $minute,$imagebackground,$dateshow);

		$flashtagShort = widgetbfcclockcalendar($id, 'clockcountdownShort', $custom_widget, $containerx, $containery , $width, $height );	

	}

	if($custom_widget == '1'){

		XMLbfcclockcalendar($id, $scalesize, $containerx ,$containery  ,$numbermargin ,$reflection, $imagebackground,$dateshow);

		$flashtagShort = widgetbfcclockcalendar($id, 'clockcountdownShort', $custom_widget, $containerx , $containery  , $width, $height );	

	}



							

return $flashtagShort;

}







function bfc_clock_calendar_options() {	

	$optionsclockcountdown = $newoptionsclockcountdown = get_option('bfcclockcalendar_options');

	// if submitted, process results

	if (!empty($_POST['wpclockcountdown_submit']))  {

		$newoptionsclockcountdown['ContainerX'] = strip_tags(stripslashes($_POST["ContainerX"]));

		$newoptionsclockcountdown['ContainerY'] = strip_tags(stripslashes($_POST["ContainerY"]));

		$newoptionsclockcountdown['imagebackground'] = strip_tags(stripslashes($_POST["imagebackground"]));		

		$newoptionsclockcountdown['reflection'] = strip_tags(stripslashes($_POST["reflection"]));	

		$newoptionsclockcountdown['dateshow'] = strip_tags(stripslashes($_POST["dateshow"]));	



	// if changes save!

	if ( $optionsclockcountdown != $newoptionsclockcountdown ) {

		$optionsclockcountdown = $newoptionsclockcountdown;

		update_option('bfcclockcalendar_options', $optionsclockcountdown);

	}		

	}

	

?>

	<div class="allBanner">

	<div class = "buttons">

	<div class= "settingsB" id = "settingsB"><a href="" onClick="return false;">Settings</a></div>

	<div class = "helpB" id = "helpB"><a href="" onClick="return false;">Help</a></div>	

	</div>

	<input type="hidden" id="path" value="<?php echo plugins_url('bfcshop-wordpress-clock-calendar/')?>">

<?php





	

?> 



	

	<div id="settings"><?php

	// options form

	echo '<form name="settings" method="post">';

	echo "<div class=\"wrap\"><h2>Count Down Settings</h2>";

	echo '<table class="form-table">';

	// ContainerX

	echo '<tr valign="top"><th scope="row">X Position</th>';

	echo '<td><input type="text" name="ContainerX" value="'.$optionsclockcountdown['ContainerX'].'" size="5"></input><br />Position of bfc-clock-calendar on X axis.</td></tr>';

	// ContainerY

	echo '<tr valign="top"><th scope="row">Y Position</th>';

	echo '<td><input type="text" name="ContainerY" value="'.$optionsclockcountdown['ContainerY'].'" size="5"></input><br />Position of bfc-clock-calendar on Y axis.</td></tr>';	

	//reflection

	echo '<tr valign="top"><th scope="row">Reflection</th>';	

	echo '<td><input type="radio" name="reflection" value="true"';

	if( $optionsclockcountdown['reflection'] == 'true' ){ echo ' checked="checked" '; }

	echo '></input> True (if you select true reflection will be visible)<br /><input type="radio" name="reflection" value="false"';

	if( $optionsclockcountdown['reflection'] == 'false' ){ echo ' checked="checked" '; }

	echo '></input> False (if you select false reflection will not be visible)<br /></td></tr>';

	echo '<tr valign="top"><th scope="row">Use Background Image</th>';	

	echo '<td><input type="radio" name="imagebackground" value="true"';

	if( $optionsclockcountdown['imagebackground'] == 'true' ){ echo ' checked="checked" '; }

	echo '></input> True (if you select true default background image will be visible)<br /><input type="radio" name="imagebackground" value="false"';

	if( $optionsclockcountdown['imagebackground'] == 'false' ){ echo ' checked="checked" '; }

	echo '></input> False (if you select false default background image will be disabled and background will be transparent)<br /></td></tr>';	

	echo '<tr valign="top"><th scope="row">Show Date</th>';	

	echo '<td><input type="radio" name="dateshow" value="true"';

	if( $optionsclockcountdown['dateshow'] == 'true' ){ echo ' checked="checked" '; }

	echo '></input> True (if you select true date will be visible)<br /><input type="radio" name="dateshow" value="false"';

	if( $optionsclockcountdown['dateshow'] == 'false' ){ echo ' checked="checked" '; }

	echo '></input> False (if you select false date will be disabled )<br /></td></tr>';	

	echo '</table>';

	echo '<input type="hidden" name="wpclockcountdown_submit" value="true"></input>';

	echo '<p class="submit"><input type="submit" value="Update settings &raquo;"></input></p>';

	echo "</div>";

	echo "</div>";

	echo '</form>';

	echo "</div>";

	}



	

//uninstall all options

function bfc_clock_calendar_uninstall () {

	delete_option('bfcclockcalendar_options');

}





add_action('init', 'widget_bfc_clock_calendar_register');



function widget_bfc_clock_calendar_register() {

 

	$prefix = 'bfc-clock-calendar'; // $id prefix

	$name = __('Bfcshop Wordpress Clock Calendar');

	$widget_ops = array('classname' => 'widget_bfc_clock_calendar_count', 'description' => __('Wordpress Clock Calendar'));

	$control_ops = array('width' => 400, 'height' => 200, 'id_base' => $prefix);

 

	$options = get_option('widget_bfc_clock_calendar_count');

	if(isset($options[0])) unset($options[0]);

 

	if(!empty($options)){

		foreach(array_keys($options) as $widget_number){

			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_bfc_clock_calendar_count', $widget_ops, array( 'number' => $widget_number ));

			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'widget_bfc_clock_calendar_control', $control_ops, array( 'number' => $widget_number ));

		}

	} else{

		$options = array();

		$widget_number = 1;

		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_bfc_clock_calendar_count', $widget_ops, array( 'number' => $widget_number ));

		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'widget_bfc_clock_calendar_control', $control_ops, array( 'number' => $widget_number ));

	}

}





function widget_bfc_clock_calendar_count($args, $vars = array()) {

	extract($args);

	// get widget saved options

	$widget_number = (int)str_replace('bfc-clock-calendar-', '', @$widget_id);

	$options = get_option('widget_bfc_clock_calendar_count');

	if(!empty($options[$widget_number])){

		$vars = $options[$widget_number];

	}

	// widget open tags

	echo $before_widget;

 

	// print title from admin 

	if(!empty($vars['title'])){

		echo $before_title . $vars['title'] . $after_title;

	} 

	if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){

		echo bfc_clock_calendar_createflashcode(true,$vars['id'],$vars['height'],$vars['width'],$vars['addSettings'] ,$vars['scalesize'], $vars['containerx'] ,$vars['containery'] );



		}

	echo $after_widget;

	



}





function widget_bfc_clock_calendar_control($args) {

	

	$prefix = 'bfc-clock-calendar'; // $id prefix

 

	$options = get_option('widget_bfc_clock_calendar_count');

	if(empty($options)) $options = array();

	if(isset($options[0])) unset($options[0]);

 

	// update options array

	if(!empty($_POST[$prefix]) && is_array($_POST)){

		foreach($_POST[$prefix] as $widget_number => $values){

			if(empty($values) && isset($options[$widget_number])) // user clicked cancel

				continue;

 

			if(!isset($options[$widget_number]) && $args['number'] == -1){

				$args['number'] = $widget_number;

				$options['last_number'] = $widget_number;

			}

			$options[$widget_number] = $values;



		}

 

		// update number

		if($args['number'] == -1 && !empty($options['last_number'])){

			$args['number'] = $options['last_number'];

		}

 

		// clear unused options and update options in DB. return actual options array

		$options = bf_smart_multiwidget_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_bfc_clock_calendar_count');

	}

 

	// $number - is dynamic number for multi widget, gived by WP

	// by default $number = -1 (if no widgets activated). In this case we should use %i% for inputs

	//   to allow WP generate number automatically

	

	$number = ($args['number'] == -1)? '%i%' : $args['number'];

	

	// now we can output control

	$opts = @$options[$number];

 

	$title = @$opts['title'];

	$id = @$opts['id'];

	$addSettings = @$opts['addSettings'];

	$containerx = @$opts['containerx'];

	$containery = @$opts['containery'];

	$numbermargin = @$opts['numbermargin'];

	$reflection = @$opts['reflection'];

	$height = @$opts['height'];

	$width = @$opts['width'];

	$scalesize = @$opts['scalesize'];

	$imagebackground = @$opts['imagebackground'];

	$dateshow = @$opts['dateshow'];

	

	$mainoptions = get_option('bfcclockcalendar_options');

	// write flash 

	if($addSettings == '0'){	

		XMLbfcclockcalendar($id, $mainoptions['scaleSize'], $mainoptions['ContainerX'] , $mainoptions['ContainerY']  , $mainoptions['numberMargin'] , $mainoptions['reflection'] , $imagebackground,$mainoptions['dateshow']);

	}

	if($addSettings == '1'){	

		XMLbfcclockcalendar($id, $scalesize, $containerx ,$containery  ,$numbermargin ,$reflection, $imagebackground,$dateshow );

	}

			



	?>

	<table class="form-table"><tr valign="top"><tr><td>
	Clock Calendar Title
    <input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][title]" value="<?php echo $title; ?>" /><br/></td>

	<td><input type="hidden" name="<?php echo $prefix; ?>[<?php echo $number; ?>][id]" value="<?php echo $id; ?>" /><br/></td></tr>

    <?php

	// width

	echo '<tr valign="top"><td scope="row">Enter Clock Width<br/>';

	echo '<input type="text" name="'. $prefix.'['. $number .'][width]" value="'.$width.'" size="5"></input><br /></td>';
	
	echo '<td><input type="radio" name="'. $prefix.'['. $number .'][addSettings]" id="addSettings" value="1"';
	if( $addSettings == '1' ){ echo ' checked="checked" '; }
	echo 'onclick="document.getElementById(\'customSettings\').style.display = \'\'"> True<br /><input type="radio" name="'. $prefix.'['. $number .'][addSettings]" id="addSettings" value="0"';
	if( $addSettings == '0' ){ echo ' checked="checked" '; }
	echo 'onclick="document.getElementById(\'customSettings\').style.display = \'none\'"> False<br /></td>';
	
	echo '</tr></table>';




}


// helper function can be defined in another plugin

if(!function_exists('bf_smart_multiwidget_update')){

	function bf_smart_multiwidget_update($id_prefix, $options, $post, $sidebar, $option_name = ''){

		global $wp_registered_widgets;

		static $updated = false;

 

		// get active sidebar

		$sidebars_widgets = wp_get_sidebars_widgets();

		if ( isset($sidebars_widgets[$sidebar]) )

			$this_sidebar =& $sidebars_widgets[$sidebar];

		else

			$this_sidebar = array();

 

		// search unused options

		foreach ( $this_sidebar as $_widget_id ) {

			if(preg_match('/'.$id_prefix.'-([0-9]+)/i', $_widget_id, $match)){

				$widget_number = $match[1];

 

				// $_POST['widget-id'] contain current widgets set for current sidebar

				// $this_sidebar is not updated yet, so we can determine which was deleted

				if(!in_array($match[0], $_POST['widget-id'])){

					unset($options[$widget_number]);

				}

			}

		}

 

		// update database

		if(!empty($option_name)){

			update_option($option_name, $options);

			$updated = true;

		}

 

		// return updated array

		return $options;

	}

}





// add the actions

//add_action('admin_menu', 'bfc_clock_calendar_add_pages');

register_activation_hook( __FILE__, 'bfc_clock_calendar_install' );

register_deactivation_hook( __FILE__, 'bfc_clock_calendar_uninstall' );

add_shortcode('bfc-clock-calendar', 'bfc_clock_calendar_short');

?>