/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. CONTENT: Scans all Twig files for classes
  content: [
    // Must scan all files in the templates folder recursively
    "./templates/**/*.html.twig",
    // Include the root PHP file for any logic-based classes
    "./index.php",
  ],

  // 2. THEME: Defines custom colors for consistency
  theme: {
    extend: {
      colors: {
        "app-bg": "#0F172A",
        "card-bg": "#1E293B",
        "nav-bg": "#1E293B",

        // 🎯 Branding Colors (used for consistency mandate)
        "primary-blue": "#3B82F6", // Used for main buttons/links

        // 🎯 Status Colors (used for status tag mandate)
        "success-green": "#10B981", // open → Green tone
        "in-progress-amber": "#F59E0B", // in_progress → Amber tone
        "closed-gray": "#6B7280", // closed → Gray tone
      },
    },
  },
  plugins: [],
};
