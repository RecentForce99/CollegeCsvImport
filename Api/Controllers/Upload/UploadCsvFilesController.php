<?php

namespace Nikitq\Api\Controllers\Upload;

use Nikitq\Api\Services\Upload\PreparingCsvFilesToUploadService;
use Nikitq\Api\Services\Upload\UploadCsvFilesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadCsvFilesController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $files = $request->getUploadedFiles();
        if (empty($files) || empty($files['files'])) {
            return $response;
        }

        $preparedFiles = (new PreparingCsvFilesToUploadService())->getFiles($files['files']);
        (new UploadCsvFilesService($files))->uploadFiles($preparedFiles);

        return $response;
    }
}