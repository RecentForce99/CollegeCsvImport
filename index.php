<?php

use Nikitq\Api\Controllers\CsvFiles\DetailController;
use Nikitq\Api\Controllers\CsvFiles\ListController;
use Nikitq\Api\Controllers\CsvFiles\UploadController;
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
$app->get('/csv/list/', function ($request, $response, $args) use ($views) {
    $listControllerObj = new ListController();
    return $views->render($response, "/csv/list.php", $listControllerObj->getFiles());
});
$app->get('/csv/list/{id}/', function ($request, $response, $args) use ($views) {
    $detailControllerObj = new DetailController();
    return $views->render($response, "/csv/detail.php", $detailControllerObj->getFiles($args['id']));
});

$app->post('/api/upload/csv/', UploadController::class);

// Run app
$app->run();
?>