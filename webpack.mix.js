let mix = require('laravel-mix');
require('node-env')

mix.js('magic-link/App.jsx', 'dist')
  .js('magic-link/Login.jsx', 'dist')
  .sass('magic-link/styles/styles.scss','dist')
  .options({ processCssUrls: false })
  .react()

if (process.env.WP_URL) {
  mix.browserSync({
    proxy: process.env.WP_URL,
    files: [
      './dist/foundation.css',
      './dist/styles.css',
      './dist/app.js',
      './**/*.php'
    ]
  })
}
