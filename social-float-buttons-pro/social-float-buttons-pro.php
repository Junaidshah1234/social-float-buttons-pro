<?php
/**
 * Plugin Name:  Social Float Buttons Pro
 * Plugin URI:   https://github.com/junaid/social-float-buttons-pro
 * Description:  Floating social media contact buttons with toggle popup. WhatsApp, LinkedIn, GitHub, Upwork & more.
 * Version:      1.0.0
 * Author:       Junaid S.
 * Author URI:   https://junaid.dev
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  social-float-buttons-pro
 * Domain Path:  /languages
 * Requires PHP: 8.0
 * Requires WP:  6.0
 */

// ── Prevent Direct Access ──
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

// ── Plugin Constants ──
define('SFBP_VERSION', '1.0.0');
define('SFBP_PATH', plugin_dir_path(__FILE__));
define('SFBP_URL', plugin_dir_url(__FILE__));
define('SFBP_BASENAME', plugin_basename(__FILE__));

// ── Required Files (Secure Inclusion) ──
$required_files = array(
    'inc/sanitize.php',
    'inc/settings.php',
    'inc/settings-render.php',
    'inc/frontend.php',
);

foreach ($required_files as $file) {
    $file_path = SFBP_PATH . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

// ── Plugin Activation Hook ──
function sfbp_activate() {
    // Set default options
    $defaults = array(
        'button_text'          => '📱 Contact Me',
        'button_color'         => '#25D366',
        'button_position'      => 'right',
        'whatsapp_enabled'     => true,
        'whatsapp_number'      => '',
        'whatsapp_message'     => 'Hi! I need help with my website.',
        'linkedin_enabled'     => true,
        'linkedin_url'         => 'https://www.linkedin.com/',
        'github_enabled'       => true,
        'github_url'           => 'https://github.com/',
        'upwork_enabled'       => true,
        'upwork_url'           => 'https://www.upwork.com/',
        'instagram_enabled'    => false,
        'instagram_url'        => '',
        'twitter_enabled'      => false,
        'twitter_url'          => '',
        'youtube_enabled'      => false,
        'youtube_url'          => '',
        'telegram_enabled'     => false,
        'telegram_url'         => '',
        'discord_enabled'      => false,
        'discord_url'          => '',
        'email_enabled'        => false,
        'email_address'        => '',
        'phone_enabled'        => false,
        'phone_number'         => '',
    );
    
    if (!get_option('sfbp_options')) {
        update_option('sfbp_options', $defaults);
    }
    
    // Set version
    update_option('sfbp_version', SFBP_VERSION);
}
register_activation_hook(__FILE__, 'sfbp_activate');

// ── Plugin Deactivation Hook ──
function sfbp_deactivate() {
    // Clean up if needed
    delete_option('sfbp_version');
}
register_deactivation_hook(__FILE__, 'sfbp_deactivate');

// ── Enqueue Assets ──
function sfbp_enqueue_assets($hook) {
    // Admin assets - only on plugin page
    if ($hook === 'toplevel_page_social-float-buttons') {
        wp_enqueue_style('sfbp-admin-css', SFBP_URL . 'assets/css/admin.css', array(), SFBP_VERSION);
        wp_enqueue_script('sfbp-admin-js', SFBP_URL . 'assets/js/admin.js', array('jquery'), SFBP_VERSION, true);
        
        // Nonce for AJAX
        wp_localize_script('sfbp-admin-js', 'sfbp_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('sfbp_admin_nonce'),
        ));
    }
    
    // Frontend assets - everywhere
    if (!is_admin()) {
        wp_enqueue_style('sfbp-frontend-css', SFBP_URL . 'assets/css/frontend.css', array(), SFBP_VERSION);
        wp_enqueue_script('sfbp-frontend-js', SFBP_URL . 'assets/js/frontend.js', array(), SFBP_VERSION, true);
    }
}
add_action('admin_enqueue_scripts', 'sfbp_enqueue_assets');
add_action('wp_enqueue_scripts', 'sfbp_enqueue_assets');

// ── Uninstall Hook ──
function sfbp_uninstall() {
    if (!current_user_can('activate_plugins')) {
        return;
    }
    
    // Clean database
    delete_option('sfbp_options');
    delete_option('sfbp_version');
}
register_uninstall_hook(__FILE__, 'sfbp_uninstall');