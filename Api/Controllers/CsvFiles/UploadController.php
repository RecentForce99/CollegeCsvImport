<?php

namespace Nikitq\Api\Controllers\CsvFiles;

use Nikitq\Api\DTO\CsvFileUploadDTO;
use Nikitq\Api\Helpers\BytesConverter;
use Nikitq\Api\Services\CsvFiles\Upload\AddCsvFilesToDBService;
use Nikitq\Api\Services\CsvFiles\Upload\PreparingCsvFilesToDBService;
use Nikitq\Api\Services\CsvFiles\Upload\PreparingCsvFilesToUploadService;
use Nikitq\Api\Services\CsvFiles\Upload\UploadCsvFilesToDirectoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController
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


        $preparingCsvFilesToDBServiceObj = new PreparingCsvFilesToDBService($uploadedFiles);
        $preparingCsvFilesToDBServiceObj->prepareFiles();

        $preparedFilesToSaveToDB = $preparingCsvFilesToDBServiceObj->getPreparedFiles();
        $failedFilesDuringSaveToDBPreparation = $preparingCsvFilesToDBServiceObj->getFailedFiles();


        $addCsvFilesToDBServiceObj = new AddCsvFilesToDBService($preparedFilesToSaveToDB);
        $addCsvFilesToDBServiceObj->uploadFiles();

        $successFiles = $addCsvFilesToDBServiceObj->getSuccessFiles();
        $failedFilesDuringAddingFilesToDB = $addCsvFilesToDBServiceObj->getFailedFiles();

        $files = array_merge(
            $failedFilesDuringUploadToDirectoryPreparation,
            $failedFilesDuringUploading,
            $failedFilesDuringSaveToDBPreparation,
            $failedFilesDuringAddingFilesToDB,
            $successFiles
        );

        $result = $this->getResult($files);

        return $response->withJson($result);
    }

    private function getResult(array $files): array
    {
        $result = [];
        foreach ($files as $file) {
            $result[] = $this->getResultFileMap($file);
        }

        return $result;
    }

    private function getResultFileMap(CsvFileUploadDTO $file): array
    {
        return [
            'name' => $file->getName(),
            'size' => BytesConverter::convert($file->getSize()),
            'statusCode' => $file->getStatusCode(),
            'statusText' => $file->getStatusText(),
        ];
    }
}