let mix = require('laravel-mix');

mix.js('magic-link/App.jsx', 'dist')
  .sass('magic-link/styles/styles.scss','dist')
  .options({ processCssUrls: false })
  .react()
