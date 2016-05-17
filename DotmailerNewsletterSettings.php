<?php
/**
* Plugin Name: dotmailer Newsletter
* Description: Integrates dotmailer API functionality with WordPress.
* Version: 1.0
* Author: Web-Feet.co.uk Ltd
* Author URI: https://www.web-feet.co.uk
**/

require( 'DotmailerNewsletterWidget.php' );

class DotmailerNewsletterSettings {
	/**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Dotmailer Settings', 
            'manage_options', 
            'dotmailer-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'dotmailer_option_name' );
        ?>
        <div class="wrap">
            <h2>dotmailer Newsletter Plugin</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'dotmailer_option_group' );   
                do_settings_sections( 'dotmailer-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'dotmailer_option_group', // Option group
            'dotmailer_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'dotmailer API Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'dotmailer-setting-admin' // Page
        );    

        add_settings_field(
            'dotmailer_username', 
            'Username', 
            array( $this, 'dotmailer_username_callback' ), 
            'dotmailer-setting-admin', 
            'setting_section_id'
        );

        add_settings_field(
            'dotmailer_password', 
            'Password', 
            array( $this, 'dotmailer_password_callback' ), 
            'dotmailer-setting-admin', 
            'setting_section_id'
        );

        add_settings_field(
            'dotmailer_address_book_id', 
            'Address Book ID', 
            array( $this, 'dotmailer_address_book_id_callback' ), 
            'dotmailer-setting-admin', 
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['dotmailer_username'] ) )
            $new_input['dotmailer_username'] = sanitize_text_field( $input['dotmailer_username'] );

        if( isset( $input['dotmailer_password'] ) )
            $new_input['dotmailer_password'] = sanitize_text_field( $input['dotmailer_password'] );

        if( isset( $input['dotmailer_address_book_id'] ) )
            $new_input['dotmailer_address_book_id'] = sanitize_text_field( $input['dotmailer_address_book_id'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function dotmailer_username_callback()
    {
        printf(
            '<input type="text" id="dotmailer_username" name="dotmailer_option_name[dotmailer_username]" value="%s" />',
            isset( $this->options['dotmailer_username'] ) ? esc_attr( $this->options['dotmailer_username']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function dotmailer_password_callback()
    {
        printf(
            '<input type="password" id="dotmailer_password" name="dotmailer_option_name[dotmailer_password]" value="%s" />',
            isset( $this->options['dotmailer_password'] ) ? esc_attr( $this->options['dotmailer_password']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function dotmailer_address_book_id_callback()
    {
        printf(
            '<input type="text" id="dotmailer_address_book_id" name="dotmailer_option_name[dotmailer_address_book_id]" value="%s" />',
            isset( $this->options['dotmailer_address_book_id'] ) ? esc_attr( $this->options['dotmailer_address_book_id']) : ''
        );
    }
}

if( is_admin() ) {
    $my_settings_page = new DotmailerNewsletterSettings();
}