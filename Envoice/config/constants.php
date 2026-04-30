<?php
define('APP_NAME', 'Envoice');
define('BASE_URL', 'http://localhost/Envoice/'); // Adjust based on your local server setup
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
