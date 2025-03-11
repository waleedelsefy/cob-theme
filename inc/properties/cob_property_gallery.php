<?php
function my_add_attached_images_meta_box() {
    $screens = array( 'post', 'properties', 'factory', 'page' );
    add_meta_box(
        'cob_gallery_images_meta_box',
        __( 'gallery Images', 'my_theme' ),
        'cob_gallery_images_meta_box_callback',
        $screens,
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'my_add_attached_images_meta_box' );

/**
 * عرض الميتا بوكس في شاشة التحرير.
 *
 * @param WP_Post $post المنشور الحالي.
 */
function cob_gallery_images_meta_box_callback( $post ) {
    wp_nonce_field( 'cob_gallery_images_nonce_action', 'cob_gallery_images_nonce' );

    $attachments = get_attached_media( 'image', $post->ID );
    ?>
    <div id="attached-images-wrapper">
        <ul id="attached-images">
            <?php if ( ! empty( $attachments ) ) : ?>
                <?php foreach ( $attachments as $attachment ) :
                    $thumb = wp_get_attachment_image_url( $attachment->ID, 'thumbnail' );
                    if ( ! $thumb ) {
                        continue;
                    }
                    ?>
                    <li data-attachment-id="<?php echo esc_attr( $attachment->ID ); ?>">
                        <img src="<?php echo esc_url( $thumb ); ?>" alt="">
                        <button type="button" class="detach-image-button" data-attachment-id="<?php echo esc_attr( $attachment->ID ); ?>">×</button>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <button id="add-attached-images" class="button"><?php esc_html_e( 'Add Images', 'my_theme' ); ?></button>
    </div>
    <style>
        #attached-images { list-style: none; margin: 0; padding: 0; overflow: auto; }
        #attached-images li { float: left; margin: 5px; position: relative; cursor: move; }
        #attached-images li img { max-width: 100px; height: auto; display: block; }
        .detach-image-button {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #9f0303;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            padding: 2px 5px;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $("#attached-images").sortable();
            $('#add-attached-images').on('click', function(e) {
                e.preventDefault();
                if ( frame ) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: '<?php echo esc_js( __( 'Select Images', 'my_theme' ) ); ?>',
                    button: { text: '<?php echo esc_js( __( 'Attach Images', 'my_theme' ) ); ?>' },
                    multiple: true
                });
                frame.on('select', function() {
                    var selection = frame.state().get('selection').map(function(attachment) {
                        return attachment.toJSON();
                    });
                    selection.forEach(function(attachment) {
                        var att = wp.media.attachment( attachment.id );
                        att.fetch().then(function() {
                            att.save({ post_parent: <?php echo $post->ID; ?> });
                        });
                        $('#attached-images').append(
                            '<li data-attachment-id="' + attachment.id + '"><img src="' + attachment.sizes.thumbnail.url + '" alt="" /><button type="button" class="detach-image-button" data-attachment-id="' + attachment.id + '">×</button></li>'
                        );
                    });
                });
                frame.open();
            });

            $('#attached-images').on('click', '.detach-image-button', function(e) {
                e.preventDefault();
                var btn = $(this);
                var attachmentID = btn.data('attachment-id');
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'my_detach_image',
                        attachment_id: attachmentID,
                        post_id: <?php echo $post->ID; ?>,
                        nonce: '<?php echo wp_create_nonce( "my_detach_image_nonce" ); ?>'
                    },
                    success: function(response) {
                        if ( response.success ) {
                            btn.closest('li').remove();
                        } else {
                            alert( 'Error detaching image.' );
                        }
                    }
                });
            });
        });
    </script>
    <?php
}

/**
 * AJAX handler to detach an image (set its post_parent to 0).
 */
function my_detach_image_ajax() {
    check_ajax_referer( 'my_detach_image_nonce', 'nonce' );
    $attachment_id = intval( $_POST['attachment_id'] );
    $result = wp_update_post( array(
        'ID'          => $attachment_id,
        'post_parent' => 0
    ) );
    if ( $result ) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action( 'wp_ajax_my_detach_image', 'my_detach_image_ajax' );
