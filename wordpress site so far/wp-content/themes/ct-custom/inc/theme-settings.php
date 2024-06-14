<?php

$ct_sections = [
    'section-theme-settings' => [
        'title'  => 'General theme settings'
    ],
    'section-social-settings' => [
        'title'  => 'Social media profiles'
    ]
];

$ct_fields = [
    'ct-logo' => [
        'title'    => 'Default logo',
        'type'     => 'upload',
        'section'  => 'section-theme-settings',
        'default'  => '',
        'desc'     => 'Set your default logo. Upload or choose an existing one.',
        'sanitize' => ''
    ],
    'ct-phone' => [
        'title'    => 'Phone number',
        'type'     => 'text',
        'section'  => 'section-theme-settings',
        'default'  => '385.154.11.28.35',
        'desc'     => 'Enter your phone number.',
        'sanitize' => 'default'
    ],
    'ct-tax' => [
        'title'    => 'Tax Number',
        'type'     => 'text',
        'section'  => 'section-theme-settings',
        'default'  => '385.154.35.66.78',
        'desc'     => 'Enter your tax number.',
        'sanitize' => 'default'
    ],
    'ct-address' => [
        'title'    => 'Address',
        'type'     => 'text',
        'section'  => 'section-theme-settings',
        'default'  => '535 La Plata Street, 4200 Argentina',
        'desc'     => 'Enter your address.',
        'sanitize' => 'default'
    ],
    'ct-social-twitter' => [
        'title'    => 'Twitter Profile',
        'type'     => 'text',
        'section'  => 'section-social-settings',
        'default'  => 'https://x.com/',
        'desc'     => '',
        'sanitize' => 'full'
    ],
    'ct-social-facebook' => [
        'title'    => 'Facebook Profile',
        'type'     => 'text',
        'section'  => 'section-social-settings',
        'default'  => 'https://www.facebook.com/',
        'desc'     => '',
        'sanitize' => 'full'
    ],
    'ct-social-linkedin' => [
        'title'    => 'Linkedin Profile',
        'type'     => 'text',
        'section'  => 'section-social-settings',
        'default'  => 'https://www.linkedin.com/',
        'desc'     => '',
        'sanitize' => 'full'
    ],
    'ct-social-pinterest' => [
        'title'    => 'Pinterest Profile',
        'type'     => 'text',
        'section'  => 'section-social-settings',
        'default'  => 'https://www.pinterest.com',
        'desc'     => '',
        'sanitize' => 'full'
    ]
];

add_action('after_setup_theme', 'ct_init_option');
add_action('admin_menu', 'ct_update_menu');
add_action('admin_init', 'ct_init_settings');

/**
 * Renders a section based on its arguments.
 *
 * @param array $args The arguments for the section.
 */
function ct_render_section($args)
{
    // Get the global sections array.
    global $ct_sections;

    // Render the section using the arguments.
}

/**
 * Renders a field based on its type.
 *
 * @param string $id The ID of the field.
 */
function ct_render_field($id)
{
    global $ct_fields;

    // Get the options for the theme settings
    $options = get_option('ct_options');

    // Get the value of the field or the default value if it's not set
    $field_value = isset($options[$id]) ? $options[$id] : ct_get_field_default($id);

    // Render the field based on its type
    if ('text' == $ct_fields[$id]['type']) {
        // Render a text field
        echo "<input type='text' name='ct_options[" . $id . "]' value='" . $field_value . "' />";
        echo "<p class='description'>" . $ct_fields[$id]['desc'] . "</p>";
    } elseif ('upload' == $ct_fields[$id]['type']) {
        // Render an upload field
        $visibility_class = ('' != $field_value) ? "" : "hide";
        echo "<img src='" . $field_value . "' alt='Logo' class='ct-custom-thumbnail " . $visibility_class . "' id='" . $id . "-thumbnail' />";
        echo "<input type='hidden' name='ct_options[" . $id . "]' id='" . $id . "-upload-field' value='" . $field_value . "' />";
        echo "<input type='button' class='btn-upload-img button' value='Upload logo' data-field-id='" . $id . "' />";
        echo "<input type='button' class='btn-remove-img button " . $visibility_class . "' value='Remove logo' data-field-id='" . $id . "' id='" . $id . "-remove-button' />";
        echo "<p class='description'>" . $ct_fields[$id]['desc'] . "</p>";
    }
}

