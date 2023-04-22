# WP-Cli Amplifier
## Commands
### Bulk Change Author
 bulk change the author for specific post types. This could come in handy when reassigning posts to a new author in cases such as user departure, content migration, or team restructuring.  

`wp ca change_author <post_type> <old_author_id> <new_author_id>`  

Replace `<post_type>`, `<old_author_id>`, and `<new_author_id>` with the appropriate values.  

For example, to change the author for all posts from user ID 1 to user ID 2:  
`wp ca change_author post 1 2`

### Bulk Delete Trashed posts
To delete trashed posts for all post types:  
`wp dtp delete_trashed`  

To delete trashed posts for a specific post type (e.g., 'post'):  
`wp dtp delete_trashed post`

### Bulk Change post status
To change the post status in bulk, use the WP-CLI command:  
`wp ppd change_status <post_type> <old_status> <new_status>`  

Example:  
`wp ppd change_status post draft publish`

### Bulk regenerate featured images from the first image in the post content
This command can be useful when you want to set or update the featured images for multiple posts at once, using the first image in the post content. It can be helpful when you've imported content without featured images or want to change the featured images based on the post content.

`wp brfi regenerate <post_type>`

For example, to regenerate featured images for all posts:  
`wp brfi regenerate post`

### Bulk remove shortcodes from post content
This command can be useful when you want to remove specific shortcodes from the content of multiple posts at once. It can be helpful when you've deactivated a plugin that used shortcodes, and you want to clean up the remaining shortcodes from your posts.

`wp brsc remove <shortcode>`  

For example, to remove the "my_shortcode" shortcode from all posts:  
`wp brsc remove "my_shortcode"`

### Bulk update image alt tags
This command can be useful when you want to update the alt tags for multiple images, that have missing alt tags, in your media library at once. Alt tags improve the accessibility and SEO of your website, so keeping them up-to-date and relevant is essential.

`wp buiat update_empty_alt_tags <alt_tag_prefix>`  

For example, to set the alt tag prefix as "My Website - " for images with empty alt tags:  
`wp buiat update_empty_alt_tags "My Website - "`

### Bulk update post slugs
This command can be useful when you want to update post slugs for multiple posts based on their current titles. This can be handy for SEO purposes or when you've made changes to the titles and want the slugs to reflect those changes.  

`wp bus update_slugs <post_type>`  

For example, to update slugs for all posts:  
`wp bus update_slugs post`