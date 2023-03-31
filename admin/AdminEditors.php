<?php
namespace  MOpenAi\admin;

class AdminEditors {
    public function __construct()
    {
        add_action('post_submitbox_start', array($this, 'custom_button'));

    }
    public function custom_button() {
        ob_start(); ?>
            <div id="custom-button">
            <button class="button button-primary">Custom Button</button>
            </div>
        <?php echo ob_get_clean();
    }
}