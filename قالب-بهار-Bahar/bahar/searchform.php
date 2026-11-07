<?php
/**
 * The template for displaying search forms in Bahar
 *
 * @package Bahar
 */

if (!defined('ABSPATH')) {
    exit('Direct access not permitted.');
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: 0.5rem; width: 100%;">
    <div style="position: relative; flex-grow: 1;">
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('جستجو در سایت...', 'placeholder', 'bahar'); ?>" value="<?php echo get_search_query(); ?>" name="s" style="width: 100%; padding: 0.75rem 1.25rem 0.75rem 2.75rem; border: 1px solid var(--border-light); border-radius: var(--radius-md); background-color: var(--bg-surface); outline: none;" />
        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </span>
    </div>
    <button type="submit" class="search-submit btn btn-primary" style="padding: 0.75rem 1.5rem;">
        <?php echo esc_html_x('جستجو', 'submit button', 'bahar'); ?>
    </button>
</form>
