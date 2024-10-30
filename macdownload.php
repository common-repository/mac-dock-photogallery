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

/* Downloading option for the images */
require_once( dirname(__FILE__) . '/macDirectory.php');

/* Getting the file path */
$site_url = get_bloginfo('url');
$folder = dirname(plugin_basename(__FILE__));

$file = "$site_url/wp-content/plugins/$folder/uploads/".$_GET['albid']."";

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Content-Type: application/force-download");
header( "Content-Disposition: attachment; filename=".basename($file));

header( "Content-Description: File Transfer");
@readfile($file);
?>