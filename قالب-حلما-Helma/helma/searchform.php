<?php
/**
 * Helma Theme Search Form
 *
 * Developer & Designer: علی فیروزی | شرکت هونا (hoonaco.ir)
 *
 * @package Helma
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex; gap:0.5rem;">
    <input type="search" class="simulator-input" placeholder="<?php echo esc_attr_x('جستجوی موضوع یا کلمه کلیدی...', 'placeholder', 'helma'); ?>" value="<?php echo get_search_query(); ?>" name="s" style="background:var(--bg-input); border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:0.6rem 0.85rem; font-size:0.88rem; width:100%;" />
    <button type="submit" class="btn-primary-glow" style="padding:0.6rem 1.1rem; border-radius:var(--radius-sm);">
        🔍
    </button>
</form>
