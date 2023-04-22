<?php
if (defined('WP_CLI') && WP_CLI) {
    class PPD_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Mass change post status for a specific post type.
         *
         * ## OPTIONS
         *
         * <post_type>
         * : The post type for which to change the post status.
         *
         * <old_status>
         * : The current post status.
         *
         * <new_status>
         * : The new post status.
         *
         * ## EXAMPLES
         *
         *     wp ppd change_status post draft publish
         */
        public function change_status($args)
        {
            list($post_type, $old_status, $new_status) = $args;

            $posts = get_posts([
                'post_status' => $old_status,
                'post_type'   => $post_type,
                'numberposts' => -1,
            ]);

            foreach ($posts as $post) {
                wp_update_post([
                    'ID'          => $post->ID,
                    'post_status' => $new_status,
                ]);
            }

            WP_CLI::success("Changed post status from {$old_status} to {$new_status} for post type {$post_type}.");
        }
    }
}