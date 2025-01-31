<?php

function sanitize($input) {
    // Trim and remove HTML tags
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}