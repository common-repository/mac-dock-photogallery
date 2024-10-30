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

/*The Page is for Installing the tables in the Database */
function macGallery_install()
{
  global $wpdb;
    // set tablename settings, albums, photos
    $table_settings		= $wpdb->prefix . 'macsettings';
    $table_macAlbum		= $wpdb->prefix . 'macalbum';
    $table_macPhotos		= $wpdb->prefix . 'macphotos';
   
    $sfound = false;
    $afound = false;
    $pfound = false;
    $found = true;
    foreach ($wpdb->get_results("SHOW TABLES;", ARRAY_N) as $row)
    {
        if ($row[0] == $table_settings) $sfound = true;
        if ($row[0] == $table_macAlbum) $afound = true;
        if ($row[0] == $table_macPhotos) $pfound = true;
    }

    // add charset & collate like wp core
    $charset_collate = '';

    if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
    {
        if ( ! empty($wpdb->charset) )
        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if ( ! empty($wpdb->collate) )
        $charset_collate .= " COLLATE $wpdb->collate";
    }
    
          if (!$sfound)
            {
          $sql = "CREATE TABLE ".$table_settings." (
          `macSet_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `macrow` int(10) NOT NULL,
          `macimg_page` int(10) NOT NULL,
          `summary_macrow` int(5) NOT NULL,
          `summary_page` int(5) NOT NULL,
          `albumRow` bigint(10) NOT NULL,
          `mouseHei` bigint(10) NOT NULL,
          `mouseWid` bigint(10) NOT NULL,
          `resizeHei` bigint(3) NOT NULL,
          `resizeWid` bigint(3) NOT NULL,
          `macProximity` double NOT NULL,
          `macDir` int(10) NOT NULL,
          `macImg_dis` varchar(10) NOT NULL,
          `mac_limit` int(5) NOT NULL,
          `macAlbum_limit` int(11) NOT NULL,
          `mac_albumdisplay` varchar(5) NOT NULL,
          `mac_imgdispstyle` int(11) NOT NULL,
          `mac_facebook_api` varchar(50) NOT NULL,
          `mac_facebook_comment` int(5) NOT NULL
              ) $charset_collate;";
          $res = $wpdb->get_results($sql);
            }

          if (!$afound)
            {
         $sql = "CREATE TABLE ".$table_macAlbum."  (
          `macAlbum_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `macAlbum_name` varchar(100) NOT NULL,
          `macAlbum_description` text NOT NULL,
          `macAlbum_image` varchar(50) NOT NULL,
          `macAlbum_status` varchar(100) NOT NULL,
          `macAlbum_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          ) $charset_collate;";
         $res = $wpdb->get_results($sql);
            }

            if (!$pfound)
            {
        $sql = "CREATE TABLE ".$table_macPhotos." (
          `macPhoto_id` int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `macAlbum_id` int(5) NOT NULL,
          `macAlbum_cover` varchar(10) NOT NULL,
          `macPhoto_name` varchar(50) NOT NULL,
          `macPhoto_desc` text NOT NULL,
          `macPhoto_image` varchar(50) NOT NULL,
          `macPhoto_status` varchar(10) NOT NULL,
          `macPhoto_sorting` int(4) NOT NULL,
          `macPhoto_date` date NOT NULL
           ) $charset_collate;";
         $res = $wpdb->get_results($sql);
            }
        $site_url = get_option('siteurl');  //Getting the site domain path
        // Getting page dynamically for side widgets to display
        $contus_widPage = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts where post_content='[macGallery display]'");
        if (empty($contus_widPage))
            {
            $widPage  =  "INSERT INTO ".$wpdb->prefix."posts(`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`,
                          `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`,
                                   `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
                          VALUES
                         (1, NOW(), NOW(), '[macGallery display]', '', '', 'publish', 'closed', 'open', '', 'macGallery display', '', '', 'NOW()',
                         'NOW()', '','', '$site_url/?page_id=',0, 'page', '', 0)";

                        $resPage       =  $wpdb->get_results($widPage);
                        $widId         =  $lastid = $wpdb->insert_id;
                        $widUpd        =  "UPDATE ".$wpdb->prefix."posts SET guid='$site_url/?page_id=$widId' WHERE ID='$widId'";
                        $widUpdate     =  $wpdb->get_results($widUpd);
           }

           // Getting page dynamically for return from facebook
           $contus_fbPage = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts where post_content='[fbmaccomments]'");
            if (empty($contus_fbPage))
            {
            $widfb    =  "INSERT INTO ".$wpdb->prefix."posts(`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`,
                          `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`,
                                   `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
                          VALUES
                         (1, NOW(), NOW(), '[fbmaccomments]', '', '', 'publish', 'closed', 'open', '', 'fbmaccomments', '', '', 'NOW()',
                         'NOW()', '','', '$site_url/?page_id=',0, 'page', '', 0)";

                        $resfbPage    =  $wpdb->get_results($widfb);
                        $fbmacId      =  $lastid = $wpdb->insert_id;
                        $fbUpd        =  "UPDATE ".$wpdb->prefix."posts SET guid='$site_url/?page_id=$fbmacId' WHERE ID='$fbmacId'";
                        $fbUpdate     =  $wpdb->get_results($fbUpd);
           }



 $page_found  = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts where post_content='[macGallery]'");
 if (empty($page_found)) {
$mac_gallery_page    =  "INSERT INTO ".$wpdb->prefix."posts(`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
        VALUES
                    (1, NOW(), NOW(), '[macGallery]', 'Photos', '', 'publish', 'open', 'open', '', 'mac-gallery', '', '', '2011-01-10 10:42:43',
                    'NOW()', '','', '$site_url/?page_id=',0, 'page', '', 0)";

$res_macpage       =  $wpdb->get_results($mac_gallery_page );
$res_macpage_id    =  $wpdb->get_var("select ID from ".$wpdb->prefix."posts ORDER BY ID DESC LIMIT 0,1");
$upd_macPage       =  "UPDATE ".$wpdb->prefix."posts SET post_parent='$videoId',guid='$site_url/?page_id=$res_macpage_id' WHERE ID='$res_macpage_id'";
$rst_updated       =  $wpdb->get_results($upd_macPage);
 }
}
?>