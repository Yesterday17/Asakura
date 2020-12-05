const path = require("path");

module.exports = {
  name: "app",
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
    ],
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "asakura-[name].js",
  },
};
