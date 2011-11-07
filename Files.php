<?php
/**
 * Get file extension
 *
 * @param string $filename
 * @return string
 */
function getFileExtension($filename) {

    return strtolower(substr(strrchr($filename, '.'), 1));
}

/**
 * Get convert file size from something (default byte(s)) to International System of Units (SI) (byte(s), KB, MB, GB, TB, PB, EB)
 *
 * @param integer $value
 * @param string $fromType
 * @return string
 */
function fileSizeConvert($size, $fromType = "b") {

    $i = 0;
    while ($size > 1023) {
        $size /= 1024;
        $i++;
    }

    $type = array('byte(s)', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

    return number_format($size, 4, '.', '') . " " . t($type[array_search($fromType, array('b' => 0, 'k' => 1, 'm' => 2, 'g' => 3, 't' => 4, 'p' => 5, 'e' => 6)) + $i]);
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
    }
    return rmdir($dir);
}

function copyDirectory($src, $dst) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                copyDirectory($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}