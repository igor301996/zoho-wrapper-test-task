<?php

if ( ! function_exists('redirect')) {
    function redirect(string $url, string $message)
    {
        $_SESSION['message'] = $message;
        header("Location: {$url}");
        exit;
    }
}

if ( ! function_exists('is_message')) {
    function is_message()
    {
        return isset($_SESSION['message']);
    }
}

if ( ! function_exists('get_message')) {
    function get_message()
    {
        $msg = $_SESSION['message'];
        $_SESSION['message'] = null;
        return $msg;
    }
}