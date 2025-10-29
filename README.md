## Project Overview 
Ticketrax is a modern, responsive web application for managing support tickets and tasks. This version of the project focuses on server-side rendering (SSR) using a lightweight PHP framework approach and the Twig templating engine. The design prioritizes a clean, dark-themed user interface (UI) and accessible structure using Tailwind CSS and Semantic HTML.

## Goal Highlight
The core achievement of this version was building a robust, session-based authentication flow entirely on the server, ensuring protected routes are handled efficiently before rendering any UI.

## Key Technologies/Frameworks 
PHP
Twig
TailwindCSS
Manual Router
PHP Sessions


## Implemented Features 
1. Authentication System (Server-Rendered & Session-Based)
Core Authentication: A session-based authentication system handles all user state.

Login & Registration: Handled by dedicated endpoints (/auth/login, /auth/register) with form validation and credential storage in the $_SESSION['users'] array.

Protected Routes: Navigation to /dashboard and /tickets is strictly controlled by the isAuthenticated() function in the PHP router, redirecting unauthenticated users to the login page.

Flash Messages: Successful logins, registrations, and errors are handled via session variables ($_SESSION['success'], $_SESSION['error']) and displayed once on the subsequent page load.

2. Layouts and Structure
Layout Inheritance: Utilizes Twig's inheritance ({% extends %}) with base.html.twig (for public pages) and private_base.html.twig (for authenticated pages) to maintain structural consistency.

Dashboard Display: The dashboard fetches simulated statistics (total, open, closed) from the PHP controller and renders them using Twig macros to create reusable "StatCard" components, replicating the component-based approach of React.

3. UI/UX & Accessibility
Framer Motion Simulation: While Twig doesn't natively use Framer Motion, custom Tailwind utility classes were used to apply combined fade-in and slide-in animations to all major components (cards, forms) to honor the required UX style.

Semantic Markup: HTML elements (<main>, <section>, <nav>, <article>) are consistently used across all Twig templates for improved accessibility and search engine optimization (SEO).

Password Toggle: Implemented a client-side JavaScript function on the login and signup forms to toggle password visibility.
