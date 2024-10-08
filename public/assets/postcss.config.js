const purgecss = require('@fullhuman/postcss-purgecss');
const cssnano = require('cssnano');

module.exports = {
  plugins: [
    purgecss({
      content: ['../../modules/**/*.php', '../../app/**/*.php'],
      css: ['./css/style.min.css', './css/custom.min.css'],
      safelist: {
        standard: [/tooltip/, /tabulator/, /icon/, "fade", "show"],
        deep: [/tooltip/, /tabulator/],
        greedy: [/tooltip/, /tabulator/, /mini-sidebar/, /popper/, /was-validated/]
      }
    }),
    cssnano({
      preset: ['default', {
          discardComments: {
              removeAll: true,
          },
      }]
    })
  ]
}