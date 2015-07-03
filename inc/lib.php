<?php
/**
 * Various library functions that aren't specific to any theme, but general utility usage.
 *
 * @package flux
 */

/**
 * Function to add a separator to the admin menu
 *
 * @param $position (int) menu position for the separator
 */
function flux_admin_menu_separator( $position )
{
	global $menu;

	$menu[$position] = array(
			0 => '',
			1 => 'read',
			2 => 'separator' . $position,
			3 => '',
			4 => 'wp-menu-separator'
		);
}

/**
 * Automatically add alt tags to images in content
 *
 * @param $content (string) the_content
 */
function flux_add_alt_tags( $content )
{
	global $post;

    preg_match_all( '/<img (.*?)\/>/', $content, $images );

    if( !is_null( $images ) ) {
        foreach( $images[1] as $index => $value ) {
            if( !preg_match( '/alt=/', $value ) ) {
                $new_img = str_replace( '<img', '<img alt="'.$post->post_title.'"', $images[0][$index] );
                $content = str_replace( $images[0][$index], $new_img, $content );
            }
        }
    }

    return $content;
}

/**
 * Trims the excerpt almost exactly like the built in wp_trim_excerpt,
 * except we are allowing the <p> html tags
 *
 * @param $excerpt (string) the text to be trimmed
 */
function flux_trim_excerpt( $excerpt )
{
	global $post;

	if ( '' == $excerpt ) {
		$excerpt = get_the_content( '' );
		$excerpt = apply_filters( 'the_content', $excerpt );

		$excerpt = str_replace( '\]\]\>', ']]&gt;', $excerpt );
		$excerpt = strip_tags( $excerpt, '<p>' );
		$excerpt_length = 60;

		$words = explode( ' ', $excerpt, $excerpt_length + 1 );
		if ( count( $words ) > $excerpt_length ) {
			  array_pop( $words );
			  array_push( $words, '[...]' );
			  $excerpt = implode( ' ', $words );
		}
	}

	return $excerpt;
}

/**
 * Output the HTML for the favicons on the front end and admin pages
 * Code and Icons generated with Real Favicon Generator
 * http://realfavicongenerator.net/
 */
function flux_output_favicons()
{
    global $favicon_theme_color;
    $dir = get_template_directory_uri();

    echo '<!-- favicons -->';
    echo "\n";
    echo '<link rel="apple-touch-icon" sizes="57x57" href="'.$dir.'/favicons/apple-touch-icon-57x57.png">';
    echo '<link rel="apple-touch-icon" sizes="60x60" href="'.$dir.'/favicons/apple-touch-icon-60x60.png">';
    echo '<link rel="apple-touch-icon" sizes="72x72" href="'.$dir.'/favicons/apple-touch-icon-72x72.png">';
    echo '<link rel="apple-touch-icon" sizes="76x76" href="'.$dir.'/favicons/apple-touch-icon-76x76.png">';
    echo '<link rel="apple-touch-icon" sizes="114x114" href="'.$dir.'/favicons/apple-touch-icon-114x114.png">';
    echo '<link rel="apple-touch-icon" sizes="120x120" href="'.$dir.'/favicons/apple-touch-icon-120x120.png">';
    echo '<link rel="apple-touch-icon" sizes="144x144" href="'.$dir.'/favicons/apple-touch-icon-144x144.png">';
    echo '<link rel="apple-touch-icon" sizes="152x152" href="'.$dir.'/favicons/apple-touch-icon-152x152.png">';
    echo '<link rel="apple-touch-icon" sizes="180x180" href="'.$dir.'/favicons/apple-touch-icon-180x180.png">';
    echo '<link rel="icon" type="image/png" href="'.$dir.'/favicons/favicon-32x32.png" sizes="32x32">';
    echo '<link rel="icon" type="image/png" href="'.$dir.'/favicons/android-chrome-192x192.png" sizes="192x192">';
    echo '<link rel="icon" type="image/png" href="'.$dir.'/favicons/favicon-96x96.png" sizes="96x96">';
    echo '<link rel="icon" type="image/png" href="'.$dir.'/favicons/favicon-16x16.png" sizes="16x16">';
    echo '<link rel="manifest" href="'.$dir.'/favicons/manifest.json">';
    echo '<meta name="msapplication-TileColor" content="'.$favicon_theme_color.'">';
    echo '<meta name="msapplication-TileImage" content="'.$dir.'/favicons/mstile-144x144.png">';
    echo '<meta name="theme-color" content="'.$favicon_theme_color.'">';
    echo "\n";
    echo '<!-- end favicons -->';
    echo "\n";
}

