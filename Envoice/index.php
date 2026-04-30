<?php
require_once 'config/database.php';
require_once 'config/constants.php';
require_once 'classes/User.php';
require_once 'classes/Client.php';
require_once 'classes/Invoice.php';
require_once 'classes/Payment.php';

$db = Database::getInstance();
$userObj = new User($db);
$clientObj = new Client($db);
$invoiceObj = new Invoice($db);
$paymentObj = new Payment($db);

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$public_pages = ['home', 'login', 'signup', 'public_invoice', '404'];

if (!in_array($page, $public_pages) && !User::isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

// Basic Routing
switch ($page) {
    case 'home':
        include 'pages/home.php';
        break;
    case 'login':
        include 'pages/login.php';
        break;
    case 'signup':
        include 'pages/signup.php';
        break;
    case 'dashboard':
        include 'pages/dashboard.php';
        break;
    case 'clients':
        include 'pages/clients.php';
        break;
    case 'add_client':
        include 'pages/add_client.php';
        break;
    case 'edit_client':
        include 'pages/edit_client.php';
        break;
    case 'invoices':
        include 'pages/invoices.php';
        break;
    case 'create_invoice':
        include 'pages/create_invoice.php';
        break;
    case 'invoice_detail':
        include 'pages/invoice_detail.php';
        break;
    case 'public_invoice':
        include 'pages/public_invoice.php';
        break;
    case 'profile':
        include 'pages/profile.php';
        break;
    case 'logout':
        User::logout();
        header('Location: index.php?page=login');
        break;
    default:
        include 'pages/404.php';
        break;
}
