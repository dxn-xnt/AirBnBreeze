/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'airbnb-light': '#E3EED4',
        'airbnb-dark': '#375534',
        'airbnb-darkest': '#0F2A1D',
        'gold': '#F6B002',
      },
      fontFamily: {
        'righteous': ['Righteous', 'cursive'],
        'montserrat': ['Montserrat', 'sans-serif'],
      },
    },
  },
  plugins: [],
}