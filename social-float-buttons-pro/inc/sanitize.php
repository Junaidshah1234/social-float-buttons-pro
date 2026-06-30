<?php
// ── Prevent Direct Access ──
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

function sfbp_sanitize_options($input) {
    $sanitized = array();
    
    $sanitized['button_text'] = isset($input['button_text']) ? wp_kses_post(trim($input['button_text'])) : '📱 Contact Me';
    $sanitized['button_color'] = isset($input['button_color']) ? sfbp_sanitize_hex_color($input['button_color']) : '#25D366';
    
    $allowed_positions = array('right', 'left');
    $sanitized['button_position'] = isset($input['button_position']) && in_array($input['button_position'], $allowed_positions, true) ? $input['button_position'] : 'right';
    
    $social_fields = array(
        'whatsapp'  => array('enabled', 'number', 'message', 'icon_url'),
        'linkedin'  => array('enabled', 'url', 'icon_url'),
        'github'    => array('enabled', 'url', 'icon_url'),
        'upwork'    => array('enabled', 'url', 'icon_url'),
        'instagram' => array('enabled', 'url', 'icon_url'),
        'twitter'   => array('enabled', 'url', 'icon_url'),
        'youtube'   => array('enabled', 'url', 'icon_url'),
        'telegram'  => array('enabled', 'url', 'icon_url'),
        'discord'   => array('enabled', 'url', 'icon_url'),
        'email'     => array('enabled', 'address', 'icon_url'),
        'phone'     => array('enabled', 'number', 'icon_url'),
    );
    
    foreach ($social_fields as $platform => $fields) {
        foreach ($fields as $field) {
            $key = $platform . '_' . $field;
            
            if ($field === 'enabled') {
                $sanitized[$key] = isset($input[$key]) ? (bool) $input[$key] : false;
            } elseif ($field === 'url') {
                $sanitized[$key] = isset($input[$key]) ? esc_url_raw(trim($input[$key])) : '';
            } elseif ($field === 'number') {
                $sanitized[$key] = isset($input[$key]) ? sfbp_sanitize_phone($input[$key]) : '';
            } elseif ($field === 'message') {
                $sanitized[$key] = isset($input[$key]) ? sanitize_text_field($input[$key]) : '';
            } elseif ($field === 'address') {
                $sanitized[$key] = isset($input[$key]) ? sanitize_email($input[$key]) : '';
            } elseif ($field === 'icon_url') {
                $sanitized[$key] = isset($input[$key]) ? wp_kses($input[$key], sfbp_allowed_svg_tags()) : '';
            }
        }
    }
    
    return $sanitized;
}

function sfbp_sanitize_hex_color($color) {
    $color = trim($color);
    $color = ltrim($color, '#');
    if (preg_match('/^[a-fA-F0-9]{3,6}$/', $color)) {
        return '#' . strtolower($color);
    }
    return '#25D366';
}

function sfbp_sanitize_phone($phone) {
    $phone = trim($phone);
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    if (substr_count($phone, '+') > 1) {
        $phone = '+' . str_replace('+', '', $phone);
    }
    return $phone;
}

function sfbp_allowed_svg_tags() {
    return array(
        'svg'   => array('viewbox' => true, 'xmlns' => true, 'width' => true, 'height' => true, 'fill' => true, 'class' => true),
        'path'  => array('d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true),
        'circle' => array('cx' => true, 'cy' => true, 'r' => true, 'fill' => true),
        'rect'   => array('x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'fill' => true),
        'line'   => array('x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true),
        'polyline' => array('points' => true, 'fill' => true, 'stroke' => true),
        'text'   => array('x' => true, 'y' => true, 'text-anchor' => true, 'fill' => true, 'font-size' => true, 'font-weight' => true, 'font-family' => true),
        'g'      => array('fill' => true),
    );
}

function sfbp_verify_nonce($nonce, $action = 'sfbp_admin_nonce') {
    if (!isset($nonce) || !wp_verify_nonce($nonce, $action)) {
        wp_die(__('Security check failed.', 'social-float-buttons-pro'), __('Security Error', 'social-float-buttons-pro'), array('response' => 403, 'back_link' => true));
    }
    return true;
}

function sfbp_verify_capability() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions.', 'social-float-buttons-pro'), __('Permission Denied', 'social-float-buttons-pro'), array('response' => 403, 'back_link' => true));
    }
    return true;
}