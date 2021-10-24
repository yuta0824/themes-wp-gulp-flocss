<?php

/**
 * Header Contents
 */

?>

<?php
$home_link    = esc_url(home_url('/'));
$contact_link = esc_url(home_url('/contact/'));;
$about_link   = get_permalink(get_page_by_path('about')->ID);;
$work_link    = get_post_type_archive_link('work');;
?>

<header class="l-header">
  <div class="l-header__inner l-inner">
    <h1 class="l-header__logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="ロゴ"></a></h1>
    <nav class="l-header__nav u-hidden-sp">
      <ul class="p-global-nav">
        <li class="p-global-nav__item"><a href="<?php echo $home_link; ?>">home</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $home_link; ?>">home</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $contact_link; ?>">contact</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $contact_link; ?>">contact</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $contact_link; ?>">contact</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $contact_link; ?>">contact</a></li>
        <li class="p-global-nav__item"><a href="<?php echo $contact_link; ?>">contact</a></li>
      </ul>
    </nav>
  </div>
</header><!-- l-header -->

<a class="c-drawer-button js-drawer-button u-hidden-pc">
  <span class="c-drawer-button__line c-drawer-button__line--top"></span>
  <span class="c-drawer-button__line c-drawer-button__line--center"></span>
  <span class="c-drawer-button__line c-drawer-button__line--bottom"></span>
</a><!-- c-drawer-button -->

<div class="p-drawer-contents js-drawerMenu">
  <ul class="p-drawer-contents__items">
    <li class="p-drawer-contents__item p-drawer-contents__item--logo">
      <a href="./"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="ロゴ"></a>
    </li>
    <li class="p-drawer-contents__item"><a href="<?php echo $home_link; ?>">home</a></li>
    <li class="p-drawer-contents__item"><a href="<?php echo $home_link; ?>">home</a></li>
    <li class="p-drawer-contents__item"><a href="<?php echo $home_link; ?>">home</a></li>
    <li class="p-drawer-contents__item"><a href="<?php echo $contact_link; ?>">home</a></li>
    <li class="p-drawer-contents__item"><a href="<?php echo $contact_link; ?>">home</a></li>
    <li class="p-drawer-contents__item"><a href="<?php echo $contact_link; ?>">home</a></li>
  </ul>
</div><!-- p-drawer-contents -->