/**
 * Render the theme settings page.
 *
 * This function is used to display the theme settings page in the WordPress admin area.
 * It checks if the user has sufficient permissions to access the page and displays
 * the necessary HTML markup and form fields.
 */
function ct_render_theme_options()
{
    // Check if the user has sufficient permissions to access the page
    if (!current_user_can('manage_options')) {
        // If not, display an error message and terminate the function
        wp_die('You do not have sufficient permissions to access this page.');
    }

    // Start the HTML markup for the theme settings page
?>
    <div class="wrapper">
        <h1>Theme Settings</h1>

        <?php
        // Display any errors or notices related to the theme settings
        settings_errors();
        ?>

        <form action="options.php" method="post">
            <?php
            // Register the settings for the theme settings page
            settings_fields("ct_options");

            // Display the sections and fields for the theme settings
            do_settings_sections("ct-theme-options");

            // Display the submit button for the form
            submit_button();
            ?>
        </form>
    </div>
<?php
}

function ct_options_validate($input)
{
    // Define a blank array for the output.
    $output = [];

    /**
     * Validate and sanitize the input fields from the theme settings.
     *
     * @param array $input The input fields from the theme settings.
     * @return array The sanitized output fields.
     */
    // Do a general sanitization for every field.
    foreach ($input as $key => $value) {
        // Grab the sanitize option for this field.
        $field_sanitize = ct_get_field_sanitize($key);

        switch ($field_sanitize) {
            case 'default':
                // Remove HTML tags and backslashes from the input.
                $output[$key] = strip_tags(stripslashes($input[$key]));
                break;

            case 'full':
                // Remove HTML tags, backslashes and URLs from the input.
                $output[$key] = esc_url_raw(strip_tags(stripslashes($input[$key])));
                break;
            default:
                // If the sanitize option is not defined, return the input as is.
                $output[$key] = $input[$key];
                break;
        }
    }

    return $output;
}

function ct_get_field_default($id)
{
    global $ct_fields;

    return $ct_fields[$id]['default'];
}

function ct_init_option()
{
    $options = get_option('ct_options');

    if (false === $options) {
        add_option('ct_options');
    }
}

/**
 * Adds a menu page for the theme settings.
 *
 * Registers a new menu page for the theme settings under the "Theme Settings"
 * title. The menu page can only be accessed by users with the 'manage_options'
 * capability. The function 'ct_render_theme_options' is used to render the
 * content of the page.
 */
function ct_update_menu()
{
    // Adds a menu page for the theme settings.
    add_menu_page(
        'Theme Settings', // The text to be displayed in the title tags of the page when viewed in a browser.
        'Theme Settings', // The text to be used for the menu.
        'manage_options', // The capability required for this menu to be displayed to the user.
        'ct-theme-options', // The slug name to refer to this menu by (should be unique for this menu).
        'ct_render_theme_options' // The function to be called to output the content for this page.
    );
}

/**
 * Initialize the theme settings.
 *
 * Registers the theme settings, sections, and fields.
 *
 * @global array $ct_fields The array of theme fields.
 * @global array $ct_sections The array of theme sections.
 */
function ct_init_settings()
{
    global $ct_fields, $ct_sections;

    // Register the theme settings
    register_setting("ct_options", "ct_options", "ct_options_validate");

    // Add the theme sections
    foreach ($ct_sections as $section_id => $section_value) {
        add_settings_section(
            $section_id, // The ID of the section.
            $section_value['title'], // The title of the section.
            "ct_render_section", // The function to render the section.
            "ct-theme-options" // The slug name for this section.
        );
    }

    // Add the theme fields
    foreach ($ct_fields as $field_id => $field_value) {
        add_settings_field(
            $field_id, // The ID of the field.
            $field_value['title'], // The title of the field.
            "ct_render_field", // The function to render the field.
            "ct-theme-options", // The slug name for this field.
            $field_value['section'], // The section ID for this field.
            $field_id // The ID of the field.
        );
    }
}

/**
 * Retrieves the sanitization function for a specific field.
 *
 * @param string $id The ID of the field.
 * @return string The sanitization function for the field.
 */
function ct_get_field_sanitize($id)
{
    global $ct_fields;

    // Retrieve the sanitization function for the field.
    // The function is stored in the $ct_fields array.
    return $ct_fields[$id]['sanitize'];
}
