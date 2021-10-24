<?php

/**
 * front-page
 */

get_header();
?>

<?php
$home_link    = esc_url(home_url('/'));
$contact_link = esc_url(home_url('/contact/'));;
$about_link   = get_permalink(get_page_by_path('about')->ID);;
$work_link    = get_post_type_archive_link('work');;
?>

<div class="l-mv">
  <picture class="l-mv__bg">
    <source media="(max-width: 767px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/img/pc.jpg">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pc.jpg" alt="" width="" height="" loading="lazy">
  </picture>
  <div class="l-mv__inner">
    <div class="l-mv__head"><?php bloginfo('title'); ?></div>
    <div class="l-mv__text">テキストテキストテキスト</div>
    <div class="l-mv__btn"><a href="<?php echo $contact_link; ?>" class="c-btn">詳しく見る</a></div>
  </div>
</div><!-- l-mv -->

<div class="l-top">
<section class="l-top__table p-top-table">
  <div class="p-top-table__inner l-inner">
    
  </div>
</section><!-- p-top-table -->
</div><!-- l-top -->

<?php get_footer(); ?>