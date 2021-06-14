/* eslint-disable */

const cssnanoConfig = {
  preset: ['default', { discardComments: { removeAll: true } }]
};

module.exports = ({ file, options }) => {
  return {
    parser: options.enabled.optimize ? 'postcss-safe-parser' : undefined,
    plugins: {
      autoprefixer: { overrideBrowserslist: ['last 4 versions'] },
      cssnano: options.enabled.optimize ? cssnanoConfig : false,
    },
  };
};
