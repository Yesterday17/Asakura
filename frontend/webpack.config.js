const path = require("path");
const { BundleAnalyzerPlugin } = require("webpack-bundle-analyzer");
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  name: "app",
  // devtool: "eval-source-map",
  entry: {
    app: "./src/index.js",
  },
  plugins: [
    ...(process.env.REPORT ? [new BundleAnalyzerPlugin()] : []),
    // new MiniCssExtractPlugin({ filename: "asakura-[name].css" }),
  ],
  module: {
    rules: [
      {
        test: require.resolve("jquery"),
        loader: "expose-loader",
        options: {
          exposes: ["$", "jQuery"],
        },
      },
      {
        test: /\.(png|jpg|svg|gif|ttf|woff|woff2|eot)$/,
        loader: "file-loader",
        // loader: "url-loader",
      },
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "asakura-[name].js",
  },
};
