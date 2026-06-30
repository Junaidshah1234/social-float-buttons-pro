<?php
// ── Prevent Direct Access ──
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

/**
 * Settings Page HTML
 */
function sfbp_settings_page_html() {
    sfbp_verify_capability();
    
    $options = get_option('sfbp_options', array());
    ?>
    <div class="wrap sfbp-wrap">
        <div class="sfbp-header">
            <h1><?php echo esc_html__('Social Float Buttons Pro', 'social-float-buttons-pro'); ?></h1>
            <p class="sfbp-version">v<?php echo esc_html(SFBP_VERSION); ?></p>
        </div>
        
        <div class="sfbp-content">
            <form method="post" action="options.php" id="sfbp-form">
                <?php 
                settings_fields('sfbp_options_group');
                do_settings_sections('social-float-buttons');
                ?>
                
                <div class="sfbp-submit-wrapper">
                    <?php submit_button(__('Save Changes', 'social-float-buttons-pro'), 'primary sfbp-save-btn', 'submit', false); ?>
                    <span class="sfbp-save-status"></span>
                </div>
            </form>
        </div>
        
        <div class="sfbp-sidebar">
            <div class="sfbp-card">
                <h3><?php echo esc_html__('📌 How to Get Icons', 'social-float-buttons-pro'); ?></h3>
                <p><?php echo esc_html__('Use free SVG icons from these sites:', 'social-float-buttons-pro'); ?></p>
                <ul style="list-style:disc; padding-left:16px; font-size:13px; color:#64748b;">
                    <li><a href="https://simpleicons.org/" target="_blank" rel="noopener noreferrer">simpleicons.org</a></li>
                    <li><a href="https://svgrepo.com/" target="_blank" rel="noopener noreferrer">svgrepo.com</a></li>
                    <li><a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Bootstrap Icons</a></li>
                    <li><a href="https://feathericons.com/" target="_blank" rel="noopener noreferrer">Feather Icons</a></li>
                </ul>
                <p style="font-size:12px; color:#94a3b8; margin-top:8px;">
                    <?php echo esc_html__('Copy the SVG code and paste in the Icon SVG field below each platform.', 'social-float-buttons-pro'); ?>
                </p>
            </div>
            
            <div class="sfbp-card">
                <h3><?php echo esc_html__('Plugin Info', 'social-float-buttons-pro'); ?></h3>
                <p><?php echo esc_html__('Add floating social media buttons to your WordPress site.', 'social-float-buttons-pro'); ?></p>
                <hr>
                <p><strong><?php echo esc_html__('Author:', 'social-float-buttons-pro'); ?></strong> 
                <a href="https://www.upwork.com/freelancers/~0139f4995660a6a8ea" target="_blank" rel="noopener noreferrer" style="color:#2563eb; text-decoration:none; font-weight:500;">
                    Junaid S. ↗
                </a>
                </p>
                <p><strong><?php echo esc_html__('Version:', 'social-float-buttons-pro'); ?></strong> <?php echo esc_html(SFBP_VERSION); ?></p>
            </div>
        </div>
    </div>
    <?php
}

function sfbp_text_field_callback($args) {
    $options = get_option('sfbp_options', array());
    $value = isset($options['button_text']) ? $options['button_text'] : '📱 Contact Me';
    ?>
    <input type="text" id="button_text" name="sfbp_options[button_text]" value="<?php echo esc_attr($value); ?>" class="regular-text sfbp-input" maxlength="50" placeholder="<?php echo esc_attr__('📱 Contact Me', 'social-float-buttons-pro'); ?>" />
    <p class="description"><?php echo esc_html__('Text shown on the floating button. Emojis allowed.', 'social-float-buttons-pro'); ?></p>
    <?php
}

