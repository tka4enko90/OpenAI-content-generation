<?php
namespace MOpenAi\gutenberg;

final class GutenbergBlocks {
    public function __construct()
    {
        add_action('enqueue_block_editor_assets', function() {
            wp_enqueue_script( 'post-title-js', PLUGIN_DIR . '/build/blocks.js', ['wp-blocks', 'wp-element', 'wp-edit-post'] );
            wp_enqueue_style( 'post-title-style', PLUGIN_DIR . '/blocks/title/css/style.css' );
        });
//        add_filter('render_block', function(string $blockContent, array $block): string {
//
//            if ($block['blockName'] !== 'core/post-title') {
//                return $blockContent;
//            }
//            return $blockContent;
//        }, 10, 2 );
    }
}