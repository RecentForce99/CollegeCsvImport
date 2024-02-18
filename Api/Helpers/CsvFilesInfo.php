<?php

namespace Nikitq\Api\Helpers;

class CsvFilesInfo
{
    public const STATUS_SUCCESS = true;
    public const STATUS_FAIL = false;

    public const SUCCESS_TEXT = 'Файл успешно загружен';

    public const CSV_CODE = 'text/csv';
    public const MAX_CSV_SIZE = 5242880;
}