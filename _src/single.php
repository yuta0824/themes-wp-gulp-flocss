<?php 

/**
 * single
 */

get_header();
?>


  <main class="main">
    <a href="<?php echo esc_url(home_url('/')); ?>">home</a>
    <a href="<?php echo esc_url(home_url('/contact')); ?>">コンタクトページ</a>
    <?php the_post_thumbnail( ); ?>
    <div class="the_content">
      <?php the_content(); ?>
    </div>
  </main>


<?php get_footer(); ?>