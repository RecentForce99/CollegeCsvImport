<?php

use Nikitq\Api\Controllers\Upload\UploadCsvFilesController;
use Slim\App;
use Slim\Views\PhpRenderer;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

ini_set('error_reporting', E_ALL & ~E_DEPRECATED);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new Slim\App($config);
$views = new PhpRenderer("resources/views");

// Define app routes
$app->get('/', function ($request, $response, $args) use ($views) {
    return $views->render($response, "welcome.php", $args);
});

$app->post('/api/upload/csv/', UploadCsvFilesController::class);

// Run app
$app->run();
?>