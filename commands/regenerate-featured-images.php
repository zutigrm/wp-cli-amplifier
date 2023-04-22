<?php
if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_CLI') && WP_CLI) {
    class Bulk_Regenerate_Featured_Images_WP_CLI_Command extends WP_CLI_Command
    {
        /**
         * Bulk regenerate featured images for posts from the first image in the post content.
         *
         * ## OPTIONS
         *
         * <post_type>
         * : The post type for which to regenerate the featured images.
         *
         * ## EXAMPLES
         *
         *     wp brfi regenerate post
         */
        public function regenerate($args)
        {
            list($post_type) = $args;

            $posts = get_posts([
                'post_status' => 'any',
                'post_type'   => $post_type,
                'numberposts' => -1,
            ]);

            $count = 0;

            foreach ($posts as $post) {
                if (!has_post_thumbnail($post->ID)) {
                    $content = $post->post_content;
                    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
                    $first_img = isset($matches[1][0]) ? $matches[1][0] : '';

                    if (!empty($first_img)) {
                        $attach_id = $this->url_to_attachment_id($first_img);
                        if ($attach_id) {
                            set_post_thumbnail($post->ID, $attach_id);
                            $count++;
                        }
                    }
                }
            }

            WP_CLI::success("Updated featured images for {$count} {$post_type} posts.");
        }

        private function url_to_attachment_id($url)
        {
            global $wpdb;
            $attachment_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url));
            return $attachment_id[0];
        }
    }
}