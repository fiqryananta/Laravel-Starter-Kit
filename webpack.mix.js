const mix = require('laravel-mix');
const glob = require('glob');

mix.copyDirectory('resources/backend/css', 'public/backend/css');
mix.copyDirectory('resources/backend/fonts', 'public/backend/fonts');
mix.copyDirectory('resources/backend/images', 'public/backend/images');
mix.copyDirectory('resources/backend/js', 'public/backend/js');
mix.copyDirectory('resources/backend/scss', 'public/backend/scss');

mix.disableNotifications();

if (mix.inProduction()) {
    mix.version();
}