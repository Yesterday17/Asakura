const path = require("path");
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  name: "app",
  // devtool: "eval-source-map",
  entry: {
    app: "./src/index.js",
  },
  // plugins: [new MiniCssExtractPlugin({ filename: "asakura-[name].css" })],
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
        test: require.resolve("highlight.js"),
        loader: "expose-loader",
        options: {
          exposes: ["hljs"],
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
