// webpack.mix.js

let mix = require('laravel-mix');

var argv = require('minimist')(process.argv.slice(2));


require('laravel-mix-purgecss');
require('laravel-mix-clean-css');

mix.webpackConfig({
    externals: {
        "jquery": "jQuery"
    }
});

mix.options({ processCssUrls: false });

mix.js('js/index.js', 'build');
mix.js('js/index-gutenberg.js', '/build/index-gutenberg.js').react();

mix.sass('sass/style.scss', '/style.min.css')
    .sourceMaps(false, 'source-map')
    .purgeCss({
    content:  ['template-parts/*.php', 'template-parts/blocks/*.php', 'inc/*.php', 'js/*.js', '*.php'],
    safelist: [
    'rtl',
    'home',
    'blog',
    'archive',
    'date',
    'error404',
    'logged-in',
    'admin-bar',
    'no-customize-support',
    'custom-background',
    'wp-custom-logo',
    'alignnone',
    'alignright',
    'alignleft',
    'wp-caption',
    'wp-caption-text',
    'screen-reader-text',
    'comment-list',
    'slick-list',
    'slick',
    'partnerships-page',
    'with_frm_style',
    'frm_form_field',
    'form-field',
    'ez-toc-widget-container', 
    'wp-block-table', 
    'is-style-bso-table', 
    'privacy-policy',
    'menu-item-new',
    'toggled',
    'menu-toggle',
    'mobile-table',
    'top-provider-row',
    'collapse',
    'collapsing', 
    /^search(-.*)?$/,
    /^(.*)-template(-.*)?$/,
    /^(.*)?-?single(-.*)?$/,
    /^postid-(.*)?$/,
    /^attachmentid-(.*)?$/,
    /^attachment(-.*)?$/,
    /^page(-.*)?$/,
    /^(post-type-)?archive(-.*)?$/,
    /^author(-.*)?$/,
    /^category(-.*)?$/,
    /^tag(-.*)?$/,
    /^tax-(.*)?$/,
    /^term-(.*)?$/,
    /^(.*)?-?paged(-.*)?$/,
    /^slick-(.*)?$/,    
    /^contact-(.*)?$/,
    /^content-block-(.*)?$/,
    /^frm_(.*)?$/,
    /^wp-block-(.*)?$/,
    /^ez-toc-(.*)?$/,
    /^p-(.*)?$/,
    /^pr-(.*)?$/,
    /^pl-(.*)?$/,
    /^pt-(.*)?$/,
    /^pb-(.*)?$/,
    /^px-(.*)?$/,
    /^m-(.*)?$/,
    /^mr-(.*)?$/,
    /^ml-(.*)?$/,
    /^mt-(.*)?$/,
    /^mb-(.*)?$/, 
    /^mx-(.*)?$/, 
    /^my-(.*)?$/, 
    /^offset-(.*)?$/, 
    /^col-(.*)?$/,
    /^font-weight-(.*)?$/,
    /^justify-(.*)?$/,
    /^align-(.*)?$/,
    /^text-(.*)?$/,
    ]
   })
  .cleanCss({
    level: 2
  })

mix.sass('sass/admin-styles.scss', 'css/admin-styles.css')
    .sourceMaps({generateForProduction: false});


if (argv.user === 'brad') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'bestsatelliteoptions.test',
        browser: 'firefox'
    });
 } else if (argv.user === 'edward') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'bso.test'
    });
 } else if (argv.user === 'jessi') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'localhost:8888/hso',
        browser: 'chrome'
    });
 } else if (argv.user === 'ryan') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'highspeedoptions.test'
    });
 } else if (argv.user === 'syed') {
     //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'highspeedoptions.test'
    });
 }   




