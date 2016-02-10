<?php
/**
 *
 *
 * @author Sam Schmidt <samuel@dersam.net>
 * @since 2016-02-01
 */

echo getcwd().PHP_EOL;

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
} else {
    include 'vendor/autoload.php';
}
