<?php
/*
 * TINYMCE CUSTOMIZATIONS
 */

function add_largo_mce_plugin( $plugin_array ) {
    $plugin_array['modulize'] = get_template_directory_uri() . '/js/tinymce/plugins/largo/editor_plugin.js';
    return $plugin_array;
}

function register_largo_mce_buttons( $buttons ) {
    array_push( $buttons, '|', 'modulize' );
    return $buttons;
}

function largo_add_mce_buttons() {
    if ( get_user_option( 'rich_editing' ) == 'true' ) {
        add_filter( 'mce_external_plugins', 'add_largo_mce_plugin', 4 );
        add_filter( 'mce_buttons', 'register_largo_mce_buttons', 4 );
    }
}
add_action( 'init', 'largo_add_mce_buttons' );

/*
 * EDITOR MARKUP CUSTOMIZATIONS
 */

function module_shortcode( $atts, $content, $code ) {
    extract( shortcode_atts( array(
        'align' => 'left',
        'width' => 'half',
        'type' => 'aside',
    ), $atts ) );

    return sprintf( '<aside class="module %s %s %s">%s</aside>', $type, $align, $width, $content );
}
add_shortcode( 'module', 'module_shortcode' );

// MOVE THE AUTHOR METABOX INTO THE PUBLISH METABOX
function move_author_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="padding: 8px 10px;">Author: ';
    post_author_meta_box( $post );
    echo '</div>';
}
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );

// REMOVE META BOXES FROM DEFAULT POSTS SCREEN
function remove_default_post_screen_metaboxes() {
	remove_meta_box( 'trackbacksdiv','post','normal' ); // trackbacks
	remove_meta_box( 'slugdiv','post','normal' ); // slug
	remove_meta_box( 'revisionsdiv','post','normal' ); // revisions
	remove_meta_box( 'authordiv', 'post', 'normal' ); // author
	remove_meta_box( 'commentsdiv','post','normal' ); // comments
}
add_action('admin_menu','remove_default_post_screen_metaboxes');
