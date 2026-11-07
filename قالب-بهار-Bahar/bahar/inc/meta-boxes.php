<?php
/**
 * Bahar Theme - Per-Page Custom Meta Boxes
 *
 * Provides granular layout and display controls for each individual page and post.
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}

/**
 * Register Meta Box for Pages and Posts
 */
function bahar_register_page_meta_boxes() {
    $screens = array('page', 'post');
    foreach ($screens as $screen) {
        add_meta_box(
            'bahar_page_options_meta',
            __('⚙️ تنظیمات اختصاصی این صفحه (Bahar Page Options)', 'bahar'),
            'bahar_render_page_options_meta_box',
            $screen,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'bahar_register_page_meta_boxes');

/**
 * Render Meta Box Content
 */
function bahar_render_page_options_meta_box($post) {
    wp_nonce_field('bahar_save_page_options', 'bahar_page_options_nonce');

    $layout        = get_post_meta($post->ID, '_bahar_layout', true) ?: 'default';
    $header_style  = get_post_meta($post->ID, '_bahar_header_style', true) ?: 'default';
    $show_title    = get_post_meta($post->ID, '_bahar_show_title', true) ?: 'yes';
    $subtitle      = get_post_meta($post->ID, '_bahar_subtitle', true) ?: '';
    $accent_color  = get_post_meta($post->ID, '_bahar_accent_color', true) ?: '';
    $breadcrumbs   = get_post_meta($post->ID, '_bahar_breadcrumbs', true) ?: 'default';
    $hide_footer   = get_post_meta($post->ID, '_bahar_hide_footer', true) ?: 'no';
    ?>
    <style>
        .bahar-mb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            padding: 1rem 0;
            font-family: inherit;
        }
        .bahar-mb-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .bahar-mb-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .bahar-mb-select {
            width: 100%;
            padding: 0.45rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            font-size: 0.85rem;
            color: #1e293b;
        }
        .bahar-mb-desc {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.5;
        }
        .bahar-mb-badge {
            font-size: 0.75rem;
            color: #2563eb;
            font-weight: 600;
        }
    </style>

    <div class="bahar-mb-grid">
        
        <!-- 1. Layout -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_layout">
                <span>📐 ساختار چیدمان (Layout)</span>
            </label>
            <select name="bahar_layout" id="bahar_layout" class="bahar-mb-select">
                <option value="default" <?php selected($layout, 'default'); ?>>پیش‌فرض قالب (همراه با کانتینر)</option>
                <option value="full" <?php selected($layout, 'full'); ?>>تمام‌عرض کامل (Full Width - بدون سایدبار)</option>
                <option value="sidebar-right" <?php selected($layout, 'sidebar-right'); ?>>با سایدبار سمت راست</option>
                <option value="sidebar-left" <?php selected($layout, 'sidebar-left'); ?>>با سایدبار سمت چپ</option>
                <option value="contained" <?php selected($layout, 'contained'); ?>>عرض متنی فشرده (خوانایی بالا)</option>
            </select>
            <span class="bahar-mb-desc">تعیین کنید محتوای این صفحه تمام‌عرض باشد یا با سایدبار نمایش یابد.</span>
        </div>

        <!-- 2. Header Style -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_header_style">
                <span>✨ وضعیت هدر در این صفحه</span>
            </label>
            <select name="bahar_header_style" id="bahar_header_style" class="bahar-mb-select">
                <option value="default" <?php selected($header_style, 'default'); ?>>هدر استاندارد پیش‌فرض</option>
                <option value="transparent" <?php selected($header_style, 'transparent'); ?>>هدر شفاف و شیشه‌ای (Transparent)</option>
                <option value="hide" <?php selected($header_style, 'hide'); ?>>مخفی کردن کامل هدر</option>
            </select>
            <span class="bahar-mb-desc">برای صفحات فرود یا صفحاتی با تصویر بالای بزرگ، هدر شفاف بهترین انتخاب است.</span>
        </div>

        <!-- 3. Title & Banner -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_show_title">
                <span>🏷️ عنوان برگه و بنر سربرگ</span>
            </label>
            <select name="bahar_show_title" id="bahar_show_title" class="bahar-mb-select">
                <option value="yes" <?php selected($show_title, 'yes'); ?>>نمایش عنوان ساده در بالای محتوا</option>
                <option value="banner" <?php selected($show_title, 'banner'); ?>>نمایش بنر سربرگ عریض با گرادیان ملایم</option>
                <option value="no" <?php selected($show_title, 'no'); ?>>عدم نمایش عنوان (مخصوص لندینگ‌ها)</option>
            </select>
            <span class="bahar-mb-desc">امکان حذف عنوان برای جلوگیری از تداخل با صفحه‌سازها و سکشن‌های دلخواه.</span>
        </div>

        <!-- 4. Banner Subtitle -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_subtitle">
                <span>📝 زیرعنوان یا توضیح بنر</span>
            </label>
            <input type="text" name="bahar_subtitle" id="bahar_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="مثال: آشنایی با داستان، رسالت و تیم متخصص شرکت هونا" class="bahar-mb-select" />
            <span class="bahar-mb-desc">در صورت انتخاب حالت بنر سربرگ، این متن زیر عنوان بزرگ نمایش می‌یابد.</span>
        </div>

        <!-- 5. Page Accent Color Override -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_accent_color">
                <span>🎨 رنگ شاخص اختصاصی این صفحه</span>
            </label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="color" name="bahar_accent_color" id="bahar_accent_color" value="<?php echo esc_attr($accent_color ?: '#2563eb'); ?>" style="height:36px; width:48px; padding:0; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" />
                <input type="text" name="bahar_accent_color_hex" id="bahar_accent_color_hex" value="<?php echo esc_attr($accent_color); ?>" placeholder="خالی = رنگ پیش‌فرض پوسته" class="bahar-mb-select" style="flex:1;" />
            </div>
            <span class="bahar-mb-desc">رنگ دکمه‌ها و لینک‌های این صفحه را مستقل از تم اصلی تغییر دهید.</span>
        </div>

        <!-- 6. Breadcrumbs -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_breadcrumbs">
                <span>🧭 مسیر راهنما (Breadcrumbs)</span>
            </label>
            <select name="bahar_breadcrumbs" id="bahar_breadcrumbs" class="bahar-mb-select">
                <option value="default" <?php selected($breadcrumbs, 'default'); ?>>نمایش مسیر راهنما (پیش‌فرض)</option>
                <option value="hide" <?php selected($breadcrumbs, 'hide'); ?>>مخفی کردن در این صفحه</option>
            </select>
            <span class="bahar-mb-desc">نمایش یا پنهان‌سازی زنجیره ناوبری صفحات در بالای این برگه.</span>
        </div>

        <!-- 7. Footer Visibility -->
        <div class="bahar-mb-field">
            <label class="bahar-mb-label" for="bahar_hide_footer">
                <span>🦶 وضعیت فوتر در این صفحه</span>
            </label>
            <select name="bahar_hide_footer" id="bahar_hide_footer" class="bahar-mb-select">
                <option value="no" <?php selected($hide_footer, 'no'); ?>>نمایش فوتر کامل سایت</option>
                <option value="yes" <?php selected($hide_footer, 'yes'); ?>>مخفی کردن کامل فوتر (صفحه فرود / قیف فروش)</option>
            </select>
            <span class="bahar-mb-desc">در صفحات فروش یا ثبت‌نام، با حذف فوتر تمرکز کاربر روی ثبت اقدام حفظ می‌شود.</span>
        </div>

    </div>
    <div style="font-size: 0.75rem; color: #64748b; padding-top: 0.5rem; border-top: 1px solid #e2e8f0; display:flex; justify-content:space-between;">
        <span>پوسته اختصاصی بهار اینترپرایز</span>
        <span class="bahar-mb-badge">طراحی و مهندسی: علی فیروزی • شرکت هونا (hoonaco.ir)</span>
    </div>
    <?php
}

/**
 * Save Meta Box Data Safely
 */
function bahar_save_page_options_meta($post_id) {
    if (!isset($_POST['bahar_page_options_nonce']) || !wp_verify_nonce($_POST['bahar_page_options_nonce'], 'bahar_save_page_options')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $valid_layouts = array('default', 'full', 'sidebar-right', 'sidebar-left', 'contained');
    if (isset($_POST['bahar_layout']) && in_array($_POST['bahar_layout'], $valid_layouts, true)) {
        update_post_meta($post_id, '_bahar_layout', sanitize_key($_POST['bahar_layout']));
    }

    $valid_headers = array('default', 'transparent', 'hide');
    if (isset($_POST['bahar_header_style']) && in_array($_POST['bahar_header_style'], $valid_headers, true)) {
        update_post_meta($post_id, '_bahar_header_style', sanitize_key($_POST['bahar_header_style']));
    }

    $valid_titles = array('yes', 'banner', 'no');
    if (isset($_POST['bahar_show_title']) && in_array($_POST['bahar_show_title'], $valid_titles, true)) {
        update_post_meta($post_id, '_bahar_show_title', sanitize_key($_POST['bahar_show_title']));
    }

    if (isset($_POST['bahar_subtitle'])) {
        update_post_meta($post_id, '_bahar_subtitle', sanitize_text_field($_POST['bahar_subtitle']));
    }

    if (isset($_POST['bahar_accent_color_hex']) && !empty($_POST['bahar_accent_color_hex'])) {
        update_post_meta($post_id, '_bahar_accent_color', sanitize_hex_color($_POST['bahar_accent_color_hex']));
    } elseif (isset($_POST['bahar_accent_color']) && !empty($_POST['bahar_accent_color'])) {
        update_post_meta($post_id, '_bahar_accent_color', sanitize_hex_color($_POST['bahar_accent_color']));
    } else {
        delete_post_meta($post_id, '_bahar_accent_color');
    }

    $valid_bc = array('default', 'hide');
    if (isset($_POST['bahar_breadcrumbs']) && in_array($_POST['bahar_breadcrumbs'], $valid_bc, true)) {
        update_post_meta($post_id, '_bahar_breadcrumbs', sanitize_key($_POST['bahar_breadcrumbs']));
    }

    $valid_footer = array('no', 'yes');
    if (isset($_POST['bahar_hide_footer']) && in_array($_POST['bahar_hide_footer'], $valid_footer, true)) {
        update_post_meta($post_id, '_bahar_hide_footer', sanitize_key($_POST['bahar_hide_footer']));
    }
}
add_action('save_post', 'bahar_save_page_options_meta');
