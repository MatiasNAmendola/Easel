<?php

class Controller_Home extends Controller {

    protected $actions = array(
        'index',
        'php',
    );

    public function index(HTTP_Request $req, HTTP_Response $resp) {
        $name = $req->getGet('name', 'Charles');
        if (Feature::isEnabled('megabarf')) {
            $this->assign('name', 'MegaBarf');
        } else {
            $this->assign('name', $name);
        }
        $resp->body = $this->render('hello');
    }

    public function php(HTTP_Request $req, HTTP_Response $resp){
        $this->engine = self::ENGINE_PHP;
        $this->index($req, $resp);
    }

}
