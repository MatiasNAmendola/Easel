<?php

class HTTP_Request {

    public function __construct($get, $post, $cookies, $files) {
        $this->get = $get;
        $this->post = $post;
        $this->cookies = $cookies;
        $this->files = $files;
    }

    public function getUser() {
        if (!empty($this->cookies[User::COOKIE])) {
            return new User($this->cookies[User::COOKIE]);
        }
        // Create a uaid
        $uaid = md5(uniqid().microtime().rand());
        setcookie(User::COOKIE, $uaid);
        return new User($uaid);
    }


    public function getGet($var, $default='') {
        return $this->_get($this->get, $var, $default);
    }

    public function getPost($var, $default='') {
        return $this->_get($this->post, $var, $default);
    }

    protected function _get($array, $var, $default) {
        if (isset($array[$var])) {
            return $array[$var];
        }
        return $default;
    }

}
