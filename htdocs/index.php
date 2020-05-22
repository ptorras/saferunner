<?php
require_once __DIR__.'/www/secret/key.php';
// Entry point per a que l'App engine detecti els path
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require_once __DIR__.'/www/entry_form.php';
        break;
    case '/makeroute':
        break;
    case '/test':
        require_once __DIR__.'/www/test.php';
        break;
    default:
        http_response_code(404);
        break;
}

?>