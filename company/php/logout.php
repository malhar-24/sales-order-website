<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Send response indicating successful logout
http_response_code(200);
?>