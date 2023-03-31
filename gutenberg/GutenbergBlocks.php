<?php
namespace MOpenAi\gutenberg;

final class GutenbergBlocks {
    public function __construct()
    {
        add_action('enqueue_block_editor_assets', function() {
            wp_enqueue_script( 'post-title-js', PLUGIN_DIR . '/build/blocks.js', ['wp-blocks', 'wp-element', 'wp-edit-post'] );
            wp_enqueue_style( 'post-title-style', PLUGIN_DIR . '/blocks/mopen-ai-sidebar/css/style.css' );
        });
    }
}