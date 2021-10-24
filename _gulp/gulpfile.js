const gulp = require("gulp");
const del = require("del");

//ローカルドメイン
const localDomain = "http://admin.local/"

//scss
const sassGlob = require('gulp-sass-glob-use-forward');// Sassのglobを有効にする
const sass = require("gulp-dart-sass"); //Dart Sass はSass公式が推奨 @use構文などが使える
const plumber = require("gulp-plumber"); // エラーが発生しても強制終了させない
const notify = require("gulp-notify"); // エラー発生時のアラート出力
const browserSync = require("browser-sync"); //ブラウザリロード
const autoprefixer = require("gulp-autoprefixer"); //ベンダープレフィックス自動付与
const postcss = require("gulp-postcss"); //css-mqpackerを使うために必要
const mqpacker = require("css-mqpacker"); //メディアクエリをまとめる

//画像圧縮
const imagemin = require("gulp-imagemin");
const imageminMozjpeg = require("imagemin-mozjpeg");
const imageminPngquant = require("imagemin-pngquant");
const imageminsvgo = require("imagemin-svgo");

// 入出力するフォルダを指定
const srcBase = "../_src";
const assetsBase = "../_assets";
const wpTheme = "../wp-original";

const srcPath = {
  scss: "../_scss/**/*.scss",
  js: assetsBase + "/js/**/*.js",
  img: [assetsBase + "/img/**/*", "!" + assetsBase + "/img/svg/*.svg"],
  font: assetsBase + "/font/**/*",
  html: srcBase + "/**/*.html",
  php: srcBase + "/**/*.php",
  style: assetsBase + "/**/*.css",
  library: assetsBase + "/library/**/*",
};

const distPath = {
  css: wpTheme + "/assets/css/",
  js: wpTheme + "/assets/js/",
  img: wpTheme + "/assets/img/",
  font: wpTheme + "/assets/font/",
  html: wpTheme + "/",
  php: wpTheme + "/",
  style: wpTheme + "/",
  library: wpTheme + "/assets/library/",
};

/**
 * clean
 */
const clean = () => {
  return del([wpTheme + "/**"], {
    force: true,
  });
};

//ベンダープレフィックスを付与する条件
const TARGET_BROWSERS = [
  "last 2 versions",
  "ie >= 11",
  "iOS >= 7",
  "Android >= 4.4",
];

/**
 * sass
 *
 */
const cssSass = () => {
  return gulp
    .src(srcPath.scss, {
      sourcemaps: true,
    })
    .pipe(sassGlob()) // Sassのglobを有効にする
    .pipe(
      //エラーが出ても処理を止めない
      plumber({
        errorHandler: notify.onError("Error:<%= error.message %>"),
      })
    )
    .pipe(
      sass({
        outputstyle: "expanded",
      })
    ) //指定できるキー expanded compressed CSS圧縮
    .pipe(autoprefixer(TARGET_BROWSERS))
    .pipe(postcss([mqpacker()])) // メディアクエリをまとめる
    .pipe(
      gulp.dest(distPath.css, {
        sourcemaps: "./",
      })
    ) //コンパイル先
    .pipe(browserSync.stream())
    .pipe(
      notify({
        message: "Sassをコンパイルしました！",
        onLast: true,
      })
    );
};

/**
 * 画像圧縮
 */
const imgImagemin = () => {
  return gulp
    .src(srcPath.img)
    .pipe(
      imagemin(
        [
          imageminMozjpeg({
            quality: 80,
          }),
          imageminPngquant(),
          imagemin.svgo({
            //svgプラグイン
            plugins: [{ removeViewbox: true }, { cleanupIDs: false }],
          }),
        ],
        {
          verbose: true,
        }
      )
    )
    .pipe(gulp.dest(distPath.img));
};

/**
 * html
 */
const html = () => {
  return gulp.src(srcPath.html).pipe(gulp.dest(distPath.html));
};


/**
 * js
 */
const js = () => {
  return gulp.src(srcPath.js).pipe(gulp.dest(distPath.js));
};

/**
 * php
 */
const php = () => {
  return gulp.src(srcPath.php).pipe(gulp.dest(distPath.php));
};

/**
 * 独自font
 */
const font = () => {
  return gulp.src(srcPath.font).pipe(gulp.dest(distPath.font));
};

/**
 * style
 */
const style = () => {
  return gulp.src(srcPath.style).pipe(gulp.dest(distPath.style));
};

/**
 * libraryフォルダ
 */
const library = () => {
  return gulp.src(srcPath.library).pipe(gulp.dest(distPath.library));
};

/**
 * ローカルサーバー立ち上げ
 */
const browserSyncFunc = () => {
  browserSync.init(browserSyncOption);
};
const browserSyncOption = {
  proxy: localDomain,
  open: true,
};

/**
 * リロード
 */
const browserSyncReload = (done) => {
  browserSync.reload();
  done();
};

/**
 *
 * ファイル監視 ファイルの変更を検知したら、browserSyncReloadでreloadメソッドを呼び出す
 * series 順番に実行
 * watch('監視するファイル',処理)
 */
const watchFiles = () => {
  gulp.watch(srcPath.scss, gulp.series(cssSass));
  gulp.watch(srcPath.html, gulp.series(html, browserSyncReload));
  gulp.watch(srcPath.js, gulp.series(js, browserSyncReload));
  gulp.watch(srcPath.img, gulp.series(imgImagemin, browserSyncReload));
  gulp.watch(srcPath.php, gulp.series(php, browserSyncReload));
  gulp.watch(srcPath.font, gulp.series(font, browserSyncReload));
  gulp.watch(srcPath.library, gulp.series(library, browserSyncReload));
};

/**
 * seriesは「順番」に実行
 * parallelは並列で実行
 *
 * 一度cleanでdistフォルダ内を削除し、最新のものをdistする
 */
exports.default = gulp.series(
  clean,
  gulp.parallel(html, cssSass, js, imgImagemin, php, font, style, library),
  gulp.parallel(watchFiles, browserSyncFunc)
);