/**
 * Display escaped ACF output
 *
 * @param string $key - the field slug to retrieve
 * @param string $method (optional) - the method to call for escaping
 *          most common are esc_html, esc_attr, and esc_url
 * @param int $post_id (optional) - the post id to retrieve
 */
function __the_field( $key, $method = 'esc_html', $post_id = false )
{
    $field = get_field( $key, $post_id );

    if ( $field === NULL || $field === FALSE )
        $field = '';

    echo ( $method === NULL ) ? $field : $method( $field );
}

/**
 * Display escaped ACF sub field output
 *
 * @param string $key - the field slug to retrieve
 * @param string $method (optional) - the method to call for escaping
 *          most common are esc_html, esc_attr, and esc_url
 * @param int $post_id (optional) - the post id to retrieve
 */
function __the_sub_field( $key, $method = 'esc_html', $post_id = false )
{
    $field = get_sub_field( $key, $post_id );

    if ( $field === NULL || $field === FALSE )
        $field = '';

    echo ( $method === NULL ) ? $field : $method( $field );
}

/**
 * Outputs the current post's featured image. If there isn't one set on the post,
 * output the fallback image.
 * Drop a fallback image in theme/assets/img/blog-fallback.png.
 *
 * @param int $id ID of the post to retrieve (default current Post ID)
 * @param bool $add_link Set to true to add a link to the full sized image (default false)
 */
function flux_show_featured_image( $id = null, $add_link = false )
{
    global $post;
    $id     = ( $id === null ) ? $post->ID : $id;
    $output = '';

    if ( has_post_thumbnail( $id ) ) {
        if ( $add_link ) {
            $url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );

            $output .= '<a href="'. $url[0] .'" alt="Lock 27 Brewing">';
            $output .= get_the_post_thumbnail( $id, 'medium' );
            $output .= '</a>';

        } else {
            $output .= get_the_post_thumbnail( $id, 'medium' );
        }

    } else {
        $output .= '<img src="';
        $output .= get_template_directory_uri();
        $output .= '/assets/img/blog-fallback.png" alt="';
        $output .= get_bloginfo( 'name' );
        $output .= '" class="wp-post-image" />';
    }

    echo $output;
}

/**
 * Outputs the responsive background javascript code. jQuery is required!
 */
function flux_output_responsive_backgrounds()
{
    global $bg_queue;

    if ( empty( $bg_queue ) )
        return false;

?>
    <script type="text/javascript">
        function insert (id, images) {
            var $el   = document.getElementById(id),
                width = window.innerWidth,
                image;

            if (width >= 960)
                image = images[0];
            else if (width >= 768)
                image = images[1];
            else
                image = images[2];

            $el.style.backgroundImage = 'url(' + image + ')';
        }

<?php
    foreach ( $bg_queue as $bg ) {
        $selector = $bg['selector'];
        $img_id   = $bg['id'];

        $full    = wp_get_attachment_image_src( $img_id, 'full' );
        $large   = wp_get_attachment_image_src( $img_id, 'large' );
        $medium  = wp_get_attachment_image_src( $img_id, 'medium' );
        $images = '["'.$full[0].'", "'.$large[0].'", "'.$medium[0].'"]';

        echo 'insert("'.$selector.'", '.$images.'); ';
    }

    echo '</script>';
}

/**
 * Adds an image to the responsive background queue.
 *
 * @param string $selector The HTML selector to target (recommend using id attribute)
 * @param int $image_id The ID of the image in the WordPress media library
 */
function flux_enqueue_responsive_background( $selector, $image_id )
{
    global $bg_queue;
    $bg_queue[] = [ 'selector' => $selector, 'id' => $image_id ];
}
