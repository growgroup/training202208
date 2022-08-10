<?php get_header() ?>


<main class="l-main">
    <section id="info">
        <h2 class="c-heading">お知らせ</h2>
        <div class="l-container">
            <ul class="c-news-list">
                <li>
                    <a href="">
                        <span class="c-news-list__date">2022.05.10</span>
                        <span class="c-news-list__category">イベント</span>
                        <span class="c-news-list__title">スペシャルイベントを開催します</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="c-news-list__date">2022.04.20</span>
                        <span class="c-news-list__category">お知らせ</span>
                        <span class="c-news-list__title">ゴールデンウィーク休暇のお知らせ</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="c-news-list__date">2021.12.20</span>
                        <span class="c-news-list__category">お知らせ</span>
                        <span class="c-news-list__title">年末年始休暇のお知らせ</span>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <section id="product">
        <h2 class="c-heading">名所</h2>
        <div class="l-container">
            <form action="?" class="c-form" name="search_form">
                <select name="s_place_area" onchange="search_form.submit()">
                    <option value="">すべてのエリア</option>
                    <?php
                    /**
                     * 現在検索されている値を取得
                     */
                    $current_place_area_term_id  = 0;
                    if ( isset( $_GET["s_place_area"] ) && $_GET["s_place_area"] ) :
                        $current_place_area_term_id  = (int) $_GET["s_place_area"];
                    endif;
                    $terms = get_terms('place_area');
                    if ($terms && !is_wp_error($terms)) :
                        foreach ($terms as $term) {
                            /**
                             * オプションを取得
                             * - valueにterm_idを設定
                             * - selected() で selected=true を出力
                             */
                            ?>
                            <option value="<?php echo $term->term_id ?>" <?php selected( $current_place_area_term_id, $term->term_id, true ) ?>><?php echo $term->name ?></option>
                            <?php 
                        }
                    endif;
                     ?>
                </select>
                <select name="s_place_genre" onchange="search_form.submit()">
                    <option value="">すべてのジャンル</option>
                    <?php
                    /**
                     * 現在検索されている値を取得
                     */
                    $current_place_genre_term_id  = 0;
                    if ( isset( $_GET["s_place_genre"] ) && $_GET["s_place_genre"] ) :
                        $current_place_genre_term_id  = (int) $_GET["s_place_genre"];
                    endif;
                    $terms = get_terms('place_genre');
                    if ($terms && !is_wp_error($terms)) :
                        foreach ($terms as $term) {
                            /**
                             * オプションを取得
                             * - valueにterm_idを設定
                             * - selected() で selected=true を出力
                             */
                            ?>
                            <option value="<?php echo $term->term_id ?>" <?php selected( $current_place_genre_term_id, $term->term_id, true ) ?>><?php echo $term->name ?></option>
                            <?php 
                        }
                    endif;
                    ?>
                </select>
            </form>
            <ul class="c-place-list">

                <?php
                $args = [
                    'post_type' => 'places',
                ];

                if ( $current_place_area_term_id ){
                    $args["tax_query"][] = [
                        'taxonomy' => "place_area",
                        'terms' => $current_place_area_term_id,
                        'field' => "term_id"
                    ];
                }
                if ( $current_place_genre_term_id ){
                    $args["tax_query"][] = [
                        'taxonomy' => "place_genre",
                        'terms' => $current_place_genre_term_id,
                        'field' => "term_id"
                    ];
                }
                
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
                        $the_query->the_post();
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <div class="c-place-list__image">
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url()) ?>" alt="">
                        </div>
                        <p class="c-place-list__title"><?php the_title() ?></p>
                        <ul class="c-place-list__category">
                            <li class="c-place-list__category__area">
                                <?php
                                        $terms = get_the_terms(get_the_ID(), 'place_area');

                                        if ($terms && !is_wp_error($terms)) :

                                            foreach ($terms as $term) {
                                                echo esc_html($term->name);
                                            }
                                        ?>

                                <?php endif; ?>
                            </li>
                            <li class="c-place-list__category__genre">
                                <?php
                                        $terms = get_the_terms(get_the_ID(), 'place_genre');

                                        if ($terms && !is_wp_error($terms)) :

                                            foreach ($terms as $term) {
                                                echo esc_html($term->name);
                                            }
                                        ?>

                                <?php endif; ?>
                            </li>
                        </ul>
                        <p class="c-place-list__text">
                            <?php the_field('text') ?>
                        </p>
                    </a>
                </li>
                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </ul>
            <p class="u-text-center">
                <a href="/places/" class="c-button">一覧を見る</a>
            </p>
        </div>
    </section>
    <?php echo do_shortcode('[contact-form-7 id="67" title="無題"]') ?>
</main>
<?php get_footer() ?>
