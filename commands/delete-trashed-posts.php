<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Delete_Trashed_Posts_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Delete all trashed posts for a specific post type or all post types.
         *
         * ## OPTIONS
         *
         * [<post_type>]
         * : The post type for which to delete the trashed posts. Defaults to all post types.
         *
         * ## EXAMPLES
         *
         *     wp dtp delete_trashed
         *     wp dtp delete_trashed post
         */
        public function delete_trashed($args)
        {
            $post_type = isset($args[0]) ? $args[0] : '';

            $trashed_posts = get_posts([
                'post_status' => 'trash',
                'post_type'   => $post_type ? $post_type : 'any',
                'numberposts' => -1,
            ]);

            $count = 0;

            foreach ($trashed_posts as $post) {
                wp_delete_post($post->ID, true);
                $count++;
            }

            WP_CLI::success("Deleted {$count} trashed posts for post type '{$post_type}'.");
        }
    }
}