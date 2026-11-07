<?php
/**
 * Helma Theme - Per-Page Custom Meta Boxes
 *
 * Provides granular layout and display controls for each individual page and post.
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

/**
 * Register Meta Box for Pages and Posts
 */
function helma_register_page_meta_boxes() {
    $screens = array('page', 'post');
    foreach ($screens as $screen) {
        add_meta_box(
            'helma_page_options_meta',
            __('⚙️ تنظیمات اختصاصی این برگه (Helma Page Options)', 'helma'),
            'helma_render_page_options_meta_box',
            $screen,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'helma_register_page_meta_boxes');

/**
 * Render Meta Box Content
 */
function helma_render_page_options_meta_box($post) {
    wp_nonce_field('helma_save_page_options', 'helma_page_options_nonce');

    $layout        = get_post_meta($post->ID, '_helma_layout', true) ?: 'default';
    $header_style  = get_post_meta($post->ID, '_helma_header_style', true) ?: 'default';
    $cyber_grid    = get_post_meta($post->ID, '_helma_cyber_grid', true) ?: 'yes';
    $glow_color    = get_post_meta($post->ID, '_helma_glow_color', true) ?: '';
    $show_title    = get_post_meta($post->ID, '_helma_show_title', true) ?: 'yes';
    $subtitle      = get_post_meta($post->ID, '_helma_subtitle', true) ?: '';
    $hide_footer   = get_post_meta($post->ID, '_helma_hide_footer', true) ?: 'no';
    ?>
    <style>
        .helma-mb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            padding: 1rem 0;
            font-family: inherit;
        }
        .helma-mb-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .helma-mb-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .helma-mb-select {
            width: 100%;
            padding: 0.45rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            font-size: 0.85rem;
            color: #1e293b;
        }
        .helma-mb-desc {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.5;
        }
    </style>

    <div class="helma-mb-grid">
        
        <!-- 1. Layout -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_layout">
                <span>📐 ساختار چیدمان (Layout)</span>
            </label>
            <select name="helma_layout" id="helma_layout" class="helma-mb-select">
                <option value="default" <?php selected($layout, 'default'); ?>>پیش‌فرض قالب (همراه با کانتینر)</option>
                <option value="full" <?php selected($layout, 'full'); ?>>تمام‌عرض کامل (Full Width - بدون سایدبار)</option>
                <option value="sidebar-right" <?php selected($layout, 'sidebar-right'); ?>>با سایدبار سمت راست</option>
                <option value="sidebar-left" <?php selected($layout, 'sidebar-left'); ?>>با سایدبار سمت چپ</option>
                <option value="contained" <?php selected($layout, 'contained'); ?>>عرض متنی فشرده (مخصوص مطالعه)</option>
            </select>
            <span class="helma-mb-desc">تعیین چیدمان محتوای صفحه مستقل از سایر بخش‌ها.</span>
        </div>

        <!-- 2. Header Style -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_header_style">
                <span>✨ وضعیت هدر در این صفحه</span>
            </label>
            <select name="helma_header_style" id="helma_header_style" class="helma-mb-select">
                <option value="default" <?php selected($header_style, 'default'); ?>>هدر شیشه‌ای استاندارد</option>
                <option value="transparent" <?php selected($header_style, 'transparent'); ?>>هدر کاملاً شفاف (Transparent)</option>
                <option value="hide" <?php selected($header_style, 'hide'); ?>>مخفی کردن کامل هدر (بدون هدر)</option>
            </select>
            <span class="helma-mb-desc">مناسب برای صفحات فرود و لندینگ‌های تبلیغاتی.</span>
        </div>

        <!-- 3. Cyber Grid Canvas Background -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_cyber_grid">
                <span>🌐 پس‌زمینه شبکه‌ای سایبرنتیک</span>
            </label>
            <select name="helma_cyber_grid" id="helma_cyber_grid" class="helma-mb-select">
                <option value="yes" <?php selected($cyber_grid, 'yes'); ?>>نمایش پس‌زمینه شبکه‌ای با نور نئونی</option>
                <option value="no" <?php selected($cyber_grid, 'no'); ?>>پس‌زمینه ساده تک‌رنگ (بدون شبکه)</option>
            </select>
            <span class="helma-mb-desc">کنترل بافت شبکه‌ای و افکت نوری پس‌زمینه.</span>
        </div>

        <!-- 4. Glow Color Override -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_glow_color">
                <span>🔮 رنگ درخشش اختصاصی این صفحه</span>
            </label>
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <input type="color" name="helma_glow_color" id="helma_glow_color" value="<?php echo esc_attr($glow_color ?: '#8b5cf6'); ?>" style="height:36px; width:46px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                <input type="text" name="helma_glow_color_hex" id="helma_glow_color_hex" value="<?php echo esc_attr($glow_color); ?>" placeholder="خالی = پیش‌فرض پوسته" class="helma-mb-select" style="flex:1;" />
            </div>
            <span class="helma-mb-desc">رنگ نورها و دکمه‌های این صفحه را موضعی تغییر دهید.</span>
        </div>

        <!-- 5. Title & Banner -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_show_title">
                <span>🏷️ عنوان برگه و بنر سربرگ</span>
            </label>
            <select name="helma_show_title" id="helma_show_title" class="helma-mb-select">
                <option value="yes" <?php selected($show_title, 'yes'); ?>>نمایش عنوان ساده در بالای محتوا</option>
                <option value="banner" <?php selected($show_title, 'banner'); ?>>نمایش بنر سربرگ عریض با گرادیان درخشان</option>
                <option value="no" <?php selected($show_title, 'no'); ?>>عدم نمایش عنوان (مخصوص صفحه‌سازها)</option>
            </select>
            <span class="helma-mb-desc">جلوگیری از مزاحمت عنوان پیش‌فرض در لندینگ‌ها.</span>
        </div>

        <!-- 6. Footer Visibility -->
        <div class="helma-mb-field">
            <label class="helma-mb-label" for="helma_hide_footer">
                <span>🦶 وضعیت فوتر در این صفحه</span>
            </label>
            <select name="helma_hide_footer" id="helma_hide_footer" class="helma-mb-select">
                <option value="no" <?php selected($hide_footer, 'no'); ?>>نمایش فوتر کامل سایت</option>
                <option value="yes" <?php selected($hide_footer, 'yes'); ?>>مخفی کردن کامل فوتر (صفحه فرود و قیف فروش)</option>
            </select>
            <span class="helma-mb-desc">حذف فوتر برای افزایش نرخ تبدیل در صفحات کمپین.</span>
        </div>

    </div>
    <div style="font-size: 0.75rem; color: #64748b; padding-top: 0.5rem; border-top: 1px solid #e2e8f0; display:flex; justify-content:space-between;">
        <span>پوسته اختصاصی حلما نسل جدید AI & SaaS</span>
        <span>طراحی و مهندسی: علی فیروزی • شرکت هونا (hoonaco.ir)</span>
    </div>
    <?php
}

/**
 * Save Meta Box Data Safely
 */
function helma_save_page_options_meta($post_id) {
    if (!isset($_POST['helma_page_options_nonce']) || !wp_verify_nonce($_POST['helma_page_options_nonce'], 'helma_save_page_options')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $valid_layouts = array('default', 'full', 'sidebar-right', 'sidebar-left', 'contained');
    if (isset($_POST['helma_layout']) && in_array($_POST['helma_layout'], $valid_layouts, true)) {
        update_post_meta($post_id, '_helma_layout', sanitize_key($_POST['helma_layout']));
    }

    $valid_headers = array('default', 'transparent', 'hide');
    if (isset($_POST['helma_header_style']) && in_array($_POST['helma_header_style'], $valid_headers, true)) {
        update_post_meta($post_id, '_helma_header_style', sanitize_key($_POST['helma_header_style']));
    }

    $valid_grid = array('yes', 'no');
    if (isset($_POST['helma_cyber_grid']) && in_array($_POST['helma_cyber_grid'], $valid_grid, true)) {
        update_post_meta($post_id, '_helma_cyber_grid', sanitize_key($_POST['helma_cyber_grid']));
    }

    if (isset($_POST['helma_glow_color_hex']) && !empty($_POST['helma_glow_color_hex'])) {
        update_post_meta($post_id, '_helma_glow_color', sanitize_hex_color($_POST['helma_glow_color_hex']));
    } elseif (isset($_POST['helma_glow_color']) && !empty($_POST['helma_glow_color'])) {
        update_post_meta($post_id, '_helma_glow_color', sanitize_hex_color($_POST['helma_glow_color']));
    } else {
        delete_post_meta($post_id, '_helma_glow_color');
    }

    $valid_titles = array('yes', 'banner', 'no');
    if (isset($_POST['helma_show_title']) && in_array($_POST['helma_show_title'], $valid_titles, true)) {
        update_post_meta($post_id, '_helma_show_title', sanitize_key($_POST['helma_show_title']));
    }

    $valid_footer = array('no', 'yes');
    if (isset($_POST['helma_hide_footer']) && in_array($_POST['helma_hide_footer'], $valid_footer, true)) {
        update_post_meta($post_id, '_helma_hide_footer', sanitize_key($_POST['helma_hide_footer']));
    }
}
add_action('save_post', 'helma_save_page_options_meta');
