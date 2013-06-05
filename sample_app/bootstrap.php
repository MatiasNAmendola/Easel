<?php
// Define where the app root is
define('APP_DIR', dirname(__FILE__).'/');
// Require the lib boostrapper. Normally it won't be relative to this
// file, but you know ...
$boot = realpath(dirname(dirname(__FILE__))."/bootstrap.php");
require $boot;

if (false) {
    // Would normally be some indicator of a production env
    define('CONFIG', PHP_DIR.'/Config/production.php');
} else {
    define('CONFIG', PHP_DIR.'./Config/development.php');
}
