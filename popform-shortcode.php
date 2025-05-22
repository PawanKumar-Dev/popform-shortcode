<?php

/**
 * Plugin Name: PopForm Shortcode
 * Description: A global popup form using Contact Form 7 shortcode with a beautiful design.
 * Version: 1.2
 * Author: Pawan
 */

if (!defined('ABSPATH')) exit;

// Enqueue styles and scripts
function popform_enqueue_assets()
{
    wp_enqueue_style('popform-style', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('popform-script', plugin_dir_url(__FILE__) . 'popup.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'popform_enqueue_assets');

// Display popup in footer
function popform_display_popup()
{
    $form_id = get_option('popform_cf7_form_id');
    $font_family = get_option('popform_font_family', 'inherit');
    $heading_text = get_option('popform_heading_text', "Let's Talk!");
    $subheading_text = get_option('popform_subheading_text', "Fill in your details and we'll get back to you.");
    $image_url = get_option('popform_image_url', '');
    $btn_color_start = get_option('popform_btn_color_start', '#f6d365');
    $btn_color_end = get_option('popform_btn_color_end', '#fda085');
    $display_mode = get_option('popform_display_mode', 'all');
    $selected_pages = get_option('popform_selected_pages', []);
    if (!is_array($selected_pages)) $selected_pages = [];
    $popup_delay = get_option('popform_popup_delay', 1000);
    $popup_behavior = get_option('popform_popup_behavior', 'always');
    // Check if popup should be shown on this page
    if ($display_mode === 'selected') {
        global $post;
        if (!isset($post) || !in_array($post->ID, $selected_pages)) {
            return;
        }
    }
    // If Google Font is specified, inject the link
    $google_font_link = '';
    if (preg_match('/^(Roboto|Inter|Poppins|Lato|Montserrat|Open Sans|Nunito|Oswald|Raleway|Merriweather)/i', $font_family, $matches)) {
        $font_name = str_replace(' ', '+', $matches[1]);
        $google_font_link = '<link href="https://fonts.googleapis.com/css?family=' . $font_name . ':400,600,700&display=swap" rel="stylesheet">';
    }
    if ($form_id && get_post_status($form_id) === 'publish') {
        $shortcode = '[contact-form-7 id="' . intval($form_id) . '"]';
        echo $google_font_link;
        echo '<div id="popform-overlay" class="popform-overlay" data-delay="' . esc_attr($popup_delay) . '" data-behavior="' . esc_attr($popup_behavior) . '">';
        echo '<div class="popform-modal popform-modal-flex" style="font-family:' . esc_attr($font_family) . '; --popform-btn-color-start:' . esc_attr($btn_color_start) . '; --popform-btn-color-end:' . esc_attr($btn_color_end) . ';">';
        if ($image_url) {
            echo '<div class="popform-modal-image"><img src="' . esc_url($image_url) . '" alt="Popup Image" /></div>';
        }
        echo '<div class="popform-modal-content">';
        echo '<button class="popform-close" aria-label="Close"><span class="popform-close-icon"></span></button>';
        echo '<h2>' . esc_html($heading_text) . '</h2>';
        echo '<p>' . esc_html($subheading_text) . '</p>';
        echo do_shortcode($shortcode);
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
add_action('wp_footer', 'popform_display_popup');

// Add admin menu in dashboard
function popform_admin_menu()
{
    add_menu_page(
        'PopForm Settings',
        'PopForm',
        'manage_options',
        'popform-shortcode',
        'popform_settings_page',
        'dashicons-feedback',
        80
    );
}
add_action('admin_menu', 'popform_admin_menu');

// Admin settings page
function popform_settings_page()
{
    if (!current_user_can('manage_options')) return;

    // Save selected form ID and customizations
    if (isset($_POST['popform_cf7_form_id'])) {
        check_admin_referer('popform_save_settings');
        update_option('popform_cf7_form_id', intval($_POST['popform_cf7_form_id']));
        update_option('popform_font_family', sanitize_text_field($_POST['popform_font_family']));
        update_option('popform_heading_text', sanitize_text_field($_POST['popform_heading_text']));
        update_option('popform_subheading_text', sanitize_text_field($_POST['popform_subheading_text']));
        update_option('popform_image_url', esc_url_raw($_POST['popform_image_url']));
        update_option('popform_btn_color_start', sanitize_hex_color($_POST['popform_btn_color_start']));
        update_option('popform_btn_color_end', sanitize_hex_color($_POST['popform_btn_color_end']));
        $display_mode = isset($_POST['popform_display_mode']) && $_POST['popform_display_mode'] === 'selected' ? 'selected' : 'all';
        update_option('popform_display_mode', $display_mode);
        $selected_pages = isset($_POST['popform_selected_pages']) && is_array($_POST['popform_selected_pages']) ? array_map('intval', $_POST['popform_selected_pages']) : [];
        update_option('popform_selected_pages', $selected_pages);
        $popup_delay = isset($_POST['popform_popup_delay']) ? intval($_POST['popform_popup_delay']) : 1000;
        update_option('popform_popup_delay', $popup_delay);
        // Save popup behavior
        $popup_behavior = isset($_POST['popform_popup_behavior']) && in_array($_POST['popform_popup_behavior'], ['once', 'user']) ? $_POST['popform_popup_behavior'] : 'always';
        update_option('popform_popup_behavior', $popup_behavior);
        echo '<div class="updated"><p>Settings saved successfully.</p></div>';
    }

    $selected_form_id = get_option('popform_cf7_form_id');
    $font_family = get_option('popform_font_family', 'inherit');
    $heading_text = get_option('popform_heading_text', "Let's Talk!");
    $subheading_text = get_option('popform_subheading_text', "Fill in your details and we'll get back to you.");
    $image_url = get_option('popform_image_url', '');
    $btn_color_start = get_option('popform_btn_color_start', '#f6d365');
    $btn_color_end = get_option('popform_btn_color_end', '#fda085');
    $display_mode = get_option('popform_display_mode', 'all');
    $selected_pages = get_option('popform_selected_pages', []);
    if (!is_array($selected_pages)) $selected_pages = [];
    $popup_delay = get_option('popform_popup_delay', 1000);
    $popup_behavior = get_option('popform_popup_behavior', 'always');
    $forms = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
    $pages = get_posts([
        'post_type' => 'page',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
?>
    <div class="wrap">
        <h1>PopForm Settings</h1>
        <form method="post">
            <?php wp_nonce_field('popform_save_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="popform_cf7_form_id">Select Contact Form</label></th>
                    <td>
                        <select name="popform_cf7_form_id" id="popform_cf7_form_id" style="width: 400px;">
                            <option value="">-- Select a form --</option>
                            <?php foreach ($forms as $form): ?>
                                <option value="<?php echo esc_attr($form->ID); ?>" <?php selected($selected_form_id, $form->ID); ?>>
                                    <?php echo esc_html($form->post_title); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Choose which Contact Form 7 form to show in the popup.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_font_family">Popup Font Family</label></th>
                    <td>
                        <input type="text" name="popform_font_family" id="popform_font_family" value="<?php echo esc_attr($font_family); ?>" style="width: 400px;" placeholder="e.g. Roboto, Arial, sans-serif">
                        <p class="description">Set the font family for the popup (e.g. Roboto, Arial, sans-serif).</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_heading_text">Popup Heading</label></th>
                    <td>
                        <input type="text" name="popform_heading_text" id="popform_heading_text" value="<?php echo esc_attr($heading_text); ?>" style="width: 400px;">
                        <p class="description">Set the main heading text for the popup.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_subheading_text">Popup Subheading</label></th>
                    <td>
                        <input type="text" name="popform_subheading_text" id="popform_subheading_text" value="<?php echo esc_attr($subheading_text); ?>" style="width: 400px;">
                        <p class="description">Set the subheading text for the popup.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_image_url">Popup Image URL</label></th>
                    <td>
                        <input type="text" name="popform_image_url" id="popform_image_url" value="<?php echo esc_attr($image_url); ?>" style="width: 400px;" placeholder="https://yourdomain.com/wp-content/uploads/your-image.jpg">
                        <p class="description">Provide a WordPress image URL to display in the popup (optional).</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_btn_color_start">Submit Button Color Start</label></th>
                    <td>
                        <input type="color" name="popform_btn_color_start" id="popform_btn_color_start" value="<?php echo esc_attr($btn_color_start); ?>">
                        <p class="description">Select the start color for the submit button gradient.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_btn_color_end">Submit Button Color End</label></th>
                    <td>
                        <input type="color" name="popform_btn_color_end" id="popform_btn_color_end" value="<?php echo esc_attr($btn_color_end); ?>">
                        <p class="description">Select the end color for the submit button gradient.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Show Popup On</th>
                    <td>
                        <label><input type="radio" name="popform_display_mode" value="all" <?php checked($display_mode, 'all'); ?>> All Pages</label><br>
                        <label><input type="radio" name="popform_display_mode" value="selected" <?php checked($display_mode, 'selected'); ?>> Selected Pages</label>
                        <p class="description">Choose whether to show the popup on all pages or only selected pages.</p>
                    </td>
                </tr>
                <tr valign="top" id="popform-selected-pages-row" style="<?php echo ($display_mode === 'selected') ? '' : 'display:none;'; ?>">
                    <th scope="row"><label for="popform_selected_pages">Select Pages</label></th>
                    <td>
                        <select name="popform_selected_pages[]" id="popform_selected_pages" multiple style="width: 400px; height: 120px;">
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo esc_attr($page->ID); ?>" <?php echo in_array($page->ID, $selected_pages) ? 'selected' : ''; ?>><?php echo esc_html($page->post_title); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold Ctrl (Windows) or Cmd (Mac) to select multiple pages.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="popform_popup_delay">Popup Delay (ms)</label></th>
                    <td>
                        <input type="number" name="popform_popup_delay" id="popform_popup_delay" value="<?php echo esc_attr($popup_delay); ?>" min="0" step="100" style="width: 120px;"> ms
                        <p class="description">Set the delay before the popup appears (in milliseconds, e.g., 1000 = 1 second).</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Popup Behavior</th>
                    <td>
                        <label><input type="radio" name="popform_popup_behavior" value="always" <?php checked($popup_behavior, 'always'); ?>> Show always</label><br>
                        <label><input type="radio" name="popform_popup_behavior" value="once" <?php checked($popup_behavior, 'once'); ?>> Show once per session</label><br>
                        <label><input type="radio" name="popform_popup_behavior" value="user" <?php checked($popup_behavior, 'user'); ?>> Show once per user</label>
                        <p class="description">Choose whether to show the popup every time, only once per browser session, or only once per user (browser/device).</p>
                    </td>
                </tr>
            </table>
            <script>
                // Show/hide page select based on radio
                document.addEventListener('DOMContentLoaded', function() {
                    var radios = document.getElementsByName('popform_display_mode');
                    var row = document.getElementById('popform-selected-pages-row');
                    radios.forEach(function(radio) {
                        radio.addEventListener('change', function() {
                            if (this.value === 'selected') {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                });
            </script>
            <?php submit_button(); ?>
        </form>
        <p style="margin-top:20px; font-size:13px; color:#666;">
            Plugin developed by <a href="https://beproblemsolver.com/" target="_blank">Be Problem Solver</a>
        </p>
    </div>
<?php
}
