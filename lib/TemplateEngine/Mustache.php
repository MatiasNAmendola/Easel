<?php

class TemplateEngine_Mustache extends TemplateEngine {

    public function render($tpl, $vars) {
        $path = TPL_DIR.'pages/'.$tpl.'.mustache';
        if (file_exists($path)) {
            $engine = new Mustache_Engine($this->opts);
            $tpl = file_get_contents($path);
            return $engine->render($tpl, $vars);
        }
    }

}
