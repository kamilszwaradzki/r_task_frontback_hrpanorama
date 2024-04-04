<?php
$request = $_SERVER['REQUEST_URI'];

if($request == '/createPdf') {
    require_once 'createPdf.php';
} else {
    http_response_code(404);
    return false;
}
