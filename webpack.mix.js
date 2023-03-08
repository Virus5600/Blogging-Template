const mix = require('laravel-mix');
const path = require('path');

const paths = {
	js: {
		base: `resources/js`
	},
	sass: {
		base: `resources/sass`,
		app: `resources/sass/app`,
		layouts: `resources/sass/app/layouts`
	}
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
		resolve: {
			alias: {
				jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js'),
				jQuery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js')
			}
		},
		devtool: 'inline-source-map'
	})
	.js(`${paths.js.base}/libs.js`, 'public/js')
	.sass(`${paths.sass.base}/libs.scss`, 'public/css')
	// APP RELATED STYLESHEETS
	.sass(`${paths.sass.app}/components.scss`, 'public/css')
	.sass(`${paths.sass.layouts}/general.scss`, 'public/css/layouts')
	.sourceMaps()
	.disableNotifications();