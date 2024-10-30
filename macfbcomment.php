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

/* Facebook comment under each photo */
require_once( dirname(__FILE__) . '/macDirectory.php');

global $wpdb;
$pid        = $_REQUEST['pid'];
$phtName    = $_REQUEST['phtName'];
$site_url   = $_REQUEST['site_url'];
$dirPage    = $_REQUEST['folder'];
$returnfbid =$wpdb->get_var("SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_content= '[fbmaccomments]' AND post_status='publish'");
$mac_facebook_comment = $wpdb->get_var("SELECT mac_facebook_comment FROM " . $wpdb->prefix . "macsettings WHERE macSet_id=1");
if($pid != '')
{
        $site_url = $_REQUEST['site_url'];
        $div .= '<div id="fbcomments">
                 <fb:comments canpost="true" candelete="false" numposts="'.$mac_facebook_comment.'"  xid="photo'.'.'.$pid.'"
                     href="'.$site_url.'/?page_id='.$returnfbid.'&macphid='.$pid.'"  title="'.$phtName.'"  publish_feed="true">
                 </fb:comments></div>';
        echo  $div;
}
?>