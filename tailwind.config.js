/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. CONTENT: Must use relative paths from the project root
  content: [
    // This scans all your Twig templates
    "./templates/**/*.html.twig",
    // This correctly points to the index.php inside the public directory
    "./public/index.php",
  ],

  // 2. THEME: (Keep your custom colors as they are correct)
  theme: {
    extend: {
      colors: {
        "app-bg": "#0F172A",
        "card-bg": "#1E293B",
        "nav-bg": "#1E293B",
        "primary-blue": "#3B82F6",
        "success-green": "#10B981",
        "in-progress-amber": "#F59E0B",
        "closed-gray": "#6B7280",
      },
      fontFamily: {
        sans: ["Bricolage Grotesque", "sans-serif"], // ✅ Add fallback
      },
    },
  },
  plugins: [],
};
