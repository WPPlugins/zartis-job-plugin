<?php
/*
Plugin Name: HireHive Job Plugin
Plugin URI: http://hirehive.io
Description: (Formerly Zartis ATS) Easily add your own secure jobs and careers page to your WordPress site. Includes full access to professional candidate management and posting to twitter, facebook and free job aggregation sites.
Version: 2.6.1
Author: HireHive
Author URI: http://hirehive.io
Tags: jobs, job, career, manager, vacancy, hiring, hire,listing, social, media, recruiting, recruitment, ats, employer, application, board, hirehive
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
add_action('init', 'HireHive_Setup');

function HireHive_Setup()
{
    // Create the global path
    define('HireHive_Folder', 'zartis-job-plugin');
    if (!defined('Zartis_Url'))
        define('Zartis_Url', WP_PLUGIN_URL . '/' . HireHive_Folder);
    
    // Add jquery core and our css styles
    if (is_admin()) {
        wp_enqueue_style('zartis_wp', Zartis_Url . '/css/zartis_wp.css');
        wp_enqueue_script('zartis_functions', Zartis_Url . '/js/zartis_functions.js');
        
        // The styles for the widget
        wp_enqueue_style('hirehive_wp_widget', Zartis_Url . '/css/hirehive-widget-styles.css');
        wp_enqueue_style('hirehive_wp_fonts', 'https://fonts.googleapis.com/css?family=Roboto:700,500,400italic,300,400');
    }
    else{
        wp_enqueue_style('hirehive_wp_widget', Zartis_Url . '/css/hirehive-widget-styles.css');
    }
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'HireHive_Activate');
/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'HireHive_Deactivate');
/*Runs when the user deletes the plugin */
register_uninstall_hook(__FILE__, 'HireHive_UnInstall');

function HireHive_Activate()
{
    //Stores Company Identifier
    add_option("Zartis_Unique_ID", 'False', '', 'yes');
    //Stores Page ID
    add_option("Zartis_Page_ID", 'False', '', 'yes');
    //Flag to show the message
    add_option("Zartis_Notice", 'False', '', 'yes');
    //Flag to store job grouping
    add_option("Zartis_Group", 1, '', 'yes');
}

function HireHive_Message()
{
    //This calls the Zartis Message when activated
    echo ("<script type='text/javascript'>");
    echo ("HireHive_Message();");
    echo ("</script>");
}

function HireHive_Deactivate()
{
    /*Cleans out everything from the DB */
    global $wpdb;
    $zartis_page_ID = get_option('Zartis_Page_ID');
    
    // Clean up DB fields
    HireHive_CleanUp_DB();
    
    //  the id of our page...
    $page_ID = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE ID = '" . $zartis_page_ID . "'");
    if ($page_ID != 'False') {
        wp_delete_post($page_ID, true);
    }
}

function HireHive_UnInstall()
{
    /*Cleans out everything from the DB */
    HireHive_Deactivate();
}

function HireHive_CleanUp_DB()
{
    // We still have old customers so keep old naming conventions
    delete_option('Zartis_Page_ID');
    delete_option('Zartis_Notice');
    delete_option('Zartis_Unique_ID');
    delete_option('Zartis_Width');
    delete_option('Zartis_Group');
}

if (is_admin()) {
    /* Calls the function to add the HireHive Menu */
    add_action('admin_menu', 'Add_HireHive_Admin_Menu');
    $Zartis_Notice = get_option('Zartis_Notice');
    
    //checks if this is an activation and then displays the zartis message
    if ($Zartis_Notice == "False") {
        add_action('admin_notices', 'HireHive_Message');
        update_option('Zartis_Notice', 'True');
    }
}

function Add_HireHive_Admin_Menu()
{
    //Page Title, Word Shown, Permission, Menu, Slug, Function, icon, pos
    add_menu_page(_('HireHive'), _('HireHive Jobs'), 'administrator', 'Zartis_Menu', 'hirehive_settings', 'https://zartis.blob.core.windows.net/public-icons/wp-menu-icon.png');
}

add_shortcode('zartis_jobs', 'Display_HireHive_Widget');
add_shortcode('hirehive_jobs', 'Display_HireHive_Widget');

