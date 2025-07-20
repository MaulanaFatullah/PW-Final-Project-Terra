/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'choco': {
          900: '#3c2414',
          800: '#5D3A1A',
          700: '#7e4e20',
          600: '#9f6226',
          500: '#c0762c',
          400: '#e18a32',
          300: '#f4a261',
          200: '#f4a261',
          100: '#f9dcc4',
        }
      }
    },
  },
  plugins: [],
}
