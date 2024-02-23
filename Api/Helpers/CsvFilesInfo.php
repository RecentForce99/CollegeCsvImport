<?php

namespace Nikitq\Api\Helpers;

class CsvFilesInfo
{
    public const UPLOADS_BASE_DIRECTORY = '/uploads/csv';
    public const STATUS_FAIL = false;

    public const SUCCESS_TEXT = 'Файл успешно загружен';

    public const CODE = 'text/csv';
    public const EXTENSION = '.csv';
    public const MAX_SIZE = 5242880;
}