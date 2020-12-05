const path = require("path");

module.exports = {
  name: "app",
  // devtool: "eval-source-map",
  entry: {
    app: "./src/index.js",
  },
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
        test: /\.(png|jpg|svg|gif|ttf|woff)$/,
        loader: "url-loader",
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