function Display_HireHive_Widget( $atts ) {
    $category = '';
    
    if( isset( $atts['category'] ) && $atts['category']) {
        $category = $atts['category'];
    }
    
    $Company_Zartis_ID = get_option('Zartis_Unique_ID');
    
    $Zartis_Group = get_option('Zartis_Group');
    
    if ($Zartis_Group == null){
        $Zartis_Group = 1;
    }
    
    if ($Company_Zartis_ID != "False") {
        try {
            
            if ($category !=null){
                $url = 'https://my.hirehive.io/api/v2/public/search?cname='.$Company_Zartis_ID.'&groupBy='.$Zartis_Group.'&category='.$category;
            }
            else{
                $url = 'https://my.hirehive.io/api/v2/public/search?cname='.$Company_Zartis_ID.'&groupBy='.$Zartis_Group;
            }
            
            $jsondata = file_get_contents($url);
            
            if (strlen($jsondata) == 0){
                throw new Exception('file_get_contents returned nothing');
            }
            
            $groups = json_decode($jsondata, true);
            
            $decodeError = '';
            switch (json_last_error()) {
                
                case JSON_ERROR_NONE:
                    break;
                case JSON_ERROR_DEPTH:
                    $decodeError = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $decodeError = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $decodeError = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $decodeError = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $decodeError = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $decodeError = 'Unknown error';
                    break;
        }
        
        if (strlen($decodeError) > 0) {
            $emailBody = "JSON Decode failed: " .$Company_Zartis_ID;
            $emailBody .= '<p>Current PHP version: ' . phpversion(). '</p>';
            $emailBody .= '<p>Grouping: ' .$Zartis_Group. '</p>';
            $emailBody .= '<p>API URL: ' .$url. '</p>';
            $emailBody .= '<p>Site: ' .$_SERVER["HTTP_HOST"]. '</p>';
            $emailBody .= '<br><br>';
            $emailBody .= '<pre>' .print_r($decodeError, 1). '</pre>';
            
            $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
            error_log($emailBody, 1, 'dev@hirehive.io', $headers);
            
            throw new Exception('JSON version failed, fallback to JS widget');
        }
        
        $jobTemplate = '<a class="hh-list-row" href="{{Link}}"><span class="hh-list-title">{{Title}}</span> <span class="hh-list-location">{{Location}}, {{StateCode}}{{Country}}</span> <span class="hh-list-type">{{Type}}</span></a>';
        
        $jobsHTML = "<div id='jobs_iframe' class='hh-list'>";
        $jobsHTML .= '<!-- Jobs for - ' .$Company_Zartis_ID. ' -->';
        $jobsHTML .= '<!-- Chosen group - ' .$Zartis_Group. ' -->';
        $jobsHTML .= '<!-- Category - ' .$category. ' -->';
        $jobsHTML .= '<!-- Version - 2.6.1 -->';
        $jobsHTML .= '<!-- Styles inlined -->';
        $jobsHTML .= '<link rel="stylesheet" href="' . plugins_url('/css/hirehive-widget-styles.css', __FILE__). '" type="text/css" />';        
        
        foreach ($groups as $group) {
            if ($Zartis_Group > 1){
                if (strlen($group["name"]) > 0){
                    $jobsHTML .= '<h3 class="hh-list-cat">'.$group["name"].'</h3>';
                }
            }
            
            if ($category !=null){
                $jobsHTML .= Compile_Job_Template($jobTemplate, $group);
            }
            else{
                foreach ($group["jobs"] as $job) {
                    $jobsHTML .= Compile_Job_Template($jobTemplate, $job);
                }
            }
        }
        
        $jobsHTML .= "</div>";
        
        return $jobsHTML;
    }
    catch (Exception $e) {
        // If we have an exception using the API to get the jobs then we fallback to the old JS Version
        $script = '<script type="text/javascript"src="https://my.hirehive.io/' . $Company_Zartis_ID . '/getwidget"></script><script type="text/javascript"charset="utf-8">function getParam(name){name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(window.location.href);if(results==null)return"";else return results[1];}function updateIFrame(height){var iframe=document.getElementById("jobs_iframe");iframe.setAttribute("height",height);}var height=getParam("height");if(height==""){var zartis_options={};zartis_options.display="iframe";zartis_options.company="' . $Company_Zartis_ID . '";zartis_options.placement="left";zartis_options.type="widget";zartis_options.color="#222";zartis_options.width="' . $Zartis_Width . '%";zartis_options.style="idea";zartis_options.url=document.URL;var zartis_widget=new ZARTIS.jobs_widget(zartis_options);}else{window.top.updateIFrame(height);}</script>';
        
        $script .= '<!-- Jobs for - ' .$Company_Zartis_ID. ' -->';
        $script .= '<!-- Chosen group - ' .$Zartis_Group. ' -->';
        $script .= '<!-- Category - ' .$category. ' -->';
        $script .= '<!-- Version - 2.6.1 -->';
        $script .= '<!--' .$e.message. '-->';
        
        return $script;
    }
    
} else {
    return false;
}
}

function Compile_Job_Template($template, &$job){
    
    $template = str_replace("{{Title}}",$job["title"],$template);
    $template = str_replace("{{Link}}",$job["jobUrl"],$template);
    $template = str_replace("{{Location}}",$job["location"],$template);
    $template = str_replace("{{Country}}",$job["countryName"],$template);
    $template = str_replace("{{Type}}",$job["type"],$template);
    
    if (strlen($job["stateCode"]) > 0){
        $template = str_replace("{{StateCode}}", $job["stateCode"].", " ,$template);
    }
    else {
        $template = str_replace("{{StateCode}}", "" ,$template);
    }
    
    return $template;
}

function hirehive_settings()
{
    //checks if there is a UrlIdentifier already in the DB
    $Zartis_ID = get_option('Zartis_Unique_ID');
    if ($Zartis_ID != "False") {
        //Shows my.zartis.com
        has_hirehive_account();
    } else {
        //Gets the user to Register/Login
        no_hirehive_account();
    }
}

function has_hirehive_account()
{
    $Company_Zartis_ID = get_option('Zartis_Unique_ID');
    $Token             = substr($Company_Zartis_ID, -20);
    if (substr_count($Token, "-") == 4) {
        $Company_Zartis_ID_REVERSE = strrev($Company_Zartis_ID);
        $Company_Zartis_ID_REVERSE = substr($Company_Zartis_ID_REVERSE, 20);
        $Company_Zartis_ID         = strtolower(strrev($Company_Zartis_ID_REVERSE));
        update_option('Zartis_Unique_ID', $Company_Zartis_ID);
    }
    include("Zartis_Job_Landing.php");
}

function no_hirehive_account()
{
    //User login/Register Form
    include("Zartis_Job_Token.php");
}

?>