/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue"
  ],
  theme: {
    extend: {
      fontFamily: {
        serif: ['"Averia Serif Libre"', 'serif'], // use as 'font-serif'
        averia: ['"Averia Serif Libre"', 'serif'], // optional custom name
      },
      colors: {
        choco: {
          900: "#2B120B", // dark brown (paling kiri)
          800: "#5E3124",
          700: "#915A4A",
          600: "#C48D7D",
          500: "#F7CABD",
          400: "#FFE5DE",
          300: "#FFFAF9",
          100: "#fffafa" // putih banget
        }
      },
    },
  },
  plugins: [],
}
