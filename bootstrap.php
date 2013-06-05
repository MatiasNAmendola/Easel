<?php
function ifdefine($name, $definition) {
    if (!defined($name)) {
        define($name, $definition);
    }
}

function class_to_file($class_name) {
    return implode(explode('_', $class_name), '/').'.php';
}

ifdefine('ROOT', dirname(__FILE__).'/');
ifdefine('APP_DIR', ROOT);
ifdefine('LIB_DIR', ROOT.'lib/');

ifdefine('PHP_DIR', APP_DIR.'lib/');
ifdefine('TPL_DIR', APP_DIR.'templates/');
ifdefine('TMP_DIR', APP_DIR.'tmp/');
ifdefine('TPL_TMP_DIR', TMP_DIR.'templates');

spl_autoload_register(function($class_name) {
    $file = class_to_file($class_name);
    if (file_exists(LIB_DIR.$file)) {
        require_once(LIB_DIR.$file);
    } else if (file_exists(PHP_DIR.$file)) {
        require_once(PHP_DIR.$file);
    }
});

// Register the autoloader
require ROOT.'vendors/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();
