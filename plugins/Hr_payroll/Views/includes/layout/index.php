<?php
$Users_model = model("App\Models\Users_model");
$login_user_id = $Users_model->login_user_id();
$personal_rtl_support = get_setting('user_' . $login_user_id . '_personal_rtl_support');

$dir = 'ltr';
if ((get_setting("rtl") && !$personal_rtl_support) || $personal_rtl_support == "yes") {
    $dir = 'rtl';
}

helper('cookie');
$left_menu_minimized = get_cookie("left_menu_minimized");
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo html_entity_decode($dir); ?>">
    <?php echo view('includes/head'); ?>
    <body class="<?php echo html_entity_decode($left_menu_minimized) ? "sidebar-toggled" : ""; ?>">

        <?php
        if ($topbar) {
            echo view($topbar);
        }

        ?>

        <div id="left-menu-toggle-mask">
            
            <div class="page-container overflow-auto">
                <div id="pre-loader">
                    <div id="pre-loade" class="app-loader"><div class="loading"></div></div>
                </div>
                <div class="scrollable-page main-scrollable-page">
                    <?php
                    if (isset($content_view) && $content_view != "") {
                        echo view($content_view);
                    }
                    
                    app_hooks()->do_action('app_hook_layout_main_view_extension');
                    ?>
                </div>
                <?php
                if ($topbar == "includes/public/topbar") {
                    echo view("includes/footer");
                }
                ?>

            </div>
        </div>

        <?php echo view('modal/index'); ?>
        <?php echo view('modal/confirmation'); ?>
        <?php echo view("includes/summernote"); ?>
        <div style='display: none;'>
            <script type='text/javascript'>
                feather.replace();

<?php
$session = \Config\Services::session();
$error_message = $session->getFlashdata("error_message");
$success_message = $session->getFlashdata("success_message");
if (isset($error)) {
    echo 'appAlert.error("' . $error . '");';
}
if (isset($error_message)) {
    echo 'appAlert.error("' . $error_message . '");';
}
if (isset($success_message)) {
    echo 'appAlert.success("' . $success_message . '", {duration: 10000});';
}
?>
            </script>
        </div>

    </body>
</html>