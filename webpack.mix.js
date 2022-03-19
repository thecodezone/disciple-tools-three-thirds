let mix = require('laravel-mix');

mix.js('magic-link/App.jsx', 'dist')
  .react()
  .setPublicPath('dist');
