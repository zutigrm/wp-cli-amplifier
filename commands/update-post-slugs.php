<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Bulk_Update_Post_Slugs_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Bulk update post slugs based on their titles for a specific post type.
         *
         * ## OPTIONS
         *
         * <post_type>
         * : The post type for which to update the slugs.
         *
         * ## EXAMPLES
         *
         *     wp bus update_slugs post
         */
        public function update_slugs($args)
        {
            list($post_type) = $args;

            $posts = get_posts([
                'post_status' => 'any',
                'post_type'   => $post_type,
                'numberposts' => -1,
            ]);

            $count = 0;

            foreach ($posts as $post) {
                $new_slug = sanitize_title($post->post_title);
                wp_update_post([
                    'ID'        => $post->ID,
                    'post_name' => $new_slug,
                ]);
                $count++;
            }

            WP_CLI::success("Updated slugs for {$count} {$post_type} posts based on their titles.");
        }
    }
}