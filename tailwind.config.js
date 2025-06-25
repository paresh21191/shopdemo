module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
      },
      colors: {
        brandIndigo: '#4c51bf',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}