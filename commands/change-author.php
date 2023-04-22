<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Change_Author_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Bulk change the author for a specific post type.
         *
         * ## OPTIONS
         *
         * <post_type>
         * : The post type for which to change the author.
         *
         * <old_author_id>
         * : The current author's ID.
         *
         * <new_author_id>
         * : The new author's ID.
         *
         * ## EXAMPLES
         *
         *     wp ca change_author post 1 2
         */
        public function change_author($args)
        {
            list($post_type, $old_author_id, $new_author_id) = $args;

            $posts = get_posts([
                'post_status' => 'any',
                'post_type'   => $post_type,
                'numberposts' => -1,
                'author'      => $old_author_id,
            ]);

            $count = 0;

            foreach ($posts as $post) {
                wp_update_post([
                    'ID'          => $post->ID,
                    'post_author' => $new_author_id,
                ]);
                $count++;
            }

            WP_CLI::success("Changed author from {$old_author_id} to {$new_author_id} for {$count} {$post_type} posts.");
        }
    }
}