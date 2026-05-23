/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        'unbounded': ['"Unbounded"', 'sans-serif'],
        'spectral': ['"Spectral"', 'serif'],
      },
    },
  },
  plugins: [],
}
