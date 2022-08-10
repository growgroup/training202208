<?php
function my_theme_url($path)
{
    return esc_url(get_theme_file_uri($path));
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sanitize.css', get_theme_file_uri('css/sanitize.css'));
    wp_enqueue_style('style.css', get_theme_file_uri('css/style.css'));
});


add_action('init', function () {
    $args = array(
        'public' => true,
        'label'  => '名所',
        'supports' => array('title', 'thumbnail',),
        'rewrite' => array('slug' => 'places'),
        'has_archive' => true,
    );
    register_post_type('places', $args);
    register_taxonomy(
        'place_area',
        'places',
        array(
            'label' => '名所エリア',
            'rewrite' => array('slug' => 'place_area'),
            'hierarchical' => true,
        )
    );
    register_taxonomy(
        'place_genre',
        'places',
        array(
            'label' => '名所ジャンル',
            'rewrite' => array('slug' => 'place_genre'),
            'hierarchical' => true,
        )
    );
});


/**
 * 絞り込み検索用に投稿アーカイブにフィルタをかける
 * 
 */
add_filter("pre_get_posts", function($query){
    if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( "places" ) ): 
        $current_place_area_term_id  = 0;
        if ( isset( $_GET["s_place_area"] ) && $_GET["s_place_area"] ) :
            $current_place_area_term_id  = (int) $_GET["s_place_area"];
        endif;
        $current_place_genre_term_id  = 0;
        if ( isset( $_GET["s_place_genre"] ) && $_GET["s_place_genre"] ) :
            $current_place_genre_term_id  = (int) $_GET["s_place_genre"];
        endif;
        
        $tax_query = [];
        if ( $current_place_area_term_id ) : 
            $tax_query[] = [
                'taxonomy' => "place_area",
                'terms' => $current_place_area_term_id,
                'field' => "term_id"
            ];
        endif;
        if ( $current_place_genre_term_id ) :
            $tax_query[] = [
                'taxonomy' => "place_genre",
                'terms' => $current_place_genre_term_id,
                'field' => "term_id"
            ];
        endif;

        if ( $tax_query ) :
            $query->set( "tax_query", $tax_query );
        endif;
    endif;
});