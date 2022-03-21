<?php
namespace WPNightly;

/**
 * Class Settings
 */
class Main {

    /**
     * The main instance var.
     */
    private static $instance;

    /**
     * Initialize the class
     */
    public function init() {
        if ( !is_admin() ) {
            add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
        }
    }

    /**
     * Enqueue
     */
    public function enqueue_scripts() {
        wp_enqueue_script( "wp-nightly", WP_NIGHTLY_PLUGIN_ASSETS . '/js/nightly.js', false, WP_NIGHTLY_VERSION, true );

        wp_localize_script(
            'wp-nightly',
            'wpNightlyParams',
            [
                'admin_url'  => esc_url( admin_url() ),
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
                'assetsPath' => WP_NIGHTLY_PLUGIN_ASSETS,
                'version'    => WP_NIGHTLY_VERSION,
                'options'    => wp_nightly_options(),
            ]
        );
    }

    /*
     * his is the static method that controls the access to the singleton instance.
     */
    public static function instance() {
        if ( !isset( self::$instance ) && !( self::$instance instanceof Main ) ) {
            self::$instance = new Main;
            self::$instance->init();
        }

        return self::$instance;
    }

    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @access  public
     * @since   1.0.0
     *
     * @return void
     */
    public function __clone() {
        // Cloning instances of the class is forbidden.
        _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0.0' );
    }

    /**
     * Disable unserializing of the class
     *
     * @access  public
     * @since   1.0.0
     *
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden.
        _doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '1.0.0' );
    }

}

Main::instance();