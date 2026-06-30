<?php
// ── Prevent Direct Access ──
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

/**
 * Register Admin Menu
 */
function sfbp_add_admin_menu() {
    add_menu_page(
        __('Social Float Buttons', 'social-float-buttons-pro'),
        __('Social Float', 'social-float-buttons-pro'),
        'manage_options',
        'social-float-buttons',
        'sfbp_settings_page_html',
        'dashicons-share',
        30
    );
}
add_action('admin_menu', 'sfbp_add_admin_menu');

/**
 * Register Plugin Settings
 */
function sfbp_register_settings() {
    register_setting(
        'sfbp_options_group',
        'sfbp_options',
        array(
            'sanitize_callback' => 'sfbp_sanitize_options',
            'default'           => array(),
        )
    );
    
    // Settings Sections
    add_settings_section(
        'sfbp_main_section',
        __('Button Settings', 'social-float-buttons-pro'),
        'sfbp_main_section_callback',
        'social-float-buttons'
    );
    
    add_settings_section(
        'sfbp_social_section',
        __('Social Media Icons', 'social-float-buttons-pro'),
        'sfbp_social_section_callback',
        'social-float-buttons'
    );
    
    // Button Text Field
    add_settings_field(
        'button_text',
        __('Button Text', 'social-float-buttons-pro'),
        'sfbp_text_field_callback',
        'social-float-buttons',
        'sfbp_main_section',
        array('label_for' => 'button_text', 'class' => 'sfbp-field-row')
    );
    
    // Button Color Field
    add_settings_field(
        'button_color',
        __('Button Color', 'social-float-buttons-pro'),
        'sfbp_color_field_callback',
        'social-float-buttons',
        'sfbp_main_section',
        array('label_for' => 'button_color', 'class' => 'sfbp-field-row')
    );
    
    // Button Position Field
    add_settings_field(
        'button_position',
        __('Button Position', 'social-float-buttons-pro'),
        'sfbp_position_field_callback',
        'social-float-buttons',
        'sfbp_main_section',
        array('label_for' => 'button_position', 'class' => 'sfbp-field-row')
    );
    
    // Social Media Fields
    $social_platforms = array(
        'whatsapp'  => array('label' => 'WhatsApp', 'icon' => '💬', 'fields' => array('number', 'message', 'icon_url')),
        'linkedin'  => array('label' => 'LinkedIn', 'icon' => '💼', 'fields' => array('url', 'icon_url')),
        'github'    => array('label' => 'GitHub', 'icon' => '💻', 'fields' => array('url', 'icon_url')),
        'upwork'    => array('label' => 'Upwork', 'icon' => '🚀', 'fields' => array('url', 'icon_url')),
        'instagram' => array('label' => 'Instagram', 'icon' => '📷', 'fields' => array('url', 'icon_url')),
        'twitter'   => array('label' => 'Twitter/X', 'icon' => '🐦', 'fields' => array('url', 'icon_url')),
        'youtube'   => array('label' => 'YouTube', 'icon' => '▶️', 'fields' => array('url', 'icon_url')),
        'telegram'  => array('label' => 'Telegram', 'icon' => '✈️', 'fields' => array('url', 'icon_url')),
        'discord'   => array('label' => 'Discord', 'icon' => '🎮', 'fields' => array('url', 'icon_url')),
        'email'     => array('label' => 'Email', 'icon' => '📧', 'fields' => array('address', 'icon_url')),
        'phone'     => array('label' => 'Phone', 'icon' => '📞', 'fields' => array('number', 'icon_url')),
    );
    
    foreach ($social_platforms as $key => $platform) {
        $field_id = $key . '_enabled';
        add_settings_field(
            $field_id,
            $platform['icon'] . ' ' . $platform['label'],
            'sfbp_social_field_callback',
            'social-float-buttons',
            'sfbp_social_section',
            array(
                'label_for'  => $field_id,
                'platform'   => $key,
                'fields'     => $platform['fields'],
                'class'      => 'sfbp-social-row',
            )
        );
    }
}
add_action('admin_init', 'sfbp_register_settings');

/**
 * Section Callbacks
 */
function sfbp_main_section_callback() {
    echo '<p class="description">' . esc_html__('Customize the main floating button appearance.', 'social-float-buttons-pro') . '</p>';
}

function sfbp_social_section_callback() {
    echo '<p class="description">' . esc_html__('Enable and configure social media icons. Only enabled icons will show on the frontend.', 'social-float-buttons-pro') . '</p>';
}