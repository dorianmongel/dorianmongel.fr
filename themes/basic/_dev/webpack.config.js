// webpack.config.js
const path                  = require('path');
var entry                   = require('webpack-glob-entry');
const MiniCssExtractPlugin  = require("mini-css-extract-plugin");
const FileManagerPlugin     = require('filemanager-webpack-plugin');


module.exports = (env, argv) => [
  
  
  
  // STYLE & SCRIPT ACF - OK
  {
  entry:  {
    script: './js/main.js',
    style: './scss/style.scss'
  },
    
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, '../'),
  },

  module: {
    rules: [
      
      // JS
      { 
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader",
        generator: { 
          filename(resourcePath, resourceQuery) {
            return  'main.js';
          },
      },
      type: 'asset/resource',
      },
      
    
      
      // SCSS
      {
        test: /\.scss$/,
        use: [
          { 
            loader: MiniCssExtractPlugin.loader 
          },

          { loader: "css-loader",
            options: {
              importLoaders: 1
            } 
          },   

         {
           loader: 'postcss-loader',
          },
            
          { 
            loader: "sass-loader",
            options: {
              sourceMap: true,
              sassOptions: {
                outputStyle: "compressed",
              },
            }
          }

        ]
      },
      

      
       //IMG
       {
        test: /\.(png|jpg|jpeg|gif|svg)$/,
        generator: { 
            filename(resourcePath, resourceQuery) {
              return '../img/[name][ext]';
            },
        },
        type: 'asset/resource',
      }
      

    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename:       "style.css"
    }),
    ]
},





];