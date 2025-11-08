<?php
/**
 * Database Configuration File
 * This file handles the database connection for the blog application
 */

// Load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set as environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
    return true;
}

// Load .env file from the current directory
loadEnv(__DIR__ . '/.env');

// Database credentials from environment variables
define('DB_HOST', getenv('DB_HOST') ?: 'localhost:3308');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'lastBlogProject');

/**
 * Get Database Connection
 * Returns a mysqli connection object
 */
function getDBConnection() {
    // Create new mysqli connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
     
    // Check if connection was successful
    if ($conn->connect_error) {
        // Log error instead of displaying it in production
        if (getenv('APP_ENV') === 'production') {
            error_log("Database connection failed: " . $conn->connect_error);
            die("Database connection failed. Please contact the administrator.");
        } else {
            die("Connection failed: " . $conn->connect_error);
        }
    }
    
    // Set charset to utf8mb4 for proper character support
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * Close Database Connection
 */
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>