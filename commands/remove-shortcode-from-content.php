<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Bulk_Remove_Shortcodes_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Bulk remove specific shortcodes from post content.
         *
         * ## OPTIONS
         *
         * <shortcode>
         * : The shortcode to remove from the post content.
         *
         * ## EXAMPLES
         *
         *     wp brsc remove "my_shortcode"
         */
        public function remove($args)
        {
            list($shortcode) = $args;

            $posts = get_posts([
                'post_status' => 'any',
                'post_type'   => 'any',
                'posts_per_page' => -1,
            ]);

            $count = 0;

            foreach ($posts as $post) {

                if ($this->contains_shortcode($post->post_content, $shortcode)) {
                    $updated_content = $this->strip_shortcodes($post->post_content, [$shortcode]);
                    wp_update_post([
                        'ID'           => $post->ID,
                        'post_content' => $updated_content,
                    ]);
                    $count++;
                }
            }

            WP_CLI::success("Removed {$shortcode} shortcode from {$count} posts.");
        }

        private function contains_shortcode($content, $shortcode)
        {
            return preg_match('/\[' . preg_quote($shortcode) . '(\s|\])/', $content) > 0;
        }

        private function strip_shortcodes($content, $shortcodes)
        {
            foreach ($shortcodes as $shortcode) {
                $content = preg_replace("/\[" . preg_quote($shortcode) . ".*?\]/", "", $content);
                $content = preg_replace("/\[\/" . preg_quote($shortcode) . "\]/", "", $content);
            }
            return $content;
        }
    }
}