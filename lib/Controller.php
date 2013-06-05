<?php

class Controller {

    protected $__tpl_data = array();

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

        //ob_start();
        if (in_array($name, $this->actions)) {
            $this->$name($request, $response);
        }
        //ob_get_clean();
        $response->serve();
    }

    protected function render($tpl) {
        $path = TPL_DIR.'pages/'.$tpl.'.mustache';
        if (file_exists($path)) {
            $engine = new Mustache_Engine($this->getMustacheOpts());
            $tpl = file_get_contents($path);
            return $engine->render($tpl, $this->__tpl_data);
        }
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
