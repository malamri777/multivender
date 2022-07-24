const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

// ========== ^Admin ====================

mix
//     .sass('resources/assets/admin/sass/core.scss', '/public/assets/admin/css')
//     .sass('resources/assets/admin/sass/custom/system-info.scss', '/public/assets/admin/css')
//     .sass('resources/assets/admin/sass/custom/email.scss', '/public/assets/admin/css')
//     .sass('resources/assets/admin/sass/custom/error-pages.scss', '/public/assets/admin/css')
//     .sass('resources/assets/admin/sass/rtl.scss', '/public/assets/admin/css')
//     .sass('resources/assets/admin/sass/tree-category.scss', '/public/assets/admin/css')

    .js('resources/js/aiz-core.js', 'public/assets/js')
//     .js('resources/assets/admin/js/app.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/core.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/editor.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/cache.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/tags.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/system-info.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/repeater-field.js', '/public/assets/admin/js')
//     .js('resources/assets/admin/js/tree-category.js', '/public/assets/admin/js')
//     .vue()
// ========== &Admin ====================


let webpackPlugins = [];
if (mix.inProduction() && process.env.UPLOAD_S3) {
    webpackPlugins = [
        new s3Plugin({
            include: /.*\.(css|js)$/,
            s3Options: {
                accessKeyId: process.env.AWS_KEY,
                secretAccessKey: process.env.AWS_SECRET,
                region: process.env.AWS_DEFAULT_REGION,
            },
            s3UploadOptions: {
                Bucket: process.env.AWS_BUCKET,
                CacheControl: 'public, max-age=31536000'
            },
            basePath: 'public',
            directory: 'public'
        })
    ]
}

mix.webpackConfig({
    plugins: webpackPlugins
});

if (mix.inProduction()) {
    mix.version();
}
