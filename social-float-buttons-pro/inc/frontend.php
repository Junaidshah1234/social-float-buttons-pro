<?php
// ── Prevent Direct Access ──
if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

function sfbp_render_float_buttons() {
    $options = get_option('sfbp_options', array());
    
    $button_text     = isset($options['button_text']) ? $options['button_text'] : '📱 Contact Me';
    $button_color    = isset($options['button_color']) ? $options['button_color'] : '#25D366';
    $button_position = isset($options['button_position']) ? $options['button_position'] : 'right';
    
    $platforms = array(
        'whatsapp'  => array(
            'enabled'   => $options['whatsapp_enabled'] ?? false,
            'url'       => 'https://wa.me/' . ($options['whatsapp_number'] ?? '') . '?text=' . urlencode($options['whatsapp_message'] ?? ''),
            'icon_svg'  => $options['whatsapp_icon_url'] ?? '',
            'icon'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>',
            'color'     => '#25D366',
            'label'     => 'WhatsApp',
        ),
        'linkedin'  => array(
            'enabled'   => $options['linkedin_enabled'] ?? false,
            'url'       => $options['linkedin_url'] ?? '',
            'icon_svg'  => $options['linkedin_icon_url'] ?? '',
            'icon'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'color'     => '#0077B5',
            'label'     => 'LinkedIn',
        ),
        'github'    => array(
            'enabled'   => $options['github_enabled'] ?? false,
            'url'       => $options['github_url'] ?? '',
            'icon_svg'  => $options['github_icon_url'] ?? '',
            'icon'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>',
            'color'     => '#24292e',
            'label'     => 'GitHub',
        ),
        'upwork'    => array(
            'enabled'   => $options['upwork_enabled'] ?? false,
            'url'       => $options['upwork_url'] ?? '',
            'icon_svg'  => $options['upwork_icon_url'] ?? '',
            'icon'      => '<svg viewBox="0 0 32 32" fill="currentColor"><path d="M24.75 17.542c-1.469 0-2.849-.62-4.099-1.635l.305-1.437.013-.077c.269-1.596 1.107-4.278 3.781-4.278 1.99 0 3.609 1.619 3.609 3.609 0 1.996-1.619 3.818-3.609 3.818zm0-10.583c-3.285 0-5.838 2.147-6.881 5.637-.997-1.498-1.758-3.299-2.206-4.82H12.23v5.826c0 1.879-1.529 3.408-3.408 3.408s-3.408-1.529-3.408-3.408V7.776H1.98v5.826c0 3.765 3.063 6.841 6.841 6.841s6.841-3.076 6.841-6.841v-.976c.441.924.986 1.862 1.641 2.72l-2.307 10.809h3.479l1.481-6.974c1.309.809 2.783 1.317 4.393 1.317 3.765 0 6.841-3.076 6.841-6.841.001-3.765-3.075-6.915-6.84-6.915z"/></svg>',
            'color'     => '#14a800',
            'label'     => 'Upwork',
        ),
    );
    
    $enabled_platforms = array_filter($platforms, function($p) {
        return $p['enabled'] === true;
    });
    
    if (empty($enabled_platforms)) {
        return;
    }
    ?>
    
    <div class="sfbp-container" data-position="<?php echo esc_attr($button_position); ?>">
        <div class="sfbp-popup">
            <?php foreach ($enabled_platforms as $key => $platform): ?>
                <a href="<?php echo esc_url($platform['url']); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="sfbp-icon sfbp-<?php echo esc_attr($key); ?>"
                   style="background-color: <?php echo esc_attr($platform['color']); ?>;"
                   aria-label="<?php echo esc_attr($platform['label']); ?>"
                   title="<?php echo esc_attr($platform['label']); ?>">
                    <?php if (!empty($platform['icon_svg'])): ?>
                        <?php echo $platform['icon_svg']; ?>
                    <?php else: ?>
                        <?php echo $platform['icon']; ?>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <button class="sfbp-toggle-btn" 
                style="background-color: <?php echo esc_attr($button_color); ?>;"
                aria-label="<?php echo esc_attr__('Toggle Social Buttons', 'social-float-buttons-pro'); ?>">
            <span class="sfbp-btn-text"><?php echo esc_html($button_text); ?></span>
            <span class="sfbp-btn-icon">✕</span>
        </button>
    </div>
    <?php
}
add_action('wp_footer', 'sfbp_render_float_buttons', 99);