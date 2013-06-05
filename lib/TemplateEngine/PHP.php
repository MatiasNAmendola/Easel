<?php

class TemplateEngine_PHP extends TemplateEngine {

    public function render($tpl, $vars) {
        extract($vars);
        $path = TPL_DIR.'/pages/'.$tpl.'.php';
        ob_start();
        include $path;
        return ob_get_clean();
    }
}
