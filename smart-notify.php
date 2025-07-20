<?php
/**
 * Plugin Name: Smart Notify
 * Description: Displays smart popup notifications for different user roles.
 * Version: 1.0
 * Author: Harshit
 */

if (!defined('ABSPATH')) exit;

class SmartNotify {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'load_scripts']);
        add_action('wp_ajax_smart_notify_save_settings', [$this, 'save_settings']);
        add_action('admin_notices', [$this, 'show_admin_notification']);
    }

    public function add_settings_page() {
        add_options_page('Smart Notify', 'Smart Notify', 'manage_options', 'smart-notify', [$this, 'render_settings_page']);
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Smart Notify Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('smart_notify_options');
                do_settings_sections('smart_notify');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function load_scripts($hook) {
        if ($hook !== 'settings_page_smart-notify') return;
        wp_enqueue_script('smart-notify-js', plugin_dir_url(__FILE__) . 'smart-notify.js', [], null, true);
    }

    public function show_admin_notification() {
        $user = wp_get_current_user();
        if (in_array('administrator', $user->roles)) {
            echo '<div class="notice notice-success is-dismissible"><p>Smart Notify: Hello Admin!</p></div>';
        }
    }

    public function save_settings() {
        // Save plugin settings logic here
    }
}

new SmartNotify();
?>
