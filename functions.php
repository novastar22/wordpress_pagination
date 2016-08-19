<?php
    /**
     * Enqueue scripts
     *
     * @param string $handle Script name
     * @param string $src Script url
     * @param array $deps (optional) Array of script names on which this script depends
     * @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
     * @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
     */
    function mission_load_scripts() {
        wp_enqueue_script("jquery");
    }

    add_action( 'wp_enqueue_scripts', 'mission_load_scripts' );



/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function registr_workshop_type() {

    $labels = array(
        'name'                => __( 'Workshops', 'mur' ),
        'singular_name'       => __( 'Workshop', 'mur' ),
        'add_new'             => _x( 'Add New Workshop', 'mur', 'mur' ),
        'add_new_item'        => __( 'Add New Workshop', 'mur' ),
        'edit_item'           => __( 'Edit Workshop', 'mur' ),
        'new_item'            => __( 'New Workshop', 'mur' ),
        'view_item'           => __( 'View Workshop', 'mur' ),
        'search_items'        => __( 'Search Workshops', 'mur' ),
        'not_found'           => __( 'No Workshops found', 'mur' ),
        'not_found_in_trash'  => __( 'No Workshops found in Trash', 'mur' ),
        'parent_item_colon'   => __( 'Parent Workshop:', 'mur' ),
        'menu_name'           => __( 'Workshops', 'mur' ),
    );

    $args = array(
        'labels'                   => $labels,
        'hierarchical'        => true,
        'description'         => 'description',
        'taxonomies'          => array(),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => null,
        'menu_icon'           => null,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => true,
        'capability_type'     => 'post',
        'supports'            => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt','custom-fields', 'trackbacks', 'comments',
            'revisions', 'page-attributes', 'post-formats'
            )
    );

    register_post_type( 'workshop', $args );
}

add_action( 'init', 'registr_workshop_type' );


function mission_ur_add_columns(){
    $cols = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'mur'),
            'workshop_date' => __('Date', 'mur'),
            'start_time' => __('Start Time', 'mur'),
            'end_time' => __('End Time', 'mur'),
            'subjects' => __('Subject(s)', 'mur'),
            'venue' => __('Venue', 'mur'),
        );

    return $cols;
}
add_filter('manage_workshop_posts_columns', 'mission_ur_add_columns');

function mission_theme_support(){
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mission_theme_support');

/**
 * numeric pagination for custom queries
 * Much nicer than next and previous links :)
 *
 * @global type $wp_query
 * @param type $pageCount
 * @param type $query
 * @return type
 */
function bm_numeric_pagination( $page_count = 9, $query = null ) {

    if ( null == $query ) {
        global $wp_query;
        $query = $wp_query;
    }

    if ( 1 >= $query->max_num_pages ) {
        return;
    }

    $big = 9999999999; // need an unlikely integer

    echo '<div id="archive-pagination pagination">';
    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total' => $query->max_num_pages,
        'end_size' => 0,
        'mid_size' => $page_count,
        'next_text' => __( 'Older ›', 'textdomain' ),
        'prev_text' => __( '‹ Newer', 'textdomain' )
    ) );
    echo '</div>';

}