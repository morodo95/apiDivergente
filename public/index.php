<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
require __DIR__ . '/../vendor/autoload.php';
session_start();
// Instantiate the app
$app = new \Slim\App;
// Run app


$app->get('/home', function ($request, $response, $args) {
    // Use app HTTP cookie service
    echo 'Hola Mundo';
});
$app->run();