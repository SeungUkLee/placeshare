
const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


var bootstrap_sass = './node_modules/bootstrap-sass/';


elixir((mix) => {
    mix.sass('app.scss');
    mix.webpack('app.js');

    mix.scripts([
        '../../../public/js/app.js',
        '../../../node_modules/select2/dist/js/select2.js',
        '../../../node_modules/dropzone/dist/dropzone.js',
        '../../../node_modules/jquery-tabby/jquery.textarea.js',
    ], 'public/js/app.js');

    mix.version([
        'css/app.css',
        'js/app.js'
    ]);
    mix.copy(bootstrap_sass+"assets/fonts/bootstrap",'public/fonts');
    mix.copy('node_modules/font-awesome/fonts','public/build/fonts');
});


// const elixir = require('laravel-elixir');
//
// // require('laravel-elixir-vue-2');
//
// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for your application as well as publishing vendor resources.
//  |
//  */
//
// // elixir((mix) => {
// //     mix.sass('app.scss')
// //        .webpack('app.js');
// // });
//
// // mix.scripts([
// //     // ...,
// //     '../../../node_modules/select2/dist/js/select2.js',
// //     '../../../node_modules/dropzone/dist/dropzone.js'
// // ], 'public/js/app.js');
//
// // elixir(function (mix) {
// //     mix
// //         .sass('app.scss', 'resources/assets/css')
// //         .styles([
// //             'app.css',
// //             '../vendor/dropzone/dist/dropzone.css'
// //         ], 'public/css/app.css')
// //         .scripts([
// //             // Other JS Libraries
// //             '../vendor/dropzone/dist/dropzone.js',
// //             'app.js'
// //         ], 'public/js/app.js')
// //     // ...
// // });
//
// elixir(function (mix) {
//     // mix
//     //     .sass('app.scss')
//     //     .scripts([
//     //         '../vendor/jquery/dist/jquery.js',
//     //         '../vendor/bootstrap-sass/assets/javascripts/bootstrap.js',
//     //         'app.js'
//     //     ], 'public/js/app.js')
//     //     .version([
//     //         'css/app.css',
//     //         'js/app.js'
//     //     ])
//     //     .copy("resources/assets/vendor/font-awesome/fonts", "public/build/fonts");
//     mix.sass('app.scss', 'resources/assets/css')
//         .styles([
//             'app.css',
//             '../vendor/dropzone/dist/dropzone.css',
//             '../vendor/earthsong.css',
//         ], 'public/css/app.css');
//
//
//     mix.scripts([
//         // ...,
//         // '../../../node_modules/select2/dist/js/select2.js',
//         // '../../../node_modules/dropzone/dist/dropzone.js'
//         '../vendor/select2/dist/js/select2.js',
//         '../vendor/dropzone/dist/dropzone.js',
//     ], 'public/js/app.js');
//
// });
