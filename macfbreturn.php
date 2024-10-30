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

/* Returning page from facebook comments */
class macfb
{
   function fbmacreturn()
   {
     require_once( dirname(__FILE__) . '/macDirectory.php');
     global $wpdb;
        $site_url = get_bloginfo('url');
        $returnfbid =$wpdb->get_var("SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_content= '[fbmaccomments]' AND post_status='publish'"); //Return page id
        $macphid = $_REQUEST['macphid']; // photo id
        $macDis = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "macphotos WHERE  macPhoto_id='$macphid' and macPhoto_status='ON'"); //select photo
        $mafex  = explode('.',$macDis->macPhoto_image);  //getting original image  extension from the thumb image
        $macorgimg = explode('_',$mafex[0]); //getting original image from the thumb image
          
        $div  = '<div id="fb-root"></div>';
        $div .= "<h3>$macDis->macPhoto_name</h3>";
        $div .=  '<img src="'.$site_url.'/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/'.$macorgimg[0].'.'.$mafex[1].'" />';
        $div .= '<div id="facebook" align="center">';
        $div .= '<div id="fbcomments">
                   <fb:comments canpost="true" candelete="false" numposts="10" width="750" xid="photo'.'.'.$macphid.'"
                    href="'.$site_url.'/?page_id='.$returnfbid.'&macphid='.$macphid.'" url="'.$site_url.'/?page_id='.$returnfbid.'&macphid='.$macphid.'"
                    title="'.$macDis->macPhoto_name.'"  publish_feed="true">
                   </fb:comments></div>';
        $div .= '</div>';
        echo $div;
      }
}
?>