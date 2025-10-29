<?php
// FILE: index.php (Minimal PHP Front Controller)

error_reporting(E_ALL);
ini_set('display_errors', 1);

// In public/index.php:
require_once(__DIR__ . '/../vendor/autoload.php'); 
// Path resolves to: .../public/../vendor/autoload.php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// 1. Twig Initialization
// In public/index.php (Line 15)
// In public/index.php (Line 15)
$loader = new FilesystemLoader(__DIR__ . '/../templates'); 
// Path correctly resolves to: .../ticket-management-app-twig/templates (CORRECT)plates (DOES NOT EXIST)
$twig = new Environment($loader);

// Start Session for Authentication
session_start();

// --- AUTHENTICATION & SECURITY IMPLEMENTATION ---
const SESSION_KEY = 'ticketapp_session';
const TEST_TOKEN = 'VALID_MOCK_TOKEN_12345';

function isAuthenticated(): bool {
    // Check localStorage (simulated by checking session)
    return isset($_SESSION[SESSION_KEY]) && $_SESSION[SESSION_KEY] === TEST_TOKEN;
}

function redirect(string $path) {
    header("Location: $path");
    exit;
}

// 2. Simulated Ticket Data (CRUD data source)
$tickets = [
    // Data matches the required card style and status rules
    ['id' => 1, 'title' => 'Authentication Flow Test', 'description' => 'Confirmed that the new logout function clears the session correctly.', 'status' => 'closed', 'priority' => 'medium'],
    ['id' => 2, 'title' => 'Update Button Styling', 'description' => 'The primary blue button...', 'status' => 'in_progress', 'priority' => 'high'],
    ['id' => 3, 'title' => 'Database Migration Failure', 'description' => 'The nightly migration script failed...', 'status' => 'open', 'priority' => 'high'],
    ['id' => 4, 'title' => 'Server Down', 'description' => 'Needs investigation.', 'status' => 'open', 'priority' => 'medium'],
    ['id' => 5, 'title' => 'Website Content Update', 'description' => 'Check new marketing copy.', 'status' => 'closed', 'priority' => 'low'],
];

// 3. Manual Router
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = $requestUri === '/' ? '/' : rtrim($requestUri, '/');

// --- Handle Authentication Actions (Simulated) ---
if ($path === '/auth/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simplified Login Logic
    $email = $_POST['email'] ?? '';
    if ($email === 'test@user.com' && ($_POST['password'] ?? '') === 'password') {
        $_SESSION[SESSION_KEY] = TEST_TOKEN; // Set mock token
        redirect('/dashboard');
    } else {
        $_SESSION['error'] = "Invalid credentials or user not found.";
        redirect('/auth/login');
    }
} elseif ($path === '/logout') {
    session_destroy();
    redirect('/'); // Logout should clear session and return to landing page
}

// --- Define Template Data & Security Checks ---
$data = ['page_name' => '', 'error' => $_SESSION['error'] ?? null];
unset($_SESSION['error']); // Clear one-time error message

$template = '';

// Protected Routes Array
$protectedRoutes = ['/dashboard', '/tickets'];
$isProtected = in_array($path, $protectedRoutes);

if ($isProtected && !isAuthenticated()) {
    // Unauthorized access must redirect users to /auth/login
    $_SESSION['error'] = "Your session has expired — please log in again.";
    redirect('/auth/login');
}

switch ($path) {
    case '/':
        $template = 'views/landing_page.html.twig';
        $data['page_name'] = 'Welcome';
        break;

    case '/auth/login':
    case '/auth/register':
        $template = 'views/auth_screen.html.twig';
        $data['page_name'] = (strpos($path, 'login') !== false) ? 'Login' : 'Register';
        $data['form_type'] = (strpos($path, 'login') !== false) ? 'login' : 'register';
        break;

    case '/dashboard':
        $template = 'views/dashboard.html.twig';
        $data['page_name'] = 'Dashboard';
        $data['stats'] = [ // Dashboard statistics
            'total' => count($tickets),
            'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
            'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed')),
        ];
        break;

    case '/tickets':
        $template = 'views/ticket_management.html.twig';
        $data['page_name'] = 'Ticket Management';
        $data['tickets'] = $tickets; // Pass the simulated data
        break;

    default:
        http_response_code(404);
        $template = 'views/404.html.twig';
        $data['page_name'] = '404';
        break;
}

// 4. Render the Template
try {
    echo $twig->render($template, $data);
} catch (\Exception $e) {
    http_response_code(500);
    echo "Fatal Render Error: " . $e->getMessage();
}   