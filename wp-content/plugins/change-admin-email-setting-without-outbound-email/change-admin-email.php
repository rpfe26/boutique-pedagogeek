<?php
/*
Plugin Name: Change Admin Email Setting Without Outbound Email
Plugin URI: https://generalchicken.guru/change-admin-email/
Description: Restores functionality removed since WordPress v4.9. Allows admin to change the admin email setting - without having outbound email enabled on the site, or recipient email credentials.
Version: 4.1
Author: John Dee
Author URI: https://generalchicken.guru/
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

namespace ChangeAdminEmail;

$ChangeAdminEmailPlugin = new ChangeAdminEmailPlugin;
$ChangeAdminEmailPlugin->run();

class ChangeAdminEmailPlugin
{
    public function verifyNonce()
    {
        if ( ! isset( $_POST['change-admin-email-test-email-nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['change-admin-email-test-email-nonce'] ) ), 'change-admin-email-action' ) ) {
            wp_die('Nonce failed. Something is wrong here.');
        }
    }

    public function removePendingEmail()
    {
        \delete_option("adminhash");
        \delete_option("new_admin_email");
    }

    public function run()
    {
        add_action('init', array($this, 'removePendingEmail'));
        add_action('admin_notices', [new AdminNotice(), 'displayAdminNotice']);

        remove_action('add_option_new_admin_email', 'update_option_new_admin_email');
        remove_action('update_option_new_admin_email', 'update_option_new_admin_email');

        add_filter('send_site_admin_email_change_email', function () {
            return false;
        }, 10, 3);

        if (isset($_POST['change-admin-email-test-email-nonce'])) {
            add_action('init', array($this, 'verifyNonce'));
            add_action('init', array($this, 'testEmail'));
        }

        add_action("init", function () {
            if (current_user_can('manage_options')) {
                add_action('add_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2);
                add_action('update_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2);
            }
        });

        add_action('current_screen', array($this, 'modifyOptionsGeneralForm'));
    }

    public function testEmail()
    {
        $email = sanitize_email( wp_unslash( $_POST['new_admin_email'] ) );
        $domain = site_url();
        $url = "https://generalchicken.guru/wp-json/change-admin-email-plugin/v1/test-email";
        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'body' => array(
                'email' => $email,
                'domain' => $domain,
            ),
        ));

        AdminNotice::displaySuccess(__('Check your email inbox. A test message has been sent to you.'));
    }

    public function updateOptionAdminEmail($old_value, $value)
    {
        update_option('admin_email', sanitize_email( $value ));
    }

    public function modifyOptionsGeneralForm()
    {
        $screen = \get_current_screen();

        if ($screen->base === "options-general") {
            \wp_register_script(
                'change-admin-email',
                \plugin_dir_url(__FILE__) . 'change-admin-email.js',
                ['jquery'],
                '1.0',
                true
            );
            \wp_enqueue_script('change-admin-email');
            \wp_localize_script(
                'change-admin-email',
                'change_admin_email_data',
                array(
                    'nonce' => \wp_create_nonce("change-admin-email-action"),
                )
            );
        }
    }
}

class AdminNotice
{
    const NOTICE_FIELD = 'my_admin_notice_message';

    public static function displayError($message)
    {
        self::updateOption($message, 'notice-error');
    }

    protected static function updateOption($message, $noticeLevel)
    {
        update_option(self::NOTICE_FIELD, [
            'message' => sanitize_text_field( $message ),
            'notice-level' => sanitize_text_field( $noticeLevel )
        ]);
    }

    public static function displayWarning($message)
    {
        self::updateOption($message, 'notice-warning');
    }

    public static function displayInfo($message)
    {
        self::updateOption($message, 'notice-info');
    }

    public static function displaySuccess($message)
    {
        self::updateOption($message, 'notice-success');
    }

    public function displayAdminNotice()
    {
        $option = get_option(self::NOTICE_FIELD);
        $message = isset($option['message']) ? esc_html($option['message']) : false;
        $noticeLevel = !empty($option['notice-level']) ? esc_attr($option['notice-level']) : 'notice-error';

        if ($message) {
            echo "<div class='notice {$noticeLevel} is-dismissible'><p>{$message}</p></div>";
            delete_option(self::NOTICE_FIELD);
        }
    }
}
