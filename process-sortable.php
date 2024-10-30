<?php
/*
 ***********************************************************

 * Name:  Mac Photo Gallery
 * Description: Mac Photo Gallery component for Wordpress
 * Version: 1.0
 * Edited By: Saranya
 * Author URI: http://www.contussupport.com/
 * Date :May 19 2011

 **********************************************************

 @Copyright Copyright (C) 2010-2011 Contus Support
 @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,

 **********************************************************/

/* sorting the photos in admin */

require_once( dirname(__FILE__) . '/macDirectory.php'); 
/* This is where you would inject your sql into the database
   but we're just going to format it and send it back
*/
$macPhoto_id = $_REQUEST['macPhoto_id'];
foreach ($_GET['listItem'] as $position => $item) :
	$sql[] =$wpdb->query("UPDATE " . $wpdb->prefix . "macphotos SET `macPhoto_sorting` = '$position'  WHERE `macPhoto_id` = $item");
endforeach;

?>