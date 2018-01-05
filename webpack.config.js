// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create web/build/app.js and web/build/app.css
    .addEntry('app', './assets/js/app.js')
    .addEntry('dashboard', './assets/js/chart.js')
    .addEntry('search', './assets/js/search.js')

    // allow sass/scss files to be processed
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // create hashed filenames (e.g. app.abc123.css)
    //.enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();