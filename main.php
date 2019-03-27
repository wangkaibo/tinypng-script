<?php
require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
Tinify\setKey(getenv('YOUR_TINYPNG_API_KEY'));
$dir = getenv('ORIGINAL_DIR');
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $fullFile = $dir . DIRECTORY_SEPARATOR . $file;
            $extension = strtolower(pathinfo($fullFile)['extension'] ?? '');
            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                $tinypngFullFile = $dir . DIRECTORY_SEPARATOR . 'tinypng-' . $file;
                Tinify\fromFile($fullFile)->toFile($tinypngFullFile);
            }
        }
        closedir($dh);
    }
} else {
    throw new \Exception('dir not found');
}

