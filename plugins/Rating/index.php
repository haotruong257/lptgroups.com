<?php

use App\Controllers\Security_Controller;

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
app_hooks()->add_filter('app_filter_staff_left_menu', 'rating_left_menu');
app_hooks()->add_filter('app_filter_client_left_menu', 'rating_left_menu');

if (!function_exists('rating_left_menu')) {
        function rating_left_menu($sidebar_menu)
        {
                $ci = new Security_Controller(); // Khởi tạo bên trong hàm ✅

                // Nếu là client nhưng không có quyền truy cập, thì không hiển thị menu
                if ($ci->login_user->user_type === "client" && !get_setting("client_can_access_rating")) {
                        return $sidebar_menu;
                }
                // Thêm menu vào sidebar
                $sidebar_menu["rating"] = array(
                        "name" => "Rating",  // Hiển thị chữ "Rating"
                        "url" => "rating",   // Đường dẫn
                        "class" => "star",   // Icon (thử dùng icon hợp lệ)
                        "position" => 6,
                );
                return $sidebar_menu;
        }
}


// // Add admin setting menu item
// app_hooks()->add_filter('app_filter_admin_settings_menu', function ($sidebar_menu) {
//         $sidebar_menu["plugins"][] = array("name" => "Rating", "url" => "evaluation_criteria");
//         return $sidebar_menu;
// });


// Add setting link to the plugin setting
app_hooks()->add_filter('app_filter_action_links_of_Rating', function () {
        $action_links_array = array(
                anchor(get_uri("rating"), "Rating"),
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