function sfbp_color_field_callback($args) {
    $options = get_option('sfbp_options', array());
    $value = isset($options['button_color']) ? $options['button_color'] : '#25D366';
    ?>
    <div class="sfbp-color-picker-wrapper">
        <input type="color" id="button_color" name="sfbp_options[button_color]" value="<?php echo esc_attr($value); ?>" class="sfbp-color-picker" />
        <input type="text" id="button_color_hex" value="<?php echo esc_attr($value); ?>" class="small-text sfbp-color-hex" maxlength="7" pattern="^#[a-fA-F0-9]{6}$" />
    </div>
    <p class="description"><?php echo esc_html__('Choose a color for the floating button.', 'social-float-buttons-pro'); ?></p>
    <?php
}

function sfbp_position_field_callback($args) {
    $options = get_option('sfbp_options', array());
    $value = isset($options['button_position']) ? $options['button_position'] : 'right';
    ?>
    <select id="button_position" name="sfbp_options[button_position]" class="sfbp-select">
        <option value="right" <?php selected($value, 'right'); ?>><?php echo esc_html__('Bottom Right', 'social-float-buttons-pro'); ?></option>
        <option value="left" <?php selected($value, 'left'); ?>><?php echo esc_html__('Bottom Left', 'social-float-buttons-pro'); ?></option>
    </select>
    <p class="description"><?php echo esc_html__('Position of the floating button on screen.', 'social-float-buttons-pro'); ?></p>
    <?php
}

function sfbp_social_field_callback($args) {
    $options = get_option('sfbp_options', array());
    $platform = $args['platform'];
    $fields = $args['fields'];
    
    $enabled_key = $platform . '_enabled';
    $checked = isset($options[$enabled_key]) ? $options[$enabled_key] : false;
    ?>
    <div class="sfbp-social-field-wrapper">
        <label class="sfbp-toggle">
            <input type="checkbox" name="sfbp_options[<?php echo esc_attr($enabled_key); ?>]" value="1" <?php checked($checked, true); ?> />
            <span class="sfbp-toggle-slider"></span>
            <span class="sfbp-toggle-label"><?php echo esc_html__('Enable', 'social-float-buttons-pro'); ?></span>
        </label>
        
        <?php foreach ($fields as $field): 
            $field_key = $platform . '_' . $field;
            $field_value = isset($options[$field_key]) ? $options[$field_key] : '';
            
            if ($field === 'url'): ?>
                <input type="url" name="sfbp_options[<?php echo esc_attr($field_key); ?>]" value="<?php echo esc_url($field_value); ?>" class="regular-text sfbp-url-input" placeholder="https://" />
            <?php elseif ($field === 'number'): ?>
                <input type="text" name="sfbp_options[<?php echo esc_attr($field_key); ?>]" value="<?php echo esc_attr($field_value); ?>" class="regular-text sfbp-number-input" placeholder="+923001234567" />
            <?php elseif ($field === 'message'): ?>
                <input type="text" name="sfbp_options[<?php echo esc_attr($field_key); ?>]" value="<?php echo esc_attr($field_value); ?>" class="large-text sfbp-message-input" placeholder="<?php echo esc_attr__('Hi! I need help...', 'social-float-buttons-pro'); ?>" />
            <?php elseif ($field === 'address'): ?>
                <input type="email" name="sfbp_options[<?php echo esc_attr($field_key); ?>]" value="<?php echo esc_attr($field_value); ?>" class="regular-text sfbp-email-input" placeholder="you@example.com" />
            <?php elseif ($field === 'icon_url'): ?>
                <textarea name="sfbp_options[<?php echo esc_attr($field_key); ?>]" class="large-text sfbp-icon-svg-input" rows="3" placeholder="<?php echo esc_attr__('Paste SVG code here... e.g., <svg viewBox="0 0 24 24">...</svg>', 'social-float-buttons-pro'); ?>"><?php echo esc_textarea($field_value); ?></textarea>
                <p class="description" style="font-size:11px; color:#94a3b8;">
                    <?php echo esc_html__('💡 Get free SVG icons from simpleicons.org or svgrepo.com', 'social-float-buttons-pro'); ?>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php
}