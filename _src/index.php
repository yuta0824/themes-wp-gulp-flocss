<?php

/**
 * front-page
 */

get_header();
?>

<main class="main">
  <div class="main__inner l-inner">
    <h2 class="main__section-title c-section-title">メインコンテンツ</h2>
    <div class="main__boxs boxs">
      <div class="box box--l">BOX L</div>
      <div class="box box--m">BOX M</div>
      <div class="box box--s">BOX S</div>
    </div>
    <div class="main__btn"><a class="c-btn c-btn--main" href="<?php echo esc_url(home_url('/')); ?>">ホームページ</a></div>
    <div class="main__btn"><a class="c-btn c-btn--sub" href="<?php echo esc_url(home_url('/')); ?>">コンタクトページ</a></div>
    <div class="main__map map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.74797546837!2d139.74324421470988!3d35.65858048019957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bbd9009ec09%3A0x481a93f0d2a409dd!2z5p2x5Lqs44K_44Ov44O8!5e0!3m2!1sja!2sjp!4v1629097035184!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>
</main><!-- /.main -->


<?php get_footer(); ?>