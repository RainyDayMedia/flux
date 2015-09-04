<?php
/**
 * flux Media Library Improvements and Support
 *
 * @package flux
 */

/**
 * ADDs SUPPORT FOR SVG UPLOADS TO THE MEDIA LIBRARY
 */
add_filter( 'upload_mimes', 'flux_mime_types' );
function flux_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

/**
 * ADD ALT TAGS TO IMAGE using the POST Title - SEO helper
 * since clients never add the ALT Tag to images
 */
add_filter('the_content', 'flux_add_alt_tags', 99999);
function flux_add_alt_tags($content)
	{
        global $post;
        preg_match_all('/<img (.*?)\/>/', $content, $images);
        if(!is_null($images))
        {
                foreach($images[1] as $index => $value)
                {
                        if(!preg_match('/alt=/', $value))
                        {
                                $new_img = str_replace('<img', '<img alt="'.$post->post_title.'"', $images[0][$index]);
                                $content = str_replace($images[0][$index], $new_img, $content);
                        }
                }
        }
    return $content;
}
