<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Mailbox
  Description: Communicate with your Customers through webmail inside RISE CRM.
  Version: 1.3.2
  Requires at least: 3.7
  Author: ClassicCompiler
  Author URL: https://codecanyon.net/user/classiccompiler
 */

use App\Controllers\Security_Controller;

//add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
    $instance = new Security_Controller();
    $allowed_mailboxes_ids = get_allowed_mailboxes_ids();

    if ($allowed_mailboxes_ids) {
        $active_mailbox = get_mailbox_setting("user_" . $instance->login_user->id . "_active_mailbox");
        $active_mailbox = in_array($active_mailbox, $allowed_mailboxes_ids) ? $active_mailbox : ""; //don't add previously permitted mailbox if it doesn't have access now

        $sidebar_menu["mailbox"] = array(
            "name" => "mailbox",
            "url" => "mailbox" . ($active_mailbox ? "/$active_mailbox" : ""),
            "class" => "inbox",
            "position" => 6,
            "badge" => mailbox_count_unread_emails(),
            "badge_class" => "bg-primary"
        );
    }

    return $sidebar_menu;
});

//add admin setting menu item
app_hooks()->add_filter('app_filter_admin_settings_menu', function ($settings_menu) {
    $settings_menu["plugins"][] = array("name" => "mailbox", "url" => "mailbox_settings");
    return $settings_menu;
});

//add ajax-tab to the client/lead profile
app_hooks()->add_filter('app_filter_client_details_ajax_tab', 'mailbox_details_view_ajax_tab');
app_hooks()->add_filter('app_filter_lead_details_ajax_tab', 'mailbox_details_view_ajax_tab');

if (!function_exists('mailbox_details_view_ajax_tab')) {

    function mailbox_details_view_ajax_tab($hook_tabs, $client_id = 0) {
        if (!$client_id) {
            return $hook_tabs;
        }

        if (get_allowed_mailboxes_ids()) {
            $hook_tabs[] = array(
                "title" => app_lang('mailbox'),
                "url" => get_uri("mailbox/clientEmails/$client_id"),
                "target" => "tab-mailbox_client_emails"
            );
        }

        return $hook_tabs;
    }

}

//install dependencies
register_installation_hook("Mailbox", function ($item_purchase_code) {
    include PLUGINPATH . "Mailbox/install/do_install.php";
});

//add setting link to the plugin setting
app_hooks()->add_filter('app_filter_action_links_of_Mailbox', function ($action_links_array) {
    $action_links_array = array(anchor(get_uri("mailbox_settings"), app_lang("settings")));

    if (get_allowed_mailboxes_ids()) {
        $action_links_array[] = anchor(get_uri("mailbox"), app_lang("inbox"));
    }

    return $action_links_array;
});

//update plugin
use Mailbox\Controllers\Mailbox_Updates;

register_update_hook("Mailbox", function () {
    $update = new Mailbox_Updates();
    return $update->index();
});

//uninstallation: remove data from database
register_uninstallation_hook("Mailbox", function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "mailbox_settings`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "mailbox_emails`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "mailbox_templates`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "mailboxes`;";
    $db->query($sql_query);
});
