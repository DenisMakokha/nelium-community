/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html','./src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        navy: '#0B1035',
        blueA: '#0084C8',
        blueB: '#00B0E0',
        aqua: '#36C2E3',
        gold: '#FFD84D',
        gray9: '#0f172a'
      },
      boxShadow: { 
        soft: '0 10px 30px rgba(0,0,0,.15)' 
      },
      borderRadius: { 
        xl2: '1rem' 
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography')
  ]
}
