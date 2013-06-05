<?php

class Controller_Home extends Controller {

    protected $actions = array(
        'index',
    );

    public function index(HTTP_Request $req, HTTP_Response $response) {
        $name = $req->getGet('name', 'Charles');
        if (Feature::isEnabled('megabarf')) {
            $this->assign('name', 'MegaBarf');
        } else {
            $this->assign('name', $name);
        }
        $response->body = $this->render('hello');
    }

}
