const path = require("path");

module.exports = {
  name: "app",
  // devtool: "eval-source-map",
  entry: {
    app: "./src/index.js",
  },
  plugins: [...(process.env.REPORT ? [new BundleAnalyzerPlugin()] : [])],
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
