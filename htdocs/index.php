<?php
// key.php is a secret file containing a variable declaration, for the MAPS API key. You have to manually change it to yours.
require_once __DIR__.'/www/secret/key.php'; 

// Entry point so l'App engine can detect the webpage path
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require_once __DIR__.'/www/entry_form.php'; // If nothing is in the path, it displays the main form
        break;
    case '/makeroute':
        break;
    default:
        http_response_code(404);
        break;
}

?>
