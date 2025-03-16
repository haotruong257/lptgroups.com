<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
    Plugin Name: Rating
    Description: It's a rating plugin.
    Version: 1.0
    Requires at least: 3.0
    Author:Hao Truong
    Author URL: https://author_url.demo
 */

// Add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
        $sidebar_menu["rating"] = array(
                "name" => "Rating",
                "url" => "rating",
                "class" => "hash",
                "position" => 3,
        );

        return $sidebar_menu;
});

// Add admin setting menu item
app_hooks()->add_filter('app_filter_admin_settings_menu', function ($sidebar_menu) {
        $sidebar_menu["plugins"][] = array("name" => "demo", "url" => "demo_settings");
        return $sidebar_menu;
});


// Add setting link to the plugin setting
app_hooks()->add_filter('app_filter_action_links_of_Demo', function () {
        $action_links_array = array(
                anchor(get_uri("rating"), "Rating"),
                anchor(get_uri("rating_settings"), "Rating settings"),
        );

        return $action_links_array;
});


register_installation_hook("Rating", function () {
      
        $installFile = __DIR__ . '/install.php';
        if (file_exists($installFile)) {
                require_once $installFile;
        }
});

register_uninstallation_hook("Rating", function () {
        $uninstallFile = __DIR__ . '/uninstall.php';
        if (file_exists($uninstallFile)) {
                require_once $uninstallFile;
        }
});

//activation
register_activation_hook("Rating", function () {
        require_once __DIR__ . '/install.php';
});

//update plugin
register_update_hook("Rating", function () {
        require_once __DIR__ . '/install.php';
});
