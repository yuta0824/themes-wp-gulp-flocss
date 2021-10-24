<?php
/**
 * functions
 **/


/**
 * テーマのセットアップ
 * 参考：https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support#HTML5
 **/
function my_setup()
{
  add_theme_support('post-thumbnails');        // アイキャッチ画像を有効化
  add_theme_support('automatic-feed-links');   // 投稿とコメントのRSSフィードのリンクを有効化
  add_theme_support('title-tag');              // タイトルタグ自動生成
  add_theme_support(
    'html5',
    array(                                     //HTML5でマークアップ
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_setup');

/**
 * CSSとJavaScriptの読み込み 
 **/
function my_script_init()
{
  wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper.css', array(), '1.0.0', 'all');
  wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0', 'all');
  wp_enqueue_script('my', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_script_init');



/**
 * クエリを指定する記述
 * $post 投稿タイプ
 * $taxonomy タクスノミー名
 * $term ターム名
 * $number 表示件数
 */
function get_post_pages($post_type, $taxonomy = null, $term = null, $number = -1)
{
  if (!$term) :
    $terms_obj = get_terms($taxonomy);
    $term = wp_list_pluck($terms_obj, 'slug');
  endif;

  $args = array(
    'post_type' => $post_type,
    'posts_per_page' => $number,
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term,
      ),
    ),
  );

  $post_pages = new WP_Query($args);
  return $post_pages;
}


/**
 * サムネイルがあれば表示なければノーイメージを表示する記述
 * noimg = ノーイメージ表示条件分岐
 * $imgpass = ノーイメージ画像パス
 * $size = 画像サイズ
 **/
function my_post_thumbnail($id = 0, $noimg = true, $size = 'large', $imgpass = '/asetts/img/noimg.png')
{
  if ($id == 0) {
    global $post;
    $id = $post->id;
  }

  if ($noimg) { //ノーイメージを表示する場合
    if (has_post_thumbnail($id)) {
      return get_the_post_thumbnail($id, $size);
    } else {
      return '<img src="' . esc_url(get_template_directory_uri()) . $imgpass . '" alt="ノーイメージ">';
    }
  } else {
    if (has_post_thumbnail($id)) {
      return get_the_post_thumbnail($id, $size);
    }
  }
}



/**
 * ターム取得する記述
 * $id = 取得したい投稿id もしくは表示中id
 * $anchor = aタグで返すか名前で返すか
 * $taxonomy = 取得したいタクスノミー名
 * $term_id = タームid
 * $exclusion = 除外するタームid
 */
function my_get_term($anchor = true, $id = 0, $taxonomy = '', $exclusion = 0)
{
  if ($id == 0) {
    global $post;
    $id = $post->id;
  }
  $term = get_the_terms($id, $taxonomy);

  if ($term[0]->term_id == $exclusion) {
    if ($anchor) {
      return get_term_link($term[1]);
    } else {
      return $term[1]->name;
    }
  } else {
    if ($anchor) {
      return get_term_link($term[0]);
    } else {
      return $term[0]->name;
    }
  }
}


/**
 * メインビジュアルのタイトルを取得する記述
 * 下層ページで使用
 * return = ページ見出し
 */
function get_main_title()
{
  if (is_singular('post')) : //記事ページ
    $category = get_the_category();
    return $category[0]->name;

  elseif (is_page()) : //固定ページ
    return get_the_title();

  elseif (is_category() || is_tax()) : //アーカイブ,タクスノミーページ
    return single_cat_title();

  elseif (is_post_type_archive('work') || is_singular('work')) : //制作実績アーカイブ
    return esc_html(get_post_type_object(get_post_type())->label);

  elseif (is_404()) : //404ページ
    return 'ページが見つかりません';
  endif;
}


