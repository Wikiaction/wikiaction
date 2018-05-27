var path =  require('path');

module.exports = {
  entry: {
    Wikiaction: "./app/assets/scripts/app.js",
    Vendor: "./app/assets/scripts/vendors.js"
  },
  output: {
    path: path.resolve(__dirname, "./app/temp/scripts"),
    filename: "[name].js"
  },
  module:{
    rules: [
      {
        loader: 'babel-loader',
        query: {
          presets: ['es2015']
        },
        test: /\.js$/,
        exclude: /node_modules/
      }
    ]
  }
}