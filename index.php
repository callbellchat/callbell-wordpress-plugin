<?php
/**
 * Plugin Name: Callbell Chat Widget
 * Description: Handle user conversations through Facebook Messenger, WhatsApp, Instagram Direct and Telegram.
 * Version: 0.1.0
 * Author: Callbell
 * Author URI: https://www.callbell.eu
 */
register_uninstall_hook(__FILE__, 'callbell_plugin_cleanup');
add_action('admin_menu', 'callbell_create_menu');

function callbell_plugin_cleanup() {
  delete_option('callbell-script-token');
  delete_option('callbell-onboarding');
}

function callbell_create_menu() {
  add_menu_page(__('Callbell', 'callbell'), __('Callbell', 'callbell'), 'administrator', __FILE__, 'callbell_settings_page', 'https://res.cloudinary.com/callbell-eu/image/upload/v1557608928/logo/callbell-icon-only.svg');
  add_action('admin_init', 'callbell_register_settings');
  add_action('admin_init', 'callbell_onboarding');
}

function callbell_register_settings() {
  register_setting('callbell', 'callbell-script-token');
  add_option('callbell-onboarding', false);
}

function callbell_onboarding() {
  $onboarding = get_option('callbell-onboarding');
  $script_token = get_option('callbell-script-token');

  if ((empty($onboarding) || !$onboarding)) {
    wp_redirect('admin.php?page=' . plugin_basename(__FILE__));
    update_option('callbell-onboarding', true);
  }
}

function callbell_settings_page() {
  $email = urlencode(wp_get_current_user()->user_email);

  ?>
    <div class="card">
      <a href="https://www.callbell.eu?utm_source=wordpress" target="_blank" rel="noopener">
        <img style="margin-left: -13px;" src="https://res.cloudinary.com/callbell-eu/image/upload/v1557078358/logo/logo.png" width="180"/>
      </a>
      <? settings_errors(); ?>
      <h3>Settings</h3>
      <p>1. Create a free account on <a href="https://dash.callbell.eu/users/sign_up?utm_source=wordpress&email=<? echo $email; ?>" target="_blank" rel="noopener">Callbell Dashboard</a></p>
      <p>2. Copy and paste the code in the text area below:</p>

      <form action="options.php" method="POST">
        <?
          echo settings_fields('callbell');
          echo do_settings_sections('callbell');
          ?>
        <textarea name="callbell-script-token" id="callbell-script-token" cols="60" rows="20"><? echo esc_attr(get_option('callbell-script-token')) ?></textarea>
        <br>
        <? submit_button(); ?>
      </form>
    </div>
  <?
}

function callbell_javascript_block() {
  echo get_option('callbell-script-token');
}

add_action('wp_head', 'callbell_javascript_block', 1);