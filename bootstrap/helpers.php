<?php

use Illuminate\Support\Str;

if (!function_exists('get_mock')) {
    /**
     * Returns array to seed DB
     * @param $fileName
     * @param string $directory
     * @return array
     */
    function get_mock($fileName, $directory = 'database/mocks'): array
    {
        $fileName = Str::endsWith('.php', $fileName) ? $fileName : $fileName . '.php';
        $file = require base_path($directory . DIRECTORY_SEPARATOR . $fileName);

        return is_array($file) ? $file : [];
    }
}
