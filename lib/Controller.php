<?php

class Controller {

    const ENGINE_MUSTACHE = 'mustache';
    const ENGINE_PHP = 'php';

    protected $__tpl_data = array();

    protected $engine = self::ENGINE_MUSTACHE;

    protected function getMustacheOpts() {
        return array(
            'cache_file_mode' => 0600,
            'cache' => TPL_TMP_DIR,
            'partials_loader' => new Mustache_Loader_FilesystemLoader(TPL_DIR),
        );
    }

    public function action($name) {
        $request = new HTTP_Request($_GET, $_POST, $_COOKIE, $_FILES);
        $response = new HTTP_Response();
        $user = $request->getUser();
        Feature::setUser($user);

        ob_start();
        if (in_array($name, $this->actions)) {
            $this->$name($request, $response);
        }
        ob_get_clean();
        $response->serve();
    }

    protected function render($tpl) {
        if ($this->engine == self::ENGINE_MUSTACHE) {
            $engine = new TemplateEngine_Mustache($this->getMustacheOpts());
        }
        if ($this->engine == self::ENGINE_PHP) {
            $engine = new TemplateEngine_PHP([]);
        }
        return $engine->render($tpl, $this->__tpl_data);
    }

    protected function assign($var, $value=array()) {
        if (is_string($var)) {
            $this->__tpl_data[$var] = $value;
        } else if (is_array($var)) {
            foreach ($var as $key => $val) {
                $this->assign($key, $val);
            }
        }
    }
}
