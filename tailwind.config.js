/** @type {import('tailwindcss').Config} */
export default {
  content: ['./resources/views/**/*.blade.php'],
  theme: {
    extend: {},
  },
  plugins: [],
  purge: {
    content: ['./resources/js/**/*.js', './resources/**/*.blade.php'],
    options: {
      safelist: [],
    },
  },
}