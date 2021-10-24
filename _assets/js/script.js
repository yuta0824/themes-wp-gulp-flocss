console.log("script");

//375px 未満は JS で viewport を固定する
(function () {
  const viewport = document.querySelector('meta[name="viewport"]');
  function switchViewport() {
    const value =
      window.outerWidth > 375
        ? "width=device-width,initial-scale=1"
        : "width=375";
    if (viewport.getAttribute("content") !== value) {
      viewport.setAttribute("content", value);
    }
  }
  addEventListener("resize", switchViewport, false);
  switchViewport();
})();

//スクロールアニメーション
jQuery.fn.acs = function (options) {
  const elements = this;
  const defaults = {
    screenPos: 0.8,
    className: "is-animated",
  };
  const setting = jQuery.extend(defaults, options);
  jQuery(window).on("load scroll", function () {
    add_class_in_scrolling();
  });
  function add_class_in_scrolling() {
    const winScroll = jQuery(window).scrollTop();
    const winHeight = jQuery(window).height();
    const scrollPos = winScroll + winHeight * setting.screenPos;

    if (elements.offset().top < scrollPos) {
      elements.addClass(setting.className);
    }
  }
};
jQuery('.anm, [class*="anm-"]').each(function () {
  jQuery(this).acs();
});
jQuery.fn.anmDelay = function (options) {
  const elements = this;
  const defaults = {
    delay: 0.2,
    property: "animation-delay",
  };
  const setting = jQuery.extend(defaults, options);
  const index = elements.index();
  const time = index * setting.delay;
  elements.css(setting.property, time + "s");
};

// ハンバーガーメニュー
jQuery(".js-drawer-button").click(function () {
  jQuery(".js-drawer-button").toggleClass("is-open");
  jQuery(".js-drawerMenu").fadeToggle();
  jQuery("html").toggleClass("is-fixed");
});
jQuery(".js-drawerMenu li a").click(function () {
  jQuery(".js-drawer-button").trigger("click");
});

//トップへ戻るスクロール検知
jQuery(window).on("scroll", function () {
  if (400 < jQuery(this).scrollTop()) {
    //400pxスクロール後
    jQuery(".js-top").addClass("is-show");
  } else {
    jQuery(".js-top").removeClass("is-show");
  }
});
jQuery(".js-top").click(function () {
  jQuery("body, html").animate({ scrollTop: 0 }, 500);
  return false;
});

// フォームセレクトボックスが変更された際テキストカラーを変更
//--------------------------
jQuery(".js-colour-change").change(function () {
  jQuery(this).css("color", "#000");
});

//スマホ画面でメニューバーを含めない100vh
function setHeight() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty("--vh", `${vh}px`);
}
setHeight();
