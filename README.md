# PopForm Shortcode

A WordPress plugin that displays a beautiful, global popup form using a selected Contact Form 7 form. Easily customizable, lightweight, and user-friendly.

## Features

- **Global Popup:** Shows a modal popup on every page of your WordPress site.
- **Flexible Popup Display:** Choose to show the popup on all pages or only on selected pages.
- **Contact Form 7 Integration:** Lets you select any Contact Form 7 form to display in the popup.
- **Modern Design:** Stylish, responsive, and customizable modal with smooth animations, a gradient background, and a transparent blurred overlay.
- **Custom Fonts:** Choose any font family for your popup, including Google Fonts (e.g., Roboto, Inter, Poppins, etc.).
- **Custom Heading & Subheading:** Set your own popup heading and subheading text from the admin settings.
- **Popup Image:** Display a WordPress image (URL) on the left side of the popup for a visually rich experience.
- **Customizable Submit Button:** Select your own gradient color combination for the submit button.
- **Modern Close Button:** Beautiful, accessible, circular close button with a modern icon and hover effect.
- **Easy Admin Settings:** Simple admin interface to select which form to display, customize appearance/text, choose popup display pages, set popup delay, and control popup behavior.
- **No Coding Required:** Just install, configure, and go!

## Requirements

- **WordPress** 5.0 or higher
- **Contact Form 7** plugin installed and activated

## Installation

1. **Download the Plugin:**

   - Download or clone this repository.

2. **Upload to WordPress:**

   - Upload the `popform-shortcode` folder to your WordPress site's `wp-content/plugins/` directory.

3. **Activate:**

   - Go to the WordPress admin dashboard.
   - Navigate to **Plugins** > **Installed Plugins**.
   - Find **PopForm Shortcode** and click **Activate**.

4. **Configure:**
   - In the WordPress admin menu, click on **PopForm**.
   - Select the Contact Form 7 form you want to display in the popup.
   - Set your desired font family (e.g., `Inter, Arial, sans-serif`), heading, subheading, and (optionally) a WordPress image URL.
   - Select your preferred submit button gradient colors using the color pickers.
   - Choose whether to show the popup on all pages or only selected pages. If selected pages, pick from a list of your site's pages.
   - Set the popup delay (in milliseconds) before it appears.
   - Choose popup behavior: show always, once per session, or once per user (browser/device).
   - Save your settings.

## Usage

- The popup will automatically appear based on your settings (all pages or selected pages, after the configured delay).
- Users can close the popup by clicking the modern close button or clicking outside the modal.
- The popup form is fully styled and responsive.
- The popup can be set to show always, only once per session, or only once per user (browser/device).

## Customization

- **Font Family:** Enter any CSS font family in the settings (e.g., `Roboto, Arial, sans-serif`). Popular Google Fonts (e.g., Roboto, Inter, Poppins, etc.) are automatically loaded.
- **Heading & Subheading:** Set your own popup heading and subheading text from the admin settings.
- **Popup Image:** Provide a WordPress image URL to display a visual on the left side of the popup. Leave blank for a text-only popup.
- **Submit Button Colors:** Choose your own gradient color combination for the submit button using the color pickers in the settings.
- **Styling:** The popup features a modern, transparent blurred overlay, rounded modal, and stylish inputs/buttons. You can further modify `style.css` for advanced customizations.
- **Popup Behavior:** Edit `popup.js` to adjust the delay or add more interactivity.

## File Structure

- `popform-shortcode.php` — Main plugin file, handles WordPress hooks, admin menu, popup rendering, and customization options.
- `style.css` — Styles for the popup modal and form, including modern UI enhancements, image support, and customizable button/overlay.
- `popup.js` — Handles popup display logic and user interactions.

## Credits

- Developed by [Be Problem Solver](https://beproblemsolver.com/)

## New Features (v1.3 or later)

- **Page Selection:** Show popup on all or selected pages.
- **Popup Delay:** Set delay before popup appears.
- **Popup Behavior:** Show always, once per session, or once per user.
- **Setting:** Overall setting availble.
