<?php

namespace Woocommerce_Preorders;

class Bootstrap
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueueStyles']);
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueueScripts']);
        add_action('wp_enqueue_scripts', [$this, 'frontEnqueueStyles']);
        add_action('wp_enqueue_scripts', [$this, 'frontEnqueueScripts']);

        $this->generatePreOrderStatus();

        // add_action('woocommerce_thankyou', [$checkout, 'checkGeneratedOrderStatus']);
        $this->initializeCheckout();
        $this->initializeSync();
        $this->initializeTabs();
        $this->initializeNotices();
        $this->initializeSettings();
        $this->initializeShop();
        $this->initializeOrder();
    }

    public function defaultOptions()
    {
        $defaultOptions = [
            'wc_preorders_button_text' => 'Pre Order Now!',
            'wc_preorders_change_button' => 'yes',
            'wc_preorders_always_choose_date' => 'yes',
            'wc_preorders_mode' => 'either',
            'wc_preorders_multiply_shipping' => 'no',
            'wc_preorders_license_email' => '',
            'wc_preorders_license_key' => '',
            'wc_preorders_is_pro' => 'no',
        ];

        foreach ($defaultOptions as $option => $value) {
            if (!get_option($option) || '' === get_option($option)) {
                add_option($option, $value);
            }
        }
    }

    public function adminEnqueueScripts()
    {
        wp_enqueue_script(
            'preorders-field-date-js',
            WCPO_PLUGIN_URL.'media/js/date-picker.js',
            ['jquery', 'jquery-ui-core', 'jquery-ui-datepicker'],
            WCPO_PLUGIN_VER,
            true
        );
    }

    public function frontEnqueueStyles()
    {
        wp_register_style('woocommerce-pre-orders-main-css', WCPO_PLUGIN_URL.'media/css/main.css',null,WCPO_PLUGIN_VER);
        wp_enqueue_style('woocommerce-pre-orders-main-css');
        wp_enqueue_style('jquery-ui');

    }

    public function frontEnqueueScripts()
    {
        wp_enqueue_script(
            'preorders-field-date-js',
            WCPO_PLUGIN_URL.'media/js/date-picker.js',
            ['jquery', 'jquery-ui-core', 'jquery-ui-datepicker'],
            WCPO_PLUGIN_VER,
            true
        );

        $data = [
            'default_add_to_cart_text' => __('Add to cart', 'woocommerce'),
            'preorders_add_to_cart_text' => get_option('wc_preorders_button_text'),
        ];

        wp_register_script(
            'preorders-main-js',
            WCPO_PLUGIN_URL.'media/js/main.js',
            ['jquery'],
            WCPO_PLUGIN_VER,
            true
        );

        wp_localize_script('preorders-main-js', 'DBData', $data);

        wp_enqueue_script(
            'preorders-main-js'
        );
    }

    public function adminEnqueueStyles()
    {
        wp_enqueue_style('jquery-ui');
    }

    public function generatePreOrderStatus()
    {
        $statusManager = new StatusManager([
            'statusName' => 'pre-ordered',
            'label' => 'Pre Ordered',
            'labelCount' => _n_noop('Pre Ordered <span class="count">(%s)</span>', 'Pre Ordered <span class="count">(%s)</span>', 'preorders'),
        ]);
        $statusManager->save();
    }

    public function initializeCheckout()
    {
        new Checkout();
    }

    public function initializeSync()
    {
        new Sync();
    }

    public function initializeTabs()
    {
        new Tabs();
    }

    public function initializeNotices()
    {
        new Notices();
    }

    public function initializeSettings()
    {
        new Settings();
    }

    public function initializeShop()
    {
        new Shop();
    }

    public function initializeOrder()
    {
        new Order();
    }
}
