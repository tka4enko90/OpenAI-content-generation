<?php

add_action('admin_menu','mopenai_add_options_page');
function mopenai_add_options_page(){
    add_menu_page(
            'OpenAI Generation Settings', 
            'OpenAI Generation Settings', 
            'edit_theme_options', 
            'mopenai_options', 
            'mopenai_render_options_page');
}

function mopenai_render_options_page(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>

        <h3>Current PHP version: <?php echo phpversion(); ?></h3>

        <form action="options.php" method="POST">
            <?php
            settings_fields( 'option_group' );
            do_settings_sections( 'mopenai_opts' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'mopenai_option_settings');
function mopenai_option_settings(){
    register_setting( 'option_group', 'option_name1', 'mopenai_callback' );
    register_setting( 'option_group', 'option_name2', 'mopenai_callback' );

    add_settings_section( 'mopenai_section_id', __('Setting Plugin Options', 'mopenai'), '', 'mopenai_opts' );

    add_settings_field('mopenai_api_token', 'API token', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 1] );
    add_settings_field('mopenai_model', 'model', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 2] );
    add_settings_field('mopenai_temperature', 'temperature', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 3] );
    add_settings_field('mopenai_max_tokens', 'max_tokens', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 4] );
    add_settings_field('mopenai_top_p', 'top_p', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 5] );
    add_settings_field('mopenai_best_of', 'best_of', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 6] );
    add_settings_field('mopenai_frequency_penalty', 'frequency_penalty', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 7] );
    add_settings_field('mopenai_presence_penalty', 'presence_penalty', 'mopenai_render_field', 'mopenai_opts', 'mopenai_section_id',['id' => 8] );
}

function mopenai_render_field($args){

    $option_name = "option_name" . $args['id'];
    $val = get_option($option_name);
    $val = $val['input'] ?? null;
    ?>
    <input type="text" name="option_name<?php echo $args['id']?>[input]" value="<?php echo esc_attr( $val ) ?>" />
    <?php
}

function mopenai_callback( $options ){
    foreach( $options as $name => & $val ){
        if( $name == 'input' ){
            $val = strip_tags( $val );
        }
    }

    return $options;
}