var webpack = require('webpack');
module.exports = {
    entry: './src/assets/ts/app.ts',
    output: {
        filename: 'public/js/bundle.js'
    },
    devtool: 'source-map',
    resolve: {
        extensions: ['', '.webpack.js', '.web.js', '.ts', '.js'],
    },
    plugins: [
        new webpack.ProvidePlugin({
            "$": "jquery",
            "jQuery": "jquery",
            "window.jQuery": "jquery",
            "Cookies": "js-cookie"
        }),
    new webpack.optimize.UglifyJsPlugin({
        minimize: true
    })
    ],
    module: {
        loaders: [
            {test: /\.ts$/, loader: 'ts-loader'}
        ]
    }
}