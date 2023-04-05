<?php

/*
 * Plugin Settings Page
 */

namespace MOpenAi\admin;

/**
 * Class MOpenAIAdminSettingsPage
 * @package MOpenAi\admin
 */

class MOpenAIAdminSettingsPage
{

    private $settings;

    /**
     * MOpenAIAdminSettingsPage constructor.
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'admin_page_init'));
    }


    /**
     * Register Menu Page
     *
     * @return void
     */
    
    public function add_plugin_page()
    {

        add_menu_page(
            'OpenAI Generation Settings',
            'OpenAI Generation Settings',
            'edit_theme_options',
            'mopenai_options',
            array($this, 'mopenai_render_options_page')
        );

    }


    /**
     * Render Menu Page
     *
     * @return void
     */
    
    public function mopenai_render_options_page()
    {
        $this->settings = get_option('mopenai_option_group'); ?>

        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <?php settings_errors(); ?>

            <form action="options.php" method="POST">
                <?php
                settings_fields( 'mopenai_option_group' );
                do_settings_sections( 'mopenai_opts' );
                submit_button();
                ?>
            </form>
        </div>

    <?php }


    public function admin_page_init()
    {
        register_setting(
            'mopenai_option_group',
            'mopeanai_setting'
        );

        add_settings_section(
            'mopenai_settings_section',
            __('Setting Plugin Options', 'mopenai'),
            '',
            'mopenai_opts' );

        add_settings_field('mopenai_api_token', __('API token', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_api_token']);
        add_settings_field('mopenai_model', __('Model', 'mopenai'), array( $this, 'model_field' ), 'mopenai_opts', 'mopenai_settings_section', ['id' => 'mopenai_model']);
        add_settings_field('mopenai_temperature', __('Temperature', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_temperature']);
        add_settings_field('mopenai_max_tokens', __('Parameter "max_tokens"', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_max_tokens']);
        add_settings_field('mopenai_top_p', __('Parameter "top_p"', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_top_p']);
        add_settings_field('mopenai_best_of', __('Parameter "best_of"', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_best_of']);
        add_settings_field('mopenai_frequency_penalty', __('Parameter "frequency_penalty"', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_frequency_penalty']);
        add_settings_field('mopenai_presence_penalty', __('Parameter "presence_penalty"', 'mopenai'), array($this, 'mopenai_render_field'), 'mopenai_opts', 'mopenai_settings_section',['id' => 'mopenai_presence_penalty']);
    }


    /**
     * @param $args
     */
    public function mopenai_render_field($args)
    {
        $option_name = "mopeanai_setting";
        $val = get_option($option_name);
        $val = isset($val[$args['id']]) ? $val[$args['id']] : null; ?>
        <input type="text" name="mopeanai_setting[<?php echo $args['id']?>]" value="<?php echo esc_attr( $val ) ?>">

    <?php }

    /**
     * @param $args
     */
    public function model_field($args)
    {
        $option_name = "mopeanai_setting";
        $val = get_option($option_name);
        $val = isset($val['mopenai_model']) ? $val['mopenai_model'] : 'gpt-3.5-turbo'; ?>
        <select name="mopeanai_setting[mopenai_model]" >
            <option <?php selected( $val, 'gpt-3.5-turbo', true ); ?> value="gpt-3.5-turbo" > gpt-3.5-turbo</option>
            <option <?php selected( $val, 'text-davinci-003', true ); ?> value="text-davinci-003" > text-davinci-003</option>
        </select>

        <?php

    }


}