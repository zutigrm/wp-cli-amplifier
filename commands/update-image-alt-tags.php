<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Bulk_Update_Empty_Image_Alt_Tags_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Bulk update image alt tags in the media library for images with empty alt tags.
         *
         * ## OPTIONS
         *
         * <alt_tag_prefix>
         * : The prefix for the new alt tag. The image filename (without extension) will be appended to the prefix.
         *
         * ## EXAMPLES
         *
         *     wp buiat update_empty_alt_tags "My Website - "
         */
        public function update_empty_alt_tags($args)
        {
            list($alt_tag_prefix) = $args;

            $images = get_posts([
                'post_status' => 'any',
                'post_type'   => 'attachment',
                'post_mime_type' => 'image',
                'numberposts' => -1,
            ]);

            $count = 0;

            foreach ($images as $image) {
                $current_alt_tag = get_post_meta($image->ID, '_wp_attachment_image_alt', true);
                if (empty($current_alt_tag)) {
                    $image_filename = pathinfo(get_attached_file($image->ID), PATHINFO_FILENAME);
                    $new_alt_tag = $alt_tag_prefix . $image_filename;
                    update_post_meta($image->ID, '_wp_attachment_image_alt', $new_alt_tag);
                    $count++;
                }
            }

            WP_CLI::success("Updated alt tags for {$count} images with empty alt tags.");
        }
    }
}