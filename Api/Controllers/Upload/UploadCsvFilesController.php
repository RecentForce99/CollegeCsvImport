<?php

namespace Nikitq\Api\Controllers\Upload;

use Nikitq\Api\Services\Upload\PreparingCsvFilesToDBService;
use Nikitq\Api\Services\Upload\PreparingCsvFilesToUploadService;
use Nikitq\Api\Services\Upload\UploadCsvFilesToDirectoryService;
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

        $preparingCsvFilesToUploadServiceObj = new PreparingCsvFilesToUploadService($files['files']);
        $preparingCsvFilesToUploadServiceObj->prepareFiles();

        $preparedFilesToUpload = $preparingCsvFilesToUploadServiceObj->getPreparedFiles();
        $failedFilesDuringUploadToDirectoryPreparation = $preparingCsvFilesToUploadServiceObj->getFailedFiles();


        $uploadCsvFilesToDirectoryObj = new UploadCsvFilesToDirectoryService($preparedFilesToUpload);
        $uploadCsvFilesToDirectoryObj->uploadFiles();

        $uploadedFiles = $uploadCsvFilesToDirectoryObj->getUploadedFiles();
        $failedFilesDuringUploading = $uploadCsvFilesToDirectoryObj->getFailedFiles();

        $addCsvFilesToDBServiceObj = new PreparingCsvFilesToDBService($uploadedFiles);
        $addCsvFilesToDBServiceObj->prepareFiles();

        $preparedFilesToSaveToDB = $addCsvFilesToDBServiceObj->getPreparedFiles();
        $failedFilesDuringSaveToDBPreparation = $addCsvFilesToDBServiceObj->getFailedFiles();
print_r($preparedFilesToSaveToDB);
        return $response;
    }
